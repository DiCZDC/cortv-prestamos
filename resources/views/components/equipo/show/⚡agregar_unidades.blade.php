<?php

use Livewire\Component;
use App\Models\Equipo;
use App\Models\Unidad_Equipo;
use Livewire\Attributes\Validate;
new class extends Component
{
    public $producto;
    public $unidad='';

    function crearUnidad()
    {
        $this->validate([
            'unidad' => [
            'required',
            'regex:/^\d+$/',
                function ($attribute, $value, $fail) {
                    if (Unidad_Equipo::where('sicipo', 'SICIPO-' . $value)->exists()) {
                    $fail('Ya existe una unidad con ese número de SICIPO.');
                    }
                },
            ],
        ]);

        Unidad_Equipo::create([
            'sicipo' => 'SICIPO-' . $this->unidad,
            'id_equipo' => $this->producto->id,
        ]);
        $this->unidad = '';
        Flux::modal('create-unidad')->close();           
    }
};
?>

<div>
    {{-- When there is no desire, all things are at peace. - Laozi --}}
    <flux:modal name="create-unidad" class="md:w-96">
        <form wire="crearUnidad" class="p-6">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Crear Unidad</flux:heading>
                    <flux:text class="mt-2">Agrega una nueva unidad para el equipo {{ $producto->marca . ' ' . $producto->modelo }}</flux:text>
                </div>

                {{-- REVISAR PARA CORREGIR W --}}
                <flux:input wire:model.live="unidad" label="Número de Sicipo" placeholder="Ejemplo: 000001" class="w-full" />
                
                <div class="w-full flex justify-end">
                    <x-btn-wire 
                    :disabled="$unidad==''"
                    wire="crearUnidad" texto="Crear Unidad" color="verde_mid" icon="book-lock"  />
                
                    
                </div>
            </div>
        </form>
    </flux:modal>
</div>