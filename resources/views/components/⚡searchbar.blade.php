<?php

use Livewire\Component;

new class extends Component
{
    public $filter = [];
    public $search_var = '';
    
    public function updated_search(){
        $this->dispatch('updateSearch', value: $this->search_var);
    }
};
?>

<div>
    <div class = "flex flex-row items-center gap-4 mb-4 ">
        <flux:input icon="magnifying-glass" placeholder="Buscar por nombre de trabajador, administrador o motivo..." wire:model.blur="search_var"/>
        <flux:select size="md" class="w-full sm:w-auto" wire:model.live="filter">
            @forelse ($this->filter as $key => $label)
                <flux:select.option :value="$key">{{$label}}</flux:select.option>
            @empty
                <flux:select.option value="">No hay filtros disponibles</flux:select.option>
            @endforelse
            
        </flux:select>
    </div>
</div>