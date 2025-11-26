<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
  <head>
    @include('partials.head')

    <style>
      /* 1. Animación subrayado */
      @keyframes underline-grow-reset {
        0% {
          background-size: 0% 2px;
        }
        80% {
          background-size: 100% 2px;
        }
        80.01% {
          background-size: 0% 2px;
        }
        100% {
          background-size: 0% 2px;
        }
      }

      .animate-underline {
        background-image: linear-gradient(to right, #facc15, #fde047); /* tonos amarillos */
        background-repeat: no-repeat;
        background-size: 0% 2px;
        background-position: 0 100%;
        animation: underline-grow-reset 4s ease-in-out infinite;
      }

      .hover-grow:hover {
        transform: scale(1.05);
        transition: transform 0.25s ease;
      }

      @keyframes pulse-color {
        0%,
        100% {
          background-color: rgba(234, 179, 8, 0.25); /* amarillo suave */
          color: #fef9c3; /* amarillo claro */
        }
        50% {
          background-color: rgba(234, 179, 8, 0.6); /* amarillo fuerte */
          color: #ffffff;
        }
      }

      .icon-animate {
        animation: pulse-color 4s ease-in-out infinite;
      }
    </style>
  </head>

  <body class="min-h-screen bg-gray-50 antialiased dark:bg-neutral-950">
    <div class="relative grid min-h-screen lg:grid-cols-2">
      {{-- PANEL IZQUIERDO (Bienvenida / Branding) --}}
      <div
        class="relative hidden h-full flex-col p-10 text-yellow-100 lg:flex overflow-hidden rounded-r-[35px]"
      >
        {{-- Fondo negro sólido --}}
        <div class="absolute inset-0 bg-black"></div>

        {{-- Capa decorativa tipo glass amarillo translúcido --}}
        <div
          class="absolute inset-0 bg-yellow-500/2 bg-clip-padding backdrop-filter backdrop-blur-3xl border border-yellow-400/20 rounded-r-[35px]"
        ></div>

        {{-- Contenido principal --}}
        <div class="relative z-10 flex flex-col justify-center flex-1 px-4">
          <div class="text-center">
            <h2 class="text-5xl lg:text-5xl font-bold mb-4 leading-tight">
              Bienvenido a
              <span class="text-yellow-300 animate-underline">{{
                config('app.name', 'SIVIA-APP')
              }}</span>
            </h2>
            <p class="text-lg text-yellow-100/90 max-w-lg mx-auto">
              Sistema Integral de Viáticos Automatizado — agiliza la gestión de
              comisiones y simplifica tus trámites administrativos.
            </p>
          </div>

          <div class="mt-5 max-w-md mx-auto space-y-3 text-left">
            <ul class="space-y-5 text-left">
              <li
                class="flex items-start space-x-3 animate-slide-loop hover-grow"
                style="animation-delay: 0.3s;"
              >
                <span
                  class="mt-1 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full 
                  bg-yellow-400/20 text-yellow-200 font-bold
                  transition-all duration-100 ease-in-out
                  icon-animate hover-grow"
                  style="animation-delay:0s;"
                >
                  ✓
                </span>

                <span>
                  <strong class="font-semibold text-yellow-100"
                    >Digitaliza tus solicitudes</strong
                  ><br />
                  <span class="text-yellow-100/80"
                    >Olvida el papel y los errores manuales.</span
                  >
                </span>
              </li>

              <li
                class="flex items-start space-x-3 animate-slide-loop hover-grow"
                style="animation-delay: 0.6s;"
              >
                <span
                  class="mt-1 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full 
                  bg-yellow-400/20 text-yellow-200 font-bold
                  transition-all duration-100 ease-in-out
                  icon-animate hover-grow"
                  style="animation-delay:1s;"
                >
                  ✓
                </span>

                <span>
                  <strong class="font-semibold text-yellow-100"
                    >Centraliza la información</strong
                  ><br />
                  <span class="text-yellow-100/80"
                    >Accede a un historial completo al instante.</span
                  >
                </span>
              </li>

              <li
                class="flex items-start space-x-3 animate-slide-loop hover-grow"
                style="animation-delay: 0.9s;"
              >
                <span
                  class="mt-1 flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full 
                  bg-yellow-400/20 text-yellow-200 font-bold
                  transition-all duration-100 ease-in-out
                  icon-animate hover-grow"
                  style="animation-delay:2s;"
                >
                  ✓
                </span>

                <span>
                  <strong class="font-semibold text-yellow-100"
                    >Genera PDFs automáticos</strong
                  ><br />
                  <span class="text-yellow-100/80"
                    >Tus formularios listos para archivar o imprimir.</span
                  >
                </span>
              </li>
            </ul>
          </div>
        </div>

        {{-- Footer --}}
        <footer class="relative z-10 mt-auto text-sm text-yellow-300/90">
          Dirección Provincial de Vialidad – Formosa
        </footer>
      </div>

      {{-- PANEL DERECHO --}}
      <div class="w-full flex items-center justify-center p-8">
                <div class="mx-auto w-full max-w-xl space-y-8">

                    {{-- Aquí se carga el contenido dinámico (login, register, etc.) --}}
                    {{ $slot }}
                </div>
            </div>

    </div>

    @fluxScripts
  </body>
</html>
