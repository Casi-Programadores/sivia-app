<div class="p-6 bg-gray-50 min-h-screen font-sans text-slate-600">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-[#1e3a8a]">Centro de Soporte</h1>
        <p class="text-sm text-gray-500 mt-1">¿Necesita ayuda con el sistema SIVIA? Aquí encontrará recursos y contacto directo.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- COLUMNA IZQUIERDA (2/3): RECURSOS Y FAQ --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- Sección de Manuales --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Documentación y Guías
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Tarjeta Video Tutorial --}}
                    <a href="#" target="_blank" class="group p-4 rounded-lg border border-gray-200 hover:border-red-300 hover:bg-red-50 transition flex items-start gap-4 cursor-pointer">
                        <div class="p-3 bg-red-100 text-red-600 rounded-lg group-hover:bg-red-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm group-hover:text-red-700">Video Tutorial</h4>
                            <p class="text-xs text-gray-500 mt-1">Aprenda a usar el sistema en menos de 5 minutos.</p>
                        </div>
                    </a>

                </div>
            </div>

            {{-- Preguntas Frecuentes (FAQ) --}}
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#1e3a8a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Preguntas Frecuentes
                </h3>
                
                <div class="space-y-2" x-data="{ selected: null }">
                    
                    {{-- Pregunta 1 --}}
                    <div class="border border-gray-100 rounded-lg">
                        <button @click="selected !== 1 ? selected = 1 : selected = null" class="w-full px-4 py-3 text-left bg-gray-50 hover:bg-gray-100 rounded-lg flex justify-between items-center text-sm font-semibold text-gray-700">
                            <span>¿Cómo corrijo una solicitud ya enviada?</span>
                            <svg class="w-4 h-4 transition-transform" :class="selected === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="selected === 1" class="px-4 py-3 text-sm text-gray-600 bg-white border-t border-gray-100" x-cloak>
                            Si la solicitud está en estado "Pendiente", puede eliminarla desde el listado y crear una nueva. Si ya fue "Aprobada" o "Certificada", deberá comunicarse con administración para anular el expediente.
                        </div>
                    </div>

                    {{-- Pregunta 2 --}}
                    <div class="border border-gray-100 rounded-lg">
                        <button @click="selected !== 2 ? selected = 2 : selected = null" class="w-full px-4 py-3 text-left bg-gray-50 hover:bg-gray-100 rounded-lg flex justify-between items-center text-sm font-semibold text-gray-700">
                            <span>¿Qué hago si no aparece un empleado en la lista?</span>
                            <svg class="w-4 h-4 transition-transform" :class="selected === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="selected === 2" class="px-4 py-3 text-sm text-gray-600 bg-white border-t border-gray-100" x-cloak>
                            Debe ir al módulo "Empleados" (si tiene permisos de administrador) y dar de alta al nuevo agente. Si no tiene permisos, contacte a RRHH.
                        </div>
                    </div>

                    {{-- Pregunta 3 --}}
                    <div class="border border-gray-100 rounded-lg">
                        <button @click="selected !== 3 ? selected = 3 : selected = null" class="w-full px-4 py-3 text-left bg-gray-50 hover:bg-gray-100 rounded-lg flex justify-between items-center text-sm font-semibold text-gray-700">
                            <span>¿Cómo imprimo la liquidación individual?</span>
                            <svg class="w-4 h-4 transition-transform" :class="selected === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="selected === 3" class="px-4 py-3 text-sm text-gray-600 bg-white border-t border-gray-100" x-cloak>
Si la solicitud está en estado Pendiente, haga clic en el botón Continuar en el listado principal. Esto iniciará el proceso de Certificación. Una vez completados los datos administrativos y confirmada la operación, aparecerán los botones de descarga (Certificado y Liquidación) junto al nombre de cada agente.                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA (1/3): CONTACTO --}}
        <div class="space-y-6">
            
            {{-- Tarjeta de Contacto --}}
            <div class="bg-[#1e3a8a] text-white p-6 rounded-xl shadow-lg relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-bold mb-4">Soporte Técnico</h3>
                    <p class="text-blue-100 text-sm mb-6">
                        Si tiene problemas técnicos o errores en el sistema, contacte al área de informática.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-blue-200 uppercase font-bold">Teléfono Interno</p>
                                <p class="font-bold">Int. 437 / 438</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-blue-200 uppercase font-bold">Correo Electrónico</p>
                                <p class="font-bold text-sm">soporte@vialidad.formosa.gob.ar</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-blue-200 uppercase font-bold">Oficina</p>
                                <p class="font-bold text-sm">Departamento Informática (1° Piso)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>