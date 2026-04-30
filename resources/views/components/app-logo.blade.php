@props([
'sidebar' => false,
])

@if($sidebar)
<flux:sidebar.brand name="Linko" {{ $attributes }}>
    <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
        <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
    </x-slot>
</flux:sidebar.brand>
@else
<flux:brand {{ $attributes }}>
    <x-slot name="logo" class="flex aspect-square dark:bg-dub-surface bg-gray-100 size-13 items-center justify-center rounded-md">
        <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
    </x-slot>
</flux:brand>
    <span class="text-xl lg:text-2xl font-semibold me-4">
        Linko
    </span>
@endif