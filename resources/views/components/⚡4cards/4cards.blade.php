<div class="grid grid-cols-2 grid-rows-2 place-items-center content-center">
    
    <livewire:modal-card
        name="modalDeudas"
        titulo="Mas deudas acumuladas xd"
        descripcion="{{ $this->mas_deudas->first()?->name }}" 
        icono="thumbs-down"
        color-bg="bg-rojo_claro"
        color-text="text-hueso"
        {{-- DATOS DEL MODAL --}}
        titulo-modal="Personal con más deudas acumuladas"
        datos={{ $this->mas_deudas }}
    />
    
    <livewire:card 
        titulo='Mantenimiento' 
        descripcion='{{ $this->cant_mantenimiento ?? 0 }} equipos reportados necesitan revision' 
        icono='wrench' 
        color_bg='bg-rojo_oscuro' color_text='text-hueso'
    />
    <livewire:card 
        titulo='Equipo más solicitado' 
        descripcion="{{ $this->mas_solicitado->first()?->marca.' '.$this->mas_solicitado->first()?->modelo}}"
        icono='award' 
        color_text='black'
    />
    <livewire:card 
        titulo='Equipo menos solicitado' 
        descripcion="{{ $this->menos_solicitado->first()?->marca.' '. $this->menos_solicitado->first()?->modelo }}" 
        icono='trending-down' 
        color_bg='bg-black' 
        color_text='text-hueso'
    />
</div>
