# Requisitos Mínimos de Servidor — cortv-prestamos

## Stack tecnológico identificado

| Componente | Versión/Tecnología |
|---|---|
| Framework | Laravel 12 |
| Lenguaje | PHP 8.2+ |
| Frontend reactivo | Livewire 4 + Flux |
| CSS | Tailwind CSS 4 (compilado con Vite) |
| Base de datos (default) | SQLite → **requiere migración a MySQL** |
| Sesiones | Driver base de datos |
| Cache | Driver base de datos |
| Cola de trabajos | Driver base de datos |
| Roles y permisos | Spatie Laravel Permission |
| Gráficas | LarapexCharts (Chart.js) |
| Scheduler | ProcesarRecordatorios (cada 10 min) |

> **Advertencia crítica**: La configuración predeterminada usa SQLite. Con 120 usuarios concurrentes, SQLite colapsará por bloqueos de escritura. Es obligatorio migrar a MySQL 8.0+ antes de producción.

---

## Requisitos mínimos de hardware (120 usuarios concurrentes)

### CPU
- **Mínimo**: 4 vCPU / núcleos
- **Recomendado**: 8 vCPU

Justificación: Livewire genera una petición HTTP por cada interacción reactiva. Con 120 usuarios activos, pueden existir 60–200 peticiones simultáneas en picos.

### RAM

| Componente | Consumo estimado |
|---|---|
| PHP-FPM (80 workers × 40 MB) | 3.2 GB |
| MySQL + InnoDB buffer pool | 1.5 GB |
| Redis (sesiones + cache + queues) | 512 MB |
| Nginx | 64 MB |
| Sistema operativo | 1 GB |
| **Total mínimo** | **~6.3 GB → usar 8 GB** |
| **Recomendado** | **16 GB** |

### Almacenamiento
- **Mínimo**: 50 GB SSD (NVMe preferido)
- **Tipo**: SSD obligatorio — no HDD. Las sesiones, cache y colas son operaciones I/O intensivas.
- **IOPS mínimo**: 3,000 IOPS

### Red
- Ancho de banda: 100 Mbps mínimo
- Latencia interna (DB ↔ App): < 1 ms (idealmente misma red/máquina)

---

## Configuración de software requerida

### PHP-FPM (`/etc/php/8.2/fpm/pool.d/www.conf`)
```ini
pm = dynamic
pm.max_children = 80
pm.start_servers = 20
pm.min_spare_servers = 10
pm.max_spare_servers = 40
pm.max_requests = 500
request_terminate_timeout = 60
```

### PHP (`php.ini`)
```ini
memory_limit = 256M
max_execution_time = 60
opcache.enable = 1
opcache.memory_consumption = 256
opcache.max_accelerated_files = 10000
opcache.validate_timestamps = 0   ; en producción
```

### Nginx (`/etc/nginx/sites-available/cortv-prestamos`)
```nginx
worker_processes auto;
events {
    worker_connections 2048;
    use epoll;
}

server {
    listen 80;
    root /var/www/cortv-prestamos/public;
    index index.php;

    gzip on;
    gzip_types text/plain text/css application/javascript application/json;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_read_timeout 60;
    }

    location ~* \.(css|js|jpg|png|svg|ico|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

### MySQL 8.0 (`/etc/mysql/mysql.conf.d/mysqld.cnf`)
```ini
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
max_connections = 250
query_cache_type = 0
innodb_flush_log_at_trx_commit = 2
```

### Redis (`/etc/redis/redis.conf`)
```ini
maxmemory 512mb
maxmemory-policy allkeys-lru
save ""
```

---

## Cambios obligatorios en el proyecto para producción

### 1. `.env` de producción
```env
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cortv_prestamos
DB_USERNAME=laravel_user
DB_PASSWORD=<contraseña_segura>

CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

### 2. Comandos de optimización de Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
composer install --optimize-autoloader --no-dev
```

### 3. Queue worker (systemd)
El proyecto usa `ProcesarRecordatorios` cada 10 minutos. Requiere un worker persistente:

```ini
# /etc/systemd/system/laravel-worker.service
[Unit]
Description=Laravel Queue Worker

[Service]
User=www-data
WorkingDirectory=/var/www/cortv-prestamos
ExecStart=php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
Restart=always

[Install]
WantedBy=multi-user.target
```

### 4. Scheduler (cron)
```cron
* * * * * www-data cd /var/www/cortv-prestamos && php artisan schedule:run >> /dev/null 2>&1
```

---

## Resumen ejecutivo

| Recurso | Mínimo | Recomendado |
|---|---|---|
| CPU | 4 vCPU | 8 vCPU |
| RAM | 8 GB | 16 GB |
| Disco | 50 GB SSD | 100 GB SSD NVMe |
| PHP | 8.2 | 8.3 |
| MySQL | 8.0 | 8.0+ |
| Redis | 7.x | 7.x |
| Nginx | 1.24+ | 1.26+ |
| OS | Ubuntu 22.04 LTS | Ubuntu 24.04 LTS |

**Costo de referencia en nube (AWS/DigitalOcean/Linode):** Un servidor con 4 vCPU y 8 GB RAM cuesta aproximadamente USD $40–80/mes. Con 8 vCPU y 16 GB, USD $80–160/mes.

---

> El cambio más crítico antes de cualquier despliegue es migrar de SQLite a MySQL y mover sesiones/cache/queues a Redis. Sin eso, el sistema no soportará ni 20 usuarios concurrentes.
