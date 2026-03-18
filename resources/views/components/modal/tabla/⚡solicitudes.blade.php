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
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Modelo</flux:table.column>
            <flux:table.column>Marca</flux:table.column>

            <flux:table.column>Cantidad de Solicitudes</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($datos as $Equipo)
                <flux:table.row>
                    <flux:table.cell>{{ $Equipo->modelo }}</flux:table.cell>
                    <flux:table.cell>{{ $Equipo->marca }}</flux:table.cell>

                    <flux:table.cell variant="strong">
                        {{$Equipo->total}}
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>