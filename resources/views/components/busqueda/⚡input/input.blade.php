<div>
    <label for="equipo" class="inline-flex justify-center gap-1 text-gris_claro text-base font-semibold"> 
        <span> Equipo </span>
        <flux:badge size="sm">
            <span class="text-zinc-800/70 text-xs font-extrabold!">Selecciona al menos uno</span>
        </flux:badge>
    </label>

    <input list="equipos" id="equipo" name="equipo" wire:model.blur="nombre_equipo"
            class="border-cortvBorde border rounded-lg text-base p-2 h-10 w-full mt-2 text-zinc-700
            placeholder-zinc-400 shadow-xs border-zinc-200"
            placeholder="¿A que trabajador se le asignara la orden?">
    
    {{-- 
    <datalist id="equipos">
        @foreach($this->equipos as $equipo)
            <option value="{{ $equipo->nombre }}">
        @endforeach
    </datalist>
    <div>
        @error('nombre_equipo')
                <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
    </div>  --}}
</div>