<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-dub">
    @php
$headerCategories = auth()->check()
    ? \App\Models\Category::query()
        ->where('user_id', auth()->id())
        ->orderBy('name')
        ->get(['id', 'name'])
    : collect();
    @endphp

    <flux:header
        container
        x-data="{ scrolled: false }"
        x-on:scroll.window="scrolled = window.scrollY > 24"
        x-bind:class="scrolled
            ? 'sticky top-0 z-20  border-zinc-200/80 bg-white/92 shadow-sm backdrop-blur dark:border-zinc-700/80 dark:bg-dub/92'
            : 'sticky top-0 z-20  border-zinc-200 bg-white dark:border-zinc-700 dark:bg-dub'"
        class="transition-all duration-300 sticky will-change-transform"
    >
        <div
            x-bind:class="scrolled ? 'translate-y-0 py-4' : 'py-4'"
            class="w-full max-w-6xl mx-auto flex flex-col gap-4 transition-all duration-300 py-4"
        >
            <div class="flex content-center items-center">
                <flux:sidebar.toggle class="lg:hidden mr-2 " icon="bars-2" inset="left" />
                <flux:navbar class="-mb-px max-lg:hidden">
                    <x-app-logo href="{{ route('dashboard') }}" wire:navigate />
                </flux:navbar>

                <flux:navbar class="-mb-px max-lg:hidden">
                    <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Inicio') }}
                    </flux:navbar.item>
                    <flux:navbar.item icon="tag" :href="route('category.index')" :current="request()->routeIs('category.index')" wire:navigate>
                        Categorias
                    </flux:navbar.item>
                </flux:navbar>

                <flux:spacer />

                <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                    <x-desktop-user-menu />
                </flux:navbar>
            </div>

            @if (request()->routeIs('dashboard') && $headerCategories->isNotEmpty())
                <div class="hidden lg:flex items-center gap-3 overflow-x-auto pb-1">
                    <div class="flex items-center gap-2">
                        @foreach ($headerCategories as $category)
                            <a
                                href="{{ route('dashboard') }}#{{ \Illuminate\Support\Str::slug($category->name) }}"
                                class="shrink-0 rounded-full border border-gray-200 bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-600 transition-colors duration-200 hover:border-linko-purple hover:text-violet-700 dark:border-dub-border dark:bg-dub-surface dark:text-gray-300 dark:hover:border-linko-purple dark:hover:text-linko-purple"
                            >
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </flux:header>

    <!-- Mobile Menu -->
    <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Inicio') }}
            </flux:sidebar.item>
            <flux:sidebar.item icon="tag" :href="route('category.index')" :current="request()->routeIs('category.index')" wire:navigate>
                Categorias
            </flux:sidebar.item>
        </flux:sidebar.nav>

        <flux:spacer />


    </flux:sidebar>

    {{ $slot }}

    @fluxScripts
</body>

</html>
