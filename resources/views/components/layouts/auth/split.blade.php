<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-neutral-950 font-['Poppins']">
        <div class="relative grid min-h-screen lg:grid-cols-2">
            
            {{-- PANEL IZQUIERDO --}}
            <div class="relative hidden h-full flex-col p-10 text-white lg:flex overflow-hidden rounded-r-[35px]">

                {{-- FONDO  --}}
                <div class="absolute inset-0 bg-gradient-to-br from-[#142448] via-slate-800 to-blue-900"></div>
                <div class="absolute inset-0 opacity-5">
                    <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-pulse"></div>
                    <div class="absolute bottom-20 right-10 w-72 h-72 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl animate-pulse delay-1000"></div>
                </div>

                {{-- HEADER (LOGO Y NOMBRE) --}}
                <div class="relative z-10 flex items-center space-x-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-white/10 backdrop-blur-sm border border-white/20">
                        <x-app-logo-icon class="h-5 w-5 text-white" />
                    </span>
                    <h1 class="text-1xl font-semibold tracking-tight">{{ config('app.name', 'SIVIA-APP') }}</h1>
                </div>

                {{-- ZONA CENTRAL --}}
                <div class="relative z-10 flex flex-col justify-center flex-1 px-1">
                    <div class="text-left -mt-50">
                        <h2 class="text-4xl lg:text-6xl leading-tight tracking-tight text-white text-balance shadow-black/10 drop-shadow-lg">
                            SISTEMA INTEGRAL <br>
                            <span class="text-indigo-300">DE VIÁTICOS</span> <br>
                            Y ADMINISTRACIÓN
                        </h2>
                    </div>
                </div>

                {{-- FOOTER --}}
                <footer class="relative z-10 mt-auto text-sm text-blue-200">
                    Dirección Provincial de Vialidad – Formosa
                </footer>
            </div>

            {{-- PANEL DERECHO --}}
            <div class="w-full flex items-center justify-center p-8">
                <div class="mx-auto w-full max-w-xl space-y-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>