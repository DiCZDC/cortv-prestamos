<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Equipo;
use App\Models\Unidad_Equipo;

new class extends Component
{ 
     #[Validate('required',message: 'Por favor selecciona un equipo')]  
    public $nombre_equipo; 

     #[Validate('required',message: 'Por favor selecciona un SICIPO')]  
    public $nombre_unidad_equipo;

    public $equipos_seleccionados = [];

    
    public function rules()
    {
        return [
            'nombre_equipo' => 'required',
            'nombre_unidad_equipo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre_equipo.required' => 'Por favor selecciona un equipo',
            'nombre_unidad_equipo.required' => 'Por favor selecciona un SICIPO',
        ];
    }

    
    #[Computed]
    public function equipos()
    {
        return Equipo::all();
    }

    
    public function unidades_equipo($id){
        return Unidad_Equipo::where('id_equipo', $id)->get();
    }

    public function agregar()
    {
        $this->validate();
        $this->dispatch('equipo-agregado', unidad_id: $this->nombre_unidad_equipo);
        $this->reset(['nombre_equipo', 'nombre_unidad_equipo']);
    }
    
};
?>
<div class="flex flex-col bg-white shadow-2xl rounded-2xl px-12 py-6 w-140 mt-9">  
        {{-- titulo --}}
        <div class="flex justify-center items-center gap-5 mb-2 text-rojo_claro">
            <flux:icon name="command" class="inline size-12" />
            <h1 class="text-4xl font-bold inline text-center text-wrap">Agrega equipo <br> a la solicitud</h1>
        </div>
        
        {{-- campos --}}
        <div class="gap-7 flex flex-col ">
                
            <flux:field>

                <flux:label badge="Requerido">
                    <span class="text-gris_claro text-base font-semibold">Equipo</span>
                </flux:label>

                <flux:select wire:model.live="nombre_equipo">
                
                    <flux:select.option value="">Seleccione un equipo</flux:select.option>
                
                    @forelse ($this->equipos as $equipo)
                    
                    <flux:select.option value="{{ $equipo->id }}">{{ $equipo->marca . " " . $equipo->modelo }}</flux:select.option>
                        
                    @empty
                        <flux:select.option disabled>No hay equipos disponibles</flux:select.option>
                    @endforelse
                    
                </flux:select>                             
                 
                <div>@error('nombre_equipo') {{ $message }} @enderror</div>

            </flux:field>

            <flux:field>
                <flux:label badge="Requerido">
                    <span class="text-gris_claro text-base font-semibold">Sicipo</span>
                </flux:label>


                <flux:select wire:model.live="nombre_unidad_equipo" :disabled="empty($nombre_equipo)">

                    @if (!empty($nombre_equipo))
                        <flux:select.option value="">Elige una unidad...</flux:select.option>
                    @endif
            
                    @forelse ($this->unidades_equipo($nombre_equipo) as $unidad)
                        <flux:select.option value="{{ $unidad->id }}">{{ $unidad->sicipo}}</flux:select.option>
                    @empty
                        <flux:select.option disabled>No hay unidades disponibles</flux:select.option>
                    @endforelse
                </flux:select>
                
                <div>@error('nombre_unidad_equipo') {{ $message }} @enderror</div>                             
            </flux:field>
                
            <flux:button wire:click="agregar" variant="primary" class="border-none w-full !bg-rojo_claro ">Agregar Equipo</flux:button>
        </div>
                    
</div>  