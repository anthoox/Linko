<x-layouts::app.header :title="$title ?? null">
    <flux:main class="min-h-[calc(100vh-130px)] flex flex-col">

        <div class="flex-grow">
            {{ $slot }}
        </div>
    </flux:main>
</x-layouts::app.header>