<div class="
            grid grid-cols-1 place-items-center content-center 
            
            gap-y-7
            md:w-fit
            md:mx-auto
            md:gap-13
            md:grid-cols-2 
            lg:
            ">
    
    <livewire:componentes.modal-card
        name="modalDeudas"
        titulo="Mas deudas acumuladas"
        icono="thumbs-down"
        color_bg="bg-rojo_claro"
        color_text="text-hueso"
        titulo-modal="Personal mas deudor"
        table="dashboard.index.detalles.deudores"
        :descripcion="$this->mas_deudas->first()?->name ?? 'Aún no hay deudas acumuladas'"
        :datos="$this->mas_deudas"    

    />
    {{-- ajhsadk --}}
    <livewire:componentes.card 
        titulo='Mantenimiento' 
        descripcion='{{ $this->cant_mantenimiento ?? 0 }} equipos reportados necesitan revision' 
        icono='wrench' 
        color_bg='bg-rojo_oscuro' color_text='text-hueso'
    />

    <livewire:componentes.modal-card
        name="modalMasSolicitudes"
        titulo="Equipo más solicitado"
        icono="award"
        color_text="black"
        color_bg="not-dark:bg-hueso"
        titulo-modal="Equipo más solicitado"
        table="dashboard.index.detalles.solicitudes"
        :descripcion="$this->mas_solicitado->first()->modelo.' '.$this->mas_solicitado->first()->marca ?? 'N/A'"
        :datos="$this->mas_solicitado"
    />
    
    <livewire:componentes.modal-card
        name="modalMenosSolicitudes"
        titulo="Equipo menos solicitado"
        icono="trending-down"

        color_bg='bg-black' 
        color_text='text-hueso'

        titulo-modal="Equipo menos solicitado"
        table="dashboard.index.detalles.solicitudes"
        :descripcion="$this->menos_solicitado->first()->modelo.' '.$this->menos_solicitado->first()->marca ?? 'N/A'"   
        :datos="$this->menos_solicitado"
    />
</div>
