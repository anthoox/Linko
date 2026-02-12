<x-layouts::app.header :title="$title ?? null">
    <flux:main class="min-h-[calc(100vh-130px)] flex flex-col">

        <div class="flex-grow">
            {{ $slot }}
        </div>

        <footer class="w-full  border-gray-100 dark:border-gray-800 pb-0">
            <div class="max-w-5xl mx-auto flex flex-col items-center justify-center space-y-4">
                <span class="text-gray-400 font-medium text-sm">Linko &copy; 2026</span>
                <div class="flex space-x-6 text-gray-500 text-sm">
                    <a href="https://anthoox.es/" target="_blank" class="hover:text-[#a371f7] transition-colors">Portfolio</a>
                    <a href="https://github.com/anthoox" target="_blank" class="hover:text-[#a371f7] transition-colors">GitHub</a>
                    <a href="https://www.linkedin.com/in/anthony-alegr%C3%ADa-alc%C3%A1ntara-58920a233/" target="_blank" class="hover:text-[#a371f7] transition-colors">LinkedIn</a>
                    <a href="https://log.anthoox.es/" target="_blank" class="hover:text-[#a371f7] transition-colors">Blog</a>
                </div>
            </div>
        </footer>
    </flux:main>
</x-layouts::app.header>