<?php

use Livewire\Component;

new class extends Component
{
    public $datos = [];

    public function mount($datos = [])
    {
        $this->datos = $datos;
    }
};
?>

<div>
    <flux:table class="border-spacing-1!">
        <flux:table.columns >
            <flux:table.column align="center" variant="strong" class="text-center! p-0! rounded-2xl">Modelo</flux:table.column>
            <flux:table.column align="center" variant="strong" class="border-4 rounded-2xl">Marca</flux:table.column>

            <flux:table.column align="center" variant="strong" class="text-center! text-pretty! rounded-2xl">Cantidad de Solicitudes</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($datos as $Equipo)
                <flux:table.row>
                    <flux:table.cell>
                        {{ $Equipo->modelo }}</flux:table.cell>
                    <flux:table.cell class="text-pretty! text-center!">
                        {{ $Equipo->marca }}
                    </flux:table.cell>

                    <flux:table.cell align="center">
                        {{$Equipo->total}}
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>