<div class="grid grid-cols-2 grid-rows-2 place-items-center content-center">
    
    <livewire:modal-card
        name="modalDeudas"
        titulo="Mas deudas acumuladas"
        descripcion="Israel Juarez"
        icono="thumbs-down"
        color-bg="bg-rojo_claro"
        color-text="text-hueso"
        {{-- DATOS DEL MODAL --}}
        titulo-modal="Personal con más deudas acumuladas"
        tipo="deudas"
    />
    <livewire:card titulo='Mantenimiento' descripcion='4 equipos reportados necesitan revision' icono='wrench' color_bg='bg-rojo_oscuro' color_text='text-hueso'/> 
    <livewire:card titulo='Equipo más solicitado' descripcion='Conversor de audio' icono='award' color_text='text-black'/>    
    <livewire:card titulo='Equipo menos solicitado' descripcion='Conversor de video' icono='trending-down' color_bg='bg-black' color_text='text-hueso'/>    

</div>

