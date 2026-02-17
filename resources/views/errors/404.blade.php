<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Página no encontrada | Linko</title>

    <link rel="icon" href="{{ asset('assets/img/logo-linko-transparent.ico') }}" sizes="any">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dub text-[#1b1b18] flex p-6 lg:p-8 items-center justify-center min-h-screen flex-col antialiased">
    
    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow">
        <main class="flex w-full flex-col-reverse lg:max-w-5xl lg:flex-row items-stretch shadow-2xl border border-black/5 dark:border-white/10 rounded-[2rem] overflow-hidden dark:shadow-[0_0_50px_rgba(0,0,0,0.3)] lg:h-[500px]">
            
            <div class="z-20 flex-1 p-8 lg:p-16 bg-white dark:bg-[#161615] dark:text-[#EDEDEC] flex flex-col justify-center shadow-[20px_0_50px_rgba(0,0,0,0.05)]">
                
                <span class="text-linko-purple font-bold tracking-widest uppercase text-xs mb-2">Error 404</span>
                
                <h1 class="mb-4 text-4xl lg:text-6xl font-bold tracking-tight font-['Instrument_Sans'] leading-tight">
                    Te has <span class="text-linko-purple">perdido</span> un poco.
                </h1>
                
                <p class="mb-8 text-base text-[#706f6c] dark:text-[#A1A09A] max-w-sm">
                    La página que buscas no existe o ha sido movida. No te preocupes, puedes volver a centralizar tus herramientas ahora mismo.
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ url('/') }}" 
                       class="inline-flex justify-center items-center px-6 py-3 bg-linko-purple text-white rounded-xl font-medium transition-all hover:bg-violet-600 hover:shadow-lg hover:shadow-violet-500/30 active:scale-95">
                        Volver al inicio
                    </a>
                    
                </div>
            </div>

            <div class="z-10 flex-1 bg-[#f9f9f9] dark:bg-[#1c1c1a] relative min-h-[300px] lg:min-h-full overflow-hidden flex items-center justify-center">
                <div class="absolute inset-0 opacity-10 dark:opacity-20" style="background-image: radial-gradient(circle, #7C3AED 1px, transparent 1px); background-size: 30px 30px;"></div>
                
                <span class="absolute text-[12rem] font-black text-linko-purple/5 dark:text-linko-purple/10 select-none">404</span>

                <img src="{{ asset('assets/img/logo-linko-welcome.png') }}" 
                     alt="Error 404" 
                     class="relative z-10 w-48 h-48 object-contain opacity-50 dark:opacity-40 grayscale group-hover:grayscale-0 transition-all duration-700">
                
                <div class="absolute inset-0 bg-gradient-to-tr from-[#7C3AED]/10 to-transparent pointer-events-none"></div>
            </div>
        </main>
    </div>

    <footer class="mt-8 text-xs text-zinc-500 dark:text-zinc-600 font-['Instrument_Sans']">
        &copy; {{ date('Y') }} Linko — Tu ecosistema digital.
    </footer>
</body>
</html>