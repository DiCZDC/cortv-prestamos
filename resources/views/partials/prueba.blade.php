<flux:table>
    <flux:table.columns>
        <flux:table.column>Nombre</flux:table.column>
        <flux:table.column>Total deuda</flux:table.column>
    </flux:table.columns>

    <flux:table.rows>
        @foreach($datos as $deudor)
            <flux:table.row>
                <flux:table.cell>{{ $deudor['usuario']['nombre'] }}</flux:table.cell>
                <flux:table.cell variant="strong">
                    ${{ number_format($deudor['total'], 2) }}
                </flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>