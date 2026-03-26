<div class="grid grid-cols-2 grid-rows-2 place-items-center content-center">
    
    <livewire:modal-card
        name="modalDeudas"
        titulo="Mas deudas acumuladas"
        icono="thumbs-down"
        color_bg="bg-rojo_claro"
        color_text="text-hueso"
        titulo-modal="Personal mas deudor"
        table="modal.tabla.deudores"
        :descripcion="$this->mas_deudas->first()?->name ?? 'Aún no hay deudas acumuladas'"
        :datos="$this->mas_deudas"    

    />
    {{-- ajhsadk --}}
    <livewire:card 
        titulo='Mantenimiento' 
        descripcion='{{ $this->cant_mantenimiento ?? 0 }} equipos reportados necesitan revision' 
        icono='wrench' 
        color_bg='bg-rojo_oscuro' color_text='text-hueso'
    />

    <livewire:modal-card
        name="modalMasSolicitudes"
        titulo="Equipo más solicitado"
        icono="award"
        color_text="black"
        titulo-modal="Equipo más solicitado"
        table="modal.tabla.solicitudes"
        :descripcion="$this->mas_solicitado->first()->modelo.' '.$this->mas_solicitado->first()->marca ?? 'N/A'"
        :datos="$this->mas_solicitado"
    />
    
    <livewire:modal-card
        name="modalMenosSolicitudes"
        titulo="Equipo menos solicitado"
        icono="trending-down"

        color_bg='bg-black' 
        color_text='text-hueso'

        titulo-modal="Equipo menos solicitado"
        table="modal.tabla.solicitudes"
        :descripcion="$this->menos_solicitado->first()->modelo.' '.$this->menos_solicitado->first()->marca ?? 'N/A'"   
        :datos="$this->menos_solicitado"
    />
</div>
