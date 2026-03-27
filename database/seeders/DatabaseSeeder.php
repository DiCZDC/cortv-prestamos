<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Equipo;
use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use App\Models\Unidad_Equipo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $usuario = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'trabajador']);

        $usuario->assignRole('admin');

        Categoria::factory(10)->create();
        Equipo::factory(100)->create();
        Solicitud::factory(500)->create();
        Unidad_Equipo::factory(1000)->create();
        Solicitud_Equipo::factory(1000)->create();

        // Permission::create(['name' => 'solicitar_prestamo']);
        // Permission::create(['name' => 'ver_archivo']);
    }
}
