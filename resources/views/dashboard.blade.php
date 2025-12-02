<x-layouts.app :title="__('SIVIA')">
    <div class="flex h-full w-full flex-1 flex-col gap-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('solicitudes.crear') }}"
                class="group rounded-2xl border border-blue-900 dark:border-blue-400
                bg-gray dark:bg-zinc-800 shadow-lg shadow-[rgba(20,36,72,0.20)] 
                dark:shadow-[rgba(0,0,0,0.50)] p-8 flex flex-col items-center justify-center gap-5 
                transition-all duration-300 ease-in-out 
                hover:-translate-y-1 hover:scale-105 
                hover:shadow-[rgba(20,36,72,0.40)]
                dark:hover:shadow-[rgba(0,0,0,0.70)]
                cursor-pointer">

                <h3 class="text-[#1e293b] dark:text-blue-300 
                        text-2xl font-bold text-center">
                    Generar Nueva Solicitud
                </h3>

                <svg xmlns="http://www.w3.org/2000/svg" width="110" height="110" viewBox="0 0 20 20"
                    class="fill-[#1e293b] dark:fill-blue-300 transition-colors">
                    <path d="M6 3a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h3.6a5.5 5.5 0 0 1-.393-1H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v3.207q.524.149 1 .393V6a3 3 0 0 0-3-3zm3.5 7h1.837c.895-.63 1.986-1 3.163-1h-5a.5.5 0 0 0 0 1m-4-5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm1 6a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m0-1a.5.5 0 1 1 0-1a.5.5 0 0 1 0 1m0 5a1.5 1.5 0 1 0 0-3a1.5 1.5 0 0 0 0 3m0-2a.5.5 0 1 1 0 1a.5.5 0 0 1 0-1M19 14.5a4.5 4.5 0 1 1-9 0a4.5 4.5 0 0 1 9 0m-4-2a.5.5 0 0 0-1 0V14h-1.5a.5.5 0 0 0 0 1H14v1.5a.5.5 0 0 0 1 0V15h1.5a.5.5 0 0 0 0-1H15z"/>
                </svg>
            </a>

            <a href="{{ route('reportes.mensual') }}"
            class="group rounded-2xl border 
                    border-blue-900 dark:border-blue-400
                    bg-white dark:bg-zinc-800
                    shadow-lg shadow-[rgba(20,36,72,0.20)] 
                    dark:shadow-[rgba(0,0,0,0.50)]
                    p-8 flex flex-col items-center justify-center gap-5
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-1 hover:scale-105 
                    hover:shadow-[rgba(20,36,72,0.40)]
                    dark:hover:shadow-[rgba(0,0,0,0.70)]
                    cursor-pointer">

                <h3 class="text-[#1e293b] dark:text-blue-300 
                        text-2xl font-bold text-center">
                    Generar Reporte
                </h3>

                <svg xmlns="http://www.w3.org/2000/svg" 
                    width="110" height="110" viewBox="0 0 24 24"
                    class="transition-colors stroke-[#142448] dark:stroke-blue-300">
                    <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
                        <path d="M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2m0 12v-5m3 5v-1m3 1v-3" />
                    </g>
                </svg>
            </a>

            <a href="{{ route('empleados.empleado') }}"
            class="group rounded-2xl border 
                    border-blue-900 dark:border-blue-400
                    bg-white dark:bg-zinc-800
                    shadow-lg shadow-[rgba(20,36,72,0.20)] 
                    dark:shadow-[rgba(0,0,0,0.50)]
                    p-8 flex flex-col items-center justify-center gap-5
                    transition-all duration-300 ease-in-out
                    hover:-translate-y-1 hover:scale-105 
                    hover:shadow-[rgba(20,36,72,0.40)]
                    dark:hover:shadow-[rgba(0,0,0,0.70)]
                    cursor-pointer">

                <h3 class="text-[#1e293b] dark:text-blue-300 
                        text-2xl font-bold text-center">
                    Empleados
                </h3>

                <svg xmlns="http://www.w3.org/2000/svg" 
                    width="110" height="110" viewBox="0 0 36 36"
                    class="transition-colors fill-[#142448] dark:fill-blue-300">
                    <path d="M16.43 16.69a7 7 0 1 1 7-7a7 7 0 0 1-7 7m0-11.92a5 5 0 1 0 5 5a5 5 0 0 0-5-5M22 17.9a25.4 25.4 0 0 0-16.12 1.67a4.06 4.06 0 0 0-2.31 3.68v5.95a1 1 0 1 0 2 0v-5.95a2 2 0 0 1 1.16-1.86a22.9 22.9 0 0 1 9.7-2.11a23.6 23.6 0 0 1 5.57.66Zm.14 9.51h6.14v1.4h-6.14z" />
                    <path d="M33.17 21.47H28v2h4.17v8.37H18v-8.37h6.3v.42a1 1 0 0 0 2 0V20a1 1 0 0 0-2 0v1.47H17a1 1 0 0 0-1 1v10.37a1 1 0 0 0 1 1h16.17a1 1 0 0 0 1-1V22.47a1 1 0 0 0-1-1" />
                </svg>
            </a>

        </div>

<div class="mt-4">
            <h2 class="text-[#1e293b] text-xl font-bold mb-4">Ultimas Solicitudes</h2>
            
            {{-- AQUÍ INSERTAMOS EL COMPONENTE --}}
            <livewire:solicitudes.ultimas-solicitudes-tabla />
            
        </div>

        <!-- FOOTER -->
        <footer class="w-full py-2 text-center">
            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                Dirección Provincial de Vialidad • © 2025 SIVIA - APP
            </p>
        </footer>
    </div> 
    
</x-layouts.app>
