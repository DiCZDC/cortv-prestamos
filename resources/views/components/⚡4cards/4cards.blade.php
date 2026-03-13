<div class="grid grid-cols-2 grid-rows-2 place-items-center content-center">
    
    <livewire:card titulo='Mas deudas acumuladas' descripcion="{{ $this->mas_deudas->first()->name }}" icono='thumbs-down' color_bg='bg-rojo_claro' color_text='text-hueso'/>
    <livewire:card titulo='Mantenimiento' descripcion='{{ $this->cant_mantenimiento() }} equipos reportados necesitan revision' icono='wrench' color_bg='bg-rojo_oscuro' color_text='text-hueso'/>
    <livewire:card titulo='Equipo más solicitado' descripcion="{{ $this->mas_solicitado->first()->marca.' '.$this->mas_solicitado->first()->modelo }}" icono='award' color_text='text-black'/>    
    <livewire:card titulo='Equipo menos solicitado' descripcion="{{ $this->menos_solicitado->first()->marca.' '. $this->menos_solicitado->first()->modelo }}" icono='trending-down' color_bg='bg-black' color_text='text-hueso'/>
</div>