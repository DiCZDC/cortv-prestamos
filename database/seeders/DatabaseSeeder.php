<?php

namespace Database\Seeders;

use App\Models\{
    User,
    Categoria,
    Equipo,
    Unidad_Equipo,
    Solicitud,
    Solicitud_Equipo,
};

use Spatie\Permission\Models\{
    Role,
    Permission
};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        Categoria::factory(10)->create();
        Equipo::factory(100)->create();
        Solicitud::factory(500)->create();
        Unidad_Equipo::factory(1000)->create();
        Solicitud_Equipo::factory(1000)->create();
        
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'trabajador']);

        $usuario->assignRole('admin');
        
        // Permission::create(['name' => 'solicitar_prestamo']);
        // Permission::create(['name' => 'ver_archivo']);
    }
}
