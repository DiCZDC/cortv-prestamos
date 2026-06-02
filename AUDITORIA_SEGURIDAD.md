# Auditoría de Seguridad — cortv-prestamos

> **Fecha:** 2026-06-02  
> **Stack:** Laravel 12 · Livewire 4 · Flux UI · Spatie Permissions · PostgreSQL  
> **Propósito del sistema:** Gestión de préstamos de equipos institucionales  

---

## Índice

1. [Resumen ejecutivo](#1-resumen-ejecutivo)
2. [Vulnerabilidades críticas](#2-vulnerabilidades-críticas)
3. [Vulnerabilidades altas](#3-vulnerabilidades-altas)
4. [Vulnerabilidades medias](#4-vulnerabilidades-medias)
5. [Vulnerabilidades bajas](#5-vulnerabilidades-bajas)
6. [Consultas con problema N+1](#6-consultas-con-problema-n1)
7. [Solicitudes rechazadas — Ejemplos Postman](#7-solicitudes-rechazadas--ejemplos-postman)
8. [Plan de remediación](#8-plan-de-remediación)

---

## 1. Resumen ejecutivo

| Severidad | Cantidad |
|-----------|----------|
| Crítica   | 3        |
| Alta      | 4        |
| Media     | 9        |
| Baja      | 5        |
| **Total** | **21**   |

El sistema cuenta con una base sólida: usa ORM Eloquent (sin SQL crudo), RBAC con Spatie Permissions, protección CSRF nativa de Livewire y transacciones de base de datos con bloqueo de filas en operaciones críticas. Sin embargo, existen tres problemas **críticos** que deben resolverse antes de cualquier despliegue en producción.

---

## 2. Vulnerabilidades críticas

### C-01 — Archivo `.env` comprometido en el repositorio

**Archivos:** `.env`, `.gitignore`

El archivo `.env` está siendo rastreado por Git, exponiendo credenciales activas en el historial del repositorio.

```
APP_KEY=base64:GWpAQmx9NhxoTRC0/9X1PTbOftv11V2FFP/trUXZn/c=
DB_PASSWORD=5691323
DB_USERNAME=postgres
DB_DATABASE=cortv_prestamos
```

**Impacto:** Cualquier persona con acceso al repositorio puede obtener la clave de cifrado de sesiones, credenciales de base de datos y configuración completa del entorno.

**Remediación:**

```bash
# 1. Agregar al .gitignore
echo ".env" >> .gitignore

# 2. Eliminar del índice de Git (sin borrar el archivo local)
git rm --cached .env
git commit -m "chore: remove .env from version control"

# 3. Regenerar la APP_KEY
php artisan key:generate

# 4. Cambiar la contraseña de base de datos
# En PostgreSQL:
ALTER USER postgres WITH PASSWORD 'nueva_contrasena_segura';
```

---

### C-02 — `APP_DEBUG=true` en entorno de producción

**Archivo:** `.env`

El modo debug expone stack traces completos al navegador cuando ocurre cualquier excepción, revelando rutas del servidor, estructura de la base de datos, variables de entorno y lógica interna.

**Remediación:**

```ini
# .env
APP_DEBUG=false
APP_ENV=production
```

---

### C-03 — Contraseña de base de datos débil

**Archivo:** `.env`

```
DB_PASSWORD=5691323
```

La contraseña es completamente numérica y de baja entropía. Combinado con el usuario por defecto `postgres`, representa un vector de ataque trivial si el puerto de PostgreSQL está expuesto.

**Remediación:** Usar una contraseña generada con alta entropía (mínimo 24 caracteres alfanuméricos + símbolos) y considerar un usuario dedicado con permisos mínimos:

```sql
CREATE USER cortv_app WITH PASSWORD 'X7k#mP2$qR9nL4wZ...';
GRANT CONNECT ON DATABASE cortv_prestamos TO cortv_app;
GRANT USAGE ON SCHEMA public TO cortv_app;
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO cortv_app;
```

---

## 3. Vulnerabilidades altas

### A-01 — Enumeración de recursos por ID secuencial sin verificación de propietario

**Archivos:** `app/Http/Controllers/PrestamoController.php:120`, `ArchivoController.php`, `RecepcionController.php`, `EntregaController.php`, `PersonalController.php`, `CalendarioController.php`

Todos los métodos `show($id)` aceptan el parámetro de ruta sin verificar que el recurso pertenezca al usuario autenticado:

```php
// PrestamoController.php — línea 120
public function show($id)
{
    return view('vistas.prestamo.show', ['id' => $id]);
    // ❌ No se verifica que $id exista
    // ❌ No se verifica que el usuario tenga acceso a ese recurso
}
```

Un usuario `trabajador` puede acceder a `/archivo/1`, `/archivo/2`, `/archivo/3` ... e iterar sobre todas las solicitudes de la organización.

**Remediación:**

```php
public function show($id)
{
    $solicitud = Solicitud::findOrFail($id); // 404 si no existe

    // Verificar propiedad o rol de admin
    if (!Auth::user()->hasRole('admin') && $solicitud->id_trabajador !== Auth::id()) {
        abort(403);
    }

    return view('vistas.prestamo.show', ['id' => $id]);
}
```

---

### A-02 — Método `update` ejecuta lógica después de validar estado inválido

**Archivo:** `app/Http/Controllers/PrestamoController.php:74-98`

```php
public function update(Request $request)
{
    // ...validación...

    Solicitud::where('id', $validated['solicitud_id'])->update([...]);  // ← Se ejecuta SIEMPRE

    Notification::send(                                                   // ← Se envía SIEMPRE
        Solicitud::find($validated['solicitud_id'])->trabajador,
        new solicitud_notification(...)
    );

    if (!in_array($estado, ['Autorizada', 'Rechazada'])) {
        return response()->json(['error' => 'Estado no válido para esta acción.'], 400);
        // ❌ La validación de estado llega DESPUÉS de modificar la BD y enviar notificaciones
    }
}
```

El estado se actualiza en la base de datos y se envía la notificación **antes** de que se valide si el estado es válido para esa acción. Un atacante puede forzar estados como `Entregada` o `Devuelta` directamente desde el formulario.

**Remediación:** Mover la validación de estado al bloque `validate()` inicial:

```php
$validated = $request->validate([
    'solicitud_id' => ['required', 'exists:solicituds,id'],
    'estado'       => ['required', 'in:Autorizada,Rechazada'],  // ← solo estados permitidos
    'id_admin'     => ['required', 'exists:users,id'],
]);
```

---

### A-03 — `Log` no importado en el manejador de fallos del Job

**Archivo:** `app/Jobs/ProcesarRecordatorios.php:171-173`

```php
public function failed(\Throwable $exception): void
{
    Log::error('Error al procesar recordatorios: '.$exception->getMessage());
    // ❌ 'use Illuminate\Support\Facades\Log;' no está en los imports
}
```

Cuando el job falla, el método `failed()` lanza un `Error: Class "Log" not found`, ocultando el error original y potencialmente dejando el proceso de recordatorios silenciosamente roto.

**Remediación:** Agregar el import faltante:

```php
use Illuminate\Support\Facades\Log; // ← agregar esta línea
```

---

### A-04 — Ruta de prueba expuesta sin autenticación

**Archivo:** `routes/web.php:13-17`

```php
Route::get('/test-job', function () {
    new Recordatorios()->handle(); // ← Ejecuta el job de recordatorios directamente
    return response('fin!');
});
```

Cualquier usuario anónimo puede invocar `/test-job` para disparar el job de recordatorios, generando notificaciones masivas a todos los usuarios administradores y trabajadores sin ningún tipo de autenticación.

**Remediación:** Eliminar esta ruta en producción o protegerla:

```php
// Opción A: eliminar la ruta
// Opción B: solo en entorno local
if (app()->environment('local')) {
    Route::get('/test-job', function () { ... });
}
```

---

## 4. Vulnerabilidades medias

### M-01 — Cifrado de sesión deshabilitado

**Archivo:** `.env`

```ini
SESSION_ENCRYPT=false
```

Las sesiones se almacenan en base de datos sin cifrar. Si un atacante obtiene acceso de lectura a la tabla `sessions`, puede deserializar los datos de sesión directamente.

**Remediación:** `SESSION_ENCRYPT=true`

---

### M-02 — Sin cabeceras de seguridad HTTP

No se encontró middleware que inyecte cabeceras de seguridad en las respuestas. Las siguientes están ausentes:

| Cabecera | Riesgo |
|----------|--------|
| `X-Frame-Options: DENY` | Clickjacking |
| `X-Content-Type-Options: nosniff` | MIME sniffing |
| `Strict-Transport-Security` | Downgrade HTTPS |
| `Content-Security-Policy` | XSS / inyección de scripts |
| `Referrer-Policy` | Fuga de URLs internas |

**Remediación:** Crear un middleware `SecurityHeaders` y registrarlo globalmente:

```php
// app/Http/Middleware/SecurityHeaders.php
public function handle(Request $request, Closure $next): Response
{
    $response = $next($request);
    $response->headers->set('X-Frame-Options', 'DENY');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
    $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    return $response;
}
```

---

### M-03 — Sin rate limiting en endpoints principales

**Archivo:** `app/Providers/FortifyServiceProvider.php`

Solo los endpoints de autenticación de Fortify tienen rate limiting (5 req/min). Los endpoints de negocio no tienen limitación:

- `GET /archivo/{id}` — enumerable ilimitadamente
- `GET /prestamo/{id}` — enumerable ilimitadamente
- `POST /livewire/update` — llamadas Livewire sin throttle

**Remediación:**

```php
// routes/web.php
Route::middleware(['auth', 'verified', 'throttle:60,1'])->group(function () {
    // ...rutas existentes...
});
```

---

### M-04 — Doble consulta innecesaria en `update()`

**Archivo:** `app/Http/Controllers/PrestamoController.php:88-93`

```php
Notification::send(
    Solicitud::find($validated['solicitud_id'])->trabajador,   // ← Query #1
    new solicitud_notification(
        "...",
        'Motivo: '.Solicitud::find($validated['solicitud_id'])->motivo,  // ← Query #2 (mismo ID)
        "archivo/{$validated['solicitud_id']}"
    ));
```

Se hacen dos consultas `SELECT` separadas para el mismo registro.

**Remediación:**

```php
$solicitud = Solicitud::with('trabajador')->findOrFail($validated['solicitud_id']);

Notification::send(
    $solicitud->trabajador,
    new solicitud_notification(
        "Tu solicitud de préstamo ha sido {$estado} por ".Auth::user()->name,
        "Motivo: {$solicitud->motivo}",
        "archivo/{$solicitud->id}"
    ));
```

---

### M-05 — Registro de usuarios abierto sin aprobación

**Archivo:** `config/fortify.php`

Cualquier persona puede crear una cuenta. Los nuevos usuarios no tienen rol asignado hasta que un administrador lo hace manualmente. El sistema solo notifica a los admins cada 10 minutos (a través del job de recordatorios), dejando una ventana de tiempo donde el usuario existe en el sistema sin rol definido.

**Remediación:** Implementar invitación por correo o deshabilitar el registro público y gestionar usuarios solo desde el panel de administración.

---

### M-06 — Validación de fechas sin lógica cruzada

**Archivo:** `app/Http/Controllers/PrestamoController.php:22-29`

```php
$validated = $request->validate([
    'fecha_prestamo'   => ['required', 'date'],
    'fecha_devolucion' => ['required', 'date'],
    // ❌ No se valida que fecha_devolucion > fecha_prestamo
    // ❌ No se valida que fecha_prestamo >= hoy
]);
```

Se puede crear un préstamo con fecha de devolución anterior a la de préstamo.

**Remediación:**

```php
'fecha_prestamo'   => ['required', 'date', 'after_or_equal:today'],
'fecha_devolucion' => ['required', 'date', 'after:fecha_prestamo'],
```

---

### M-07 — IDs secuenciales en todos los modelos

Todos los modelos usan IDs enteros autoincremental, lo que facilita la enumeración de recursos (ver A-01). Una vez se resuelva A-01, esto deja de ser explotable, pero el uso de UUIDs elimina el vector por completo.

**Remediación (opcional pero recomendada):**

```php
// En cada migración
$table->uuid('id')->primary();

// En cada modelo
use Illuminate\Database\Eloquent\Concerns\HasUuids;
```

---

### M-08 — Sin soft deletes en modelos de negocio

Los modelos `Solicitud`, `Equipo` y `Unidad_Equipo` no implementan `SoftDeletes`. Una eliminación accidental o maliciosa de registros es irreversible y no deja trazabilidad para auditorías.

**Remediación:** Agregar `SoftDeletes` y la columna `deleted_at` en migraciones.

---

### M-09 — `wire:poll.30s` sin autenticación verificada en sidebar de notificaciones

**Archivo:** `resources/views/components/componentes/notifications/⚡sidebar.blade.php:73`

```php
<div wire:poll.30s class="flex flex-col gap-5 overflow-y-auto">
    @php($unreadNotifications = Auth::user()->fresh()->unreadNotifications()->latest()->get())
```

El polling cada 30 segundos con `->fresh()` fuerza una recarga completa del modelo de usuario desde base de datos en cada tick. Con muchos usuarios conectados simultáneamente, esto puede saturar la base de datos.

---

## 5. Vulnerabilidades bajas

### B-01 — `SESSION_DOMAIN=null` — sin restricción de dominio en cookies

Las cookies de sesión no están vinculadas a un dominio específico. Configurar `SESSION_DOMAIN=.tu-dominio.com` limita el alcance de las cookies.

### B-02 — Política de contraseñas deshabilitada en entorno de desarrollo

`PasswordValidationRules` tiene lógica condicional que relaja completamente los requisitos en `local`/`testing`. Si un desarrollador despliega accidentalmente en producción con `APP_ENV=local`, las contraseñas débiles serían aceptadas.

### B-03 — Uso de `Equipo::all()` sin paginación

**Archivo:** `resources/views/components/prestamo/create/⚡seleccion_unidad_form.blade.php:46-48`

```php
#[Computed]
public function equipos()
{
    return Equipo::all(); // ← Sin límite
}
```

Si el catálogo de equipos crece, esto carga todos los registros en memoria en cada render del componente Livewire.

### B-04 — Convención de nombres inconsistente en tablas

Las tablas `solicitud__equipos` y `unidad__equipos` usan doble guion bajo, diferente del estándar de Laravel (singular guion bajo). Esto puede causar confusión y errores al usar `make:model -m`.

### B-05 — `laravel/tinker` disponible (verificar que sea solo `require-dev`)

Confirmar que en el servidor de producción no esté instalado el paquete `laravel/tinker` fuera de `require-dev`. Tinker permite ejecutar PHP arbitrario en el servidor.

---

## 6. Consultas con problema N+1

### N+1-01 — Calendario: acceso a relación `trabajador` dentro de `map()`

**Archivo:** `resources/views/components/calendario/⚡big.blade.php:32-48`

```php
// Se obtienen N solicitudes con UNA consulta
$solicitudes = Solicitud::query()->...->get();

// Dentro del map, cada acceso a ->trabajador dispara una nueva consulta SELECT
$entregas = $solicitudes->map(function (Solicitud $solicitud) {
    return [
        'description' => "Solicitante: {$solicitud->trabajador->name}", // ← N consultas adicionales
    ];
});

$devoluciones = $solicitudes->map(function (Solicitud $solicitud) {
    return [
        'description' => "Solicitante: {$solicitud->trabajador->name}", // ← N consultas más
    ];
});
```

**Costo real:** Si hay 30 solicitudes en el mes, se disparan `1 + 30 + 30 = 61 consultas` en lugar de `1 + 1 = 2`.

**Corrección:**

```php
$solicitudes = Solicitud::query()
    ->with('trabajador')   // ← Eager loading
    ->where(...)
    ->get();
```

---

### N+1-02 — Job de recordatorios: `->trabajador()->first()` en foreach

**Archivo:** `app/Jobs/ProcesarRecordatorios.php:65-75` y `88-99`

```php
// prestamos_por_entregar()
foreach ($solicitudes as $solicitud) {
    $act = [
        'id_trabajador' => $solicitud->trabajador()->first()->id, // ← 1 query por iteración
    ];
}

// recepciones_proximas()
foreach ($recepciones as $recepcion) {
    $act = [
        'id_trabajador' => $recepcion->trabajador()->first()->id, // ← 1 query por iteración
    ];
}
```

**Costo real:** Con 20 solicitudes próximas a entregar y 10 recepciones: `1 + 20 + 1 + 10 = 32 consultas` en lugar de `4`.

**Corrección:**

```php
// Usar eager loading en la consulta inicial
$solicitudes = Solicitud::with('trabajador')
    ->where('estado', 'Autorizada')
    ->whereDate('fecha_prestamo', ...)
    ->get();

// Luego acceder con la relación ya cargada (sin query extra)
'id_trabajador' => $solicitud->trabajador->id,
```

---

### N+1-03 — Job de recordatorios: consultas duplicadas en `admins()`

**Archivo:** `app/Jobs/ProcesarRecordatorios.php:132-167`

```php
public function admins()
{
    if ($this->new_users() > 0) {           // ← Query COUNT #1
        $this->notificator(...,
            'hay '.$this->new_users().'...' // ← Query COUNT #2 (idéntica)
        );
    }
    if ($this->prestamos_pendientes() > 0) {           // ← Query COUNT #3
        $this->notificator(...,
            'hay '.$this->prestamos_pendientes().'...' // ← Query COUNT #4 (idéntica)
        );
    }
    // ...
    foreach ($prestamos as $prestamo) {
        $mensaje = '...'.User::find($prestamo['id_trabajador'])->name; // ← N queries en loop
        $this->notificator(User::role('admin')->get(), ...);           // ← N queries en loop
    }
}
```

**Corrección:**

```php
public function admins()
{
    $newUsersCount = $this->new_users();       // Calcular una sola vez
    $pendingCount  = $this->prestamos_pendientes(); // Calcular una sola vez
    $admins        = User::role('admin')->get(); // Cargar una sola vez

    if ($newUsersCount > 0) {
        $this->notificator($admins, '...', "hay {$newUsersCount} nuevos usuarios...", '/personal');
    }
    if ($pendingCount > 0) {
        $this->notificator($admins, '...', "hay {$pendingCount} préstamos pendientes...", '/prestamo');
    }

    $prestamos = array_merge($this->prestamos_por_entregar(), $this->recepciones_proximas());
    $trabajadoresIds = array_column($prestamos, 'id_trabajador');
    $trabajadores = User::whereIn('id', $trabajadoresIds)->get()->keyBy('id'); // UNA sola query

    foreach ($prestamos as $prestamo) {
        $nombre = $trabajadores[$prestamo['id_trabajador']]->name ?? 'Desconocido';
        $this->notificator($admins, ...);
    }
}
```

---

### N+1-04 — Sidebar de notificaciones: componente Livewire por ítem en un loop

**Archivo:** `resources/views/components/componentes/notifications/⚡sidebar.blade.php:75-80`

```php
@forelse ($unreadNotifications as $notification)
    <livewire:componentes.notifications.item   {{-- ← Monta un componente Livewire por notificación --}}
        :key="'notification-'.$notification->id.'-'..."
        :notification="$notification"
    />
@empty
```

Cada componente `notifications.item` montado individualmente puede generar su propia consulta al inicializarse. Con 50 notificaciones sin leer se crean 50 instancias de componentes Livewire.

**Corrección:** Usar un único componente de lista que reciba todas las notificaciones como colección, o renderizar las notificaciones con un `@include` de Blade simple si no necesitan interactividad individual.

---

### N+1-05 — Dashboard: `chartData` dispara múltiples queries separadas

**Archivo:** `resources/views/components/grafica/⚡dashboard.blade.php:18-26`

```php
#[Computed]
public function chartData(): array
{
    return [
        Unidad_Equipo::where('mantenimiento', true)->count(),            // Query #1
        Unidad_Equipo::where('mantenimiento', false)->count()            // Query #2
            - $this->equipos_prestados()                                 // Queries #3-4
            - $this->entrega_hoy(),                                      // Queries #5-6
        $this->equipos_prestados(),  // ← Recalcula equipos_prestados()  Queries #7-8
        $this->entrega_hoy(),        // ← Recalcula entrega_hoy()        Queries #9-10
    ];
}
```

`equipos_prestados()` y `entrega_hoy()` son métodos regulares, no `#[Computed]`, por lo que se ejecutan dos veces cada uno dentro de `chartData()`.

**Corrección:**

```php
#[Computed]
public function chartData(): array
{
    $prestados  = $this->equipos_prestados;  // accede a la propiedad computada (cacheada)
    $entregaHoy = $this->entrega_hoy;

    return [
        Unidad_Equipo::where('mantenimiento', true)->count(),
        Unidad_Equipo::where('mantenimiento', false)->count() - $prestados - $entregaHoy,
        $prestados,
        $entregaHoy,
    ];
}

#[Computed]
public function equipos_prestados(): int { ... }

#[Computed]
public function entrega_hoy(): int { ... }
```

---

## 7. Solicitudes rechazadas — Ejemplos Postman

Esta sección documenta solicitudes HTTP que la API **rechaza o debería rechazar**, útiles para pruebas de validación y seguridad.

> Todas las solicitudes que modifiquen datos requieren el header `X-CSRF-TOKEN` y la cookie de sesión activa. Los endpoints Livewire usan `POST /livewire/update` con el payload de componente.

---

### 7.1 Actualización de estado de solicitud con estado no permitido

**Endpoint:** `POST` a través de Livewire (mapeado internamente a `PrestamoController@update`)

```json
POST /livewire/update
Content-Type: application/json
X-CSRF-TOKEN: {{csrf_token}}
Cookie: {{session_cookie}}

{
    "fingerprint": {
        "id": "recepcion-show-component",
        "name": "recepcion.show"
    },
    "serverMemo": { "...": "..." },
    "updates": [
        {
            "type": "callMethod",
            "payload": {
                "method": "actualizarEstado",
                "params": ["Devuelta"]
            }
        }
    ]
}
```

**Respuesta esperada (400 Bad Request):**

```json
{
    "error": "Estado no válido para esta acción."
}
```

**Nota de seguridad actual (A-02):** A pesar del error 400, la actualización en base de datos **ya fue ejecutada** antes de la validación. Ver vulnerabilidad A-02.

---

### 7.2 Crear préstamo sin equipos seleccionados

```json
POST /livewire/update
Content-Type: application/json
X-CSRF-TOKEN: {{csrf_token}}
Cookie: {{session_cookie}}

{
    "fingerprint": { "name": "prestamo.create" },
    "updates": [{
        "type": "callMethod",
        "payload": {
            "method": "save",
            "params": []
        }
    }],
    "serverMemo": {
        "data": {
            "motivo": "Solicitud de prueba",
            "fecha_prestamo": "2026-06-10",
            "fecha_devolucion": "2026-06-15",
            "equipos_seleccionados": [],
            "trabajador": 1,
            "estado": "Pendiente"
        }
    }
}
```

**Respuesta esperada (422 Unprocessable Entity):**

```json
{
    "errors": {
        "equipos_seleccionados": ["El campo equipos seleccionados es obligatorio."]
    }
}
```

---

### 7.3 Crear préstamo con trabajador inexistente

```json
POST /livewire/update
Content-Type: application/json
X-CSRF-TOKEN: {{csrf_token}}
Cookie: {{session_cookie}}

{
    "fingerprint": { "name": "prestamo.create" },
    "updates": [{
        "type": "callMethod",
        "payload": {
            "method": "save",
            "params": []
        }
    }],
    "serverMemo": {
        "data": {
            "motivo": "Solicitud con usuario falso para bypass",
            "fecha_prestamo": "2026-06-10",
            "fecha_devolucion": "2026-06-15",
            "equipos_seleccionados": [1],
            "trabajador": 99999,
            "estado": "Autorizada"
        }
    }
}
```

**Respuesta esperada (422 Unprocessable Entity):**

```json
{
    "errors": {
        "trabajador": ["El campo trabajador seleccionado no es válido."]
    }
}
```

---

### 7.4 Acceso a recurso de otro usuario (enumeración de IDs)

```
GET /archivo/1
Cookie: {{session_cookie_de_trabajador_distinto}}
```

**Respuesta actual (200 OK — VULNERABILIDAD A-01):** Devuelve la vista con el archivo de otro usuario.

**Respuesta esperada (403 Forbidden):**

```json
{
    "message": "Esta acción no está autorizada."
}
```

---

### 7.5 Intento de registro de usuario con datos incompletos

```json
POST /register
Content-Type: application/json
X-CSRF-TOKEN: {{csrf_token}}

{
    "name": "",
    "email": "no-es-un-email",
    "password": "123",
    "password_confirmation": "456"
}
```

**Respuesta esperada (422 Unprocessable Entity):**

```json
{
    "errors": {
        "name": ["El campo nombre es obligatorio."],
        "email": ["El campo correo electrónico debe ser una dirección de correo válida."],
        "password": [
            "El campo contraseña debe tener al menos 12 caracteres.",
            "La confirmación del campo contraseña no coincide."
        ]
    }
}
```

---

### 7.6 Modificación de perfil de usuario — campos protegidos no permitidos

El endpoint de perfil (`settings/profile`) solo acepta `name` y `email`. Intentar enviar campos como `role` o `password` directamente debe ser ignorado o rechazado.

```json
POST /livewire/update
Content-Type: application/json
X-CSRF-TOKEN: {{csrf_token}}
Cookie: {{session_cookie}}

{
    "fingerprint": { "name": "pages::settings.profile" },
    "updates": [{
        "type": "syncInput",
        "payload": {
            "name": "state",
            "value": {
                "name": "Nuevo Nombre",
                "email": "nuevo@email.com",
                "role": "admin",
                "is_admin": true,
                "password": "nueva_contraseña_forzada"
            }
        }
    }]
}
```

**Respuesta esperada:** Los campos `role`, `is_admin` y `password` deben ser ignorados completamente. Solo `name` y `email` son actualizables en este endpoint. La actualización de `password` debe hacerse exclusivamente en `settings/password`.

**Estado actual:** El modelo `User` tiene `$fillable = ['name', 'email', 'password']`. El campo `role` no está en `$fillable`, por lo que la asignación masiva está protegida. Sin embargo, `password` sí está en `$fillable` y dependiendo de la implementación del componente de perfil podría ser sobreescrito.

---

### 7.7 Acceso a rutas de administrador con rol de trabajador

```
GET /prestamo
Cookie: {{session_cookie_de_trabajador}}
```

**Respuesta esperada (403 Forbidden):**

```html
<!-- resources/views/errors/403.blade.php -->
<title>403 - Sin autorización</title>
```

**Estado actual:** Correcto. La ruta `GET /prestamo` tiene `middleware('role:admin')` y Spatie Permissions retorna 403.

---

### 7.8 Modificación directa de estado de solicitud sin autenticación

```json
POST /livewire/update
Content-Type: application/json
X-CSRF-TOKEN: token_invalido_o_ausente

{
    "fingerprint": { "name": "recepcion.show" },
    "updates": [{
        "type": "callMethod",
        "payload": { "method": "actualizarEstado", "params": ["Autorizada"] }
    }]
}
```

**Respuesta esperada (419 Page Expired):**

```json
{
    "message": "CSRF token mismatch."
}
```

**Estado actual:** Correcto. Livewire valida el token CSRF en todas las peticiones.

---

## 8. Plan de remediación

### Semana 1 — Crítico (bloquea producción)

- [ ] **C-01** Remover `.env` del historial de Git y rotar todas las credenciales
- [ ] **C-02** Establecer `APP_DEBUG=false` y `APP_ENV=production`
- [ ] **C-03** Cambiar contraseña de base de datos y crear usuario con permisos mínimos
- [ ] **A-04** Eliminar o proteger la ruta `/test-job`
- [ ] **A-03** Agregar `use Illuminate\Support\Facades\Log;` en `ProcesarRecordatorios`

### Semana 2 — Alta prioridad

- [ ] **A-01** Agregar `findOrFail()` + verificación de propiedad en todos los `show($id)`
- [ ] **A-02** Mover validación de estado al inicio del método `update()`
- [ ] **N+1-01** Agregar `with('trabajador')` en consulta del Calendario
- [ ] **N+1-02** Agregar eager loading en `ProcesarRecordatorios`
- [ ] **N+1-03** Cachear resultados de `new_users()` y `prestamos_pendientes()`

### Semana 3 — Media prioridad

- [ ] **M-01** Habilitar `SESSION_ENCRYPT=true`
- [ ] **M-02** Crear middleware de cabeceras de seguridad HTTP
- [ ] **M-03** Agregar `throttle` en grupos de rutas principales
- [ ] **M-06** Agregar validación `after:fecha_prestamo` en fechas
- [ ] **N+1-04** Refactorizar sidebar de notificaciones para evitar componentes por ítem
- [ ] **N+1-05** Convertir `equipos_prestados` y `entrega_hoy` a `#[Computed]`

### Mes 2 — Mejoras estructurales

- [ ] **M-05** Implementar flujo de invitación o aprobación de usuarios
- [ ] **M-07** Migrar a UUIDs (opcional, requiere coordinación)
- [ ] **M-08** Agregar `SoftDeletes` a modelos de negocio
- [ ] **B-03** Paginar `Equipo::all()` en el selector de préstamos
- [ ] Agregar `composer audit` en pipeline CI/CD
- [ ] Implementar Laravel Policies para autorización declarativa

---

*Documento generado mediante revisión estática del código fuente. No sustituye una prueba de penetración activa.*
