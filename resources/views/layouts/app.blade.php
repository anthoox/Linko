<x-layouts::app.header :title="$title ?? null">
    {{-- Añadimos estas clases a flux:main para que sea un contenedor flex vertical --}}
    <flux:main class="min-h-[calc(100vh-130px)] flex flex-col">
        
        {{-- Envolvemos el slot en un div que crezca para empujar al footer --}}
        <div class="flex-grow">
            {{ $slot }}
        </div>

        {{-- El footer ahora sí se quedará abajo gracias al flex-grow de arriba --}}
        <footer class="w-full border-t border-gray-100 dark:border-gray-800 pt-8 mt-12 pb-0">
            <div class="max-w-5xl mx-auto flex flex-col items-center justify-center space-y-4">
                <span class="text-gray-400 font-medium text-sm">Linko &copy; 2026</span>
                <div class="flex space-x-6 text-gray-500 text-sm">
                    <a href="#" class="hover:text-[#c27aff] transition-colors">Twitter</a>
                    <a href="#" class="hover:text-[#c27aff] transition-colors">GitHub</a>
                    <a href="#" class="hover:text-[#c27aff] transition-colors">Privacidad</a>
                    <a href="#" class="hover:text-[#c27aff] transition-colors">Contacto</a>
                </div>
            </div>
        </footer>
    </flux:main>
</x-layouts::app.header>