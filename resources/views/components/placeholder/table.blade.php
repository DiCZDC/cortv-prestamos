@props(['header' => [], 'filter' => false, 'searchbar' => false, 'perPage' => 5])

<div>
    <!-- The only way to do great work is to love what you do. - Steve Jobs -->
    @if ($searchbar || $filter)
        <div class="flex fex-row gap-4 h-9 mb-4">
            <flux:skeleton class="h-full w-full mb-4 rounded-lg" />
            @if ($filter)
                <flux:skeleton class="h-full w-1/10 mb-6 rounded-lg"/>
            @endif
        </div>
    @endif
    <flux:skeleton.group animate="shimmer">
        <flux:table>
            <flux:table.columns>
                @foreach ($header as $column)
                    <flux:table.column>{{ $column }}</flux:table.column>
                @endforeach
            </flux:table.columns>
            @for($i = 0; $i < $perPage; $i++)
                <flux:table.rows>
                    @foreach($header as $column)
                        @if ($loop->first)
                            <flux:table.cell>
                                <flux:skeleton class="rounded-full size-5" />
                                
                            </flux:table.cell>
                        @else
                            <flux:table.cell>
                                <div class="h-4 bg-gray-300 rounded w-full"></div>
                            </flux:table.cell>
                        @endif
                    @endforeach
                    </flux:table.row>
                @endfor
            </flux:table.rows>
        </flux:table>
    </flux:skeleton.group>
</div>