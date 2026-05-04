<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-fondo dark:bg-zinc-800">
        
        {{-- PC menu --}}
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Ventanas')" class="grid">
                    @auth
                    {{-- Inicio --}}
                        <x-item-sidebar icon="home" ruta="dashboard" texto="Inicio" />                        
                        {{-- Calendario --}}
                            @hasanyrole('admin|trabajador')
                                <x-item-sidebar icon="calendar" ruta="calendario.index" texto="Calendario" />
                            @endrole
                    {{-- Prestamos --}}
                        @role('trabajador')
                            <x-item-sidebar icon="file" ruta="prestamo.create" texto="Prestamos" />
                        @endrole
                        @role('admin')
                            <x-item-sidebar icon="file-box" ruta="prestamo.index" texto="Prestamos" />
                        @endrole
                    {{-- Entrega --}}
                    @role('admin')
                        <x-item-sidebar icon="box" ruta="entrega.index" texto="Entrega" />
                    @endrole
                    {{-- Recepción --}}
                        @role('admin')
                            <x-item-sidebar icon="truck" ruta="recepcion.index" texto="Recepción" />
                        @endrole
                    {{-- Personal --}}
                        @role('admin')
                            <x-item-sidebar icon="users" ruta="personal.index" texto="Personal" />
                        @endrole
                    {{-- Equipo --}}
                        @role('admin')
                            <x-item-sidebar icon="airplay" ruta="equipo.index" texto="Equipo" />
                        @endrole
                    {{-- Archivo --}}
                        @hasanyrole('admin|trabajador')
                            <x-item-sidebar icon="archive" ruta="archivo.index" texto="Archivo" />
                        @endrole
                    @endauth
                </flux:sidebar.group>
            </flux:sidebar.nav>

           <flux:spacer />

            <flux:sidebar.nav>
                @auth
                <livewire:componentes.notifications.sidebar/>               
                @endauth
            </flux:sidebar.nav>
            @auth
                <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
            @endauth
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />
            @auth
            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                    color="auto"
                                    color:seed={{ auth()->user()->id }}
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Configuraciones') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            @endauth
        </flux:header>
        
        {{ $slot }}

        @fluxScripts
        @persist('toast')
            <flux:toast />
        @endpersist 
    </body>
</html>
