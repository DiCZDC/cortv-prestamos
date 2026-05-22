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
    <flux:table class="[&_table]:table-fixed!">
        <flux:table.columns align="center">
            <flux:table.column  >Nombre</flux:table.column>
            <flux:table.column  >Deudas Totales</flux:table.column>
            <flux:table.column  >Acciones</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach($datos as $deudor)
                <flux:table.row>
                    <flux:table.cell>{{ $deudor->name }}</flux:table.cell>
                    <flux:table.cell variant="strong">
                        {{$deudor->total}}
                    </flux:table.cell>
                    <flux:table.cell>
                        <x-componentes.boton-href ruta="personal.show" texto="Ver" icon="eye" :id="$deudor->id" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>