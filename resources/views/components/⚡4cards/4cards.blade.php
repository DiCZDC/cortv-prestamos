<div class="grid grid-cols-2 grid-rows-2 place-items-center content-center">
    
    <livewire:card titulo='Mas deudas acumuladas' descripcion='Israel Juarez' icono='thumbs-down' color_bg='bg-rojo_claro' color_text='text-hueso'/>
    <livewire:card titulo='Mantenimiento' descripcion='4 equipos reportados necesitan revision' icono='wrench' color_bg='bg-rojo_oscuro' color_text='text-hueso'/>
    <livewire:card titulo='Equipo más solicitado' descripcion="{{ $this->mas_solicitado->marca.' '.$this->mas_solicitado->modelo }}" icono='award' color_text='text-black'/>    
    <livewire:card titulo='Equipo menos solicitado' descripcion="{{ $this->menos_solicitado->marca.' '. $this->menos_solicitado->modelo }}" icono='trending-down' color_bg='bg-black' color_text='text-hueso'/>
</div>