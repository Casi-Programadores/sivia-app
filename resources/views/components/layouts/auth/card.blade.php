<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-neutral-100 antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">

    <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">

        <div class="flex w-full max-w-md overflow-hidden rounded-xl border bg-white shadow-xs dark:border-stone-800 dark:bg-stone-950 lg:max-w-4xl">

            <div class="hidden items-center justify-center p-12 lg:flex lg:w-1/2 bg-gray-50 dark:bg-stone-900/50">
                <img class="h-85 w-auto" src="{{ asset('images/logo-vialidad.png') }}" alt="Logo de mi Empresa">
            </div>

            <div class="w-full px-10 py-8 lg:w-1/2">
                {{ $slot }}
            </div>
        </div>
        </div>

    @fluxScripts
</body>
</html>