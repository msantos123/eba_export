<template>
    <div :class="$page.props.showingMobileMenu ? 'block' : 'hidden'" @click="$page.props.showingMobileMenu = false"
         class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

    <div :class="$page.props.showingMobileMenu ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
         class="overflow-y-auto fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
        <div class="flex justify-center items-center mt-8">
            <div class="flex items-center">
                <img :src="'/img/logo-eba.png'" class="h-15 w-40 fill-current text-yellow-500" />
            </div>
        </div>

        <nav class="mt-10" x-data="{ isMultiLevelMenuOpen: false }">
            <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                <template #icon>
                    <i class="fa-solid fa-gauge-high fa-lg" style="color: #ffffff;"></i>
                </template>
                Inicio
            </nav-link>
            <nav-link :href="route('inventario.index')" :active="route().current('inventario.index')">
                <template #icon>
                    <i class="fa-solid fa-warehouse fa-lg" style="color: #ffffff;"></i>
                </template>
                Plantas Industriales
            </nav-link>
            <!--NAVEGADOR SISTEMA-->
            <a class="flex items-center mt-4 py-2 px-6 text-gray-100" @click="showSistema = !showSistema"
            v-if ="$page.props.user.permissions.includes('layout sistemas')">
                <i class="fa-solid fa-address-card fa-lg" style="color: #ffffff;"></i>
                <span class="mx-3">Sistema</span>
            </a>
            <transition
                enter-to-class="transition-all duration-300 ease-in-out"
                enter-from-class="max-h-0 opacity-25"
                leave-from-class="opacity-100 max-h-xl"
                leave-to-class="max-h-0 opacity-0">
                <div v-show="showSistema">
                    <ul class="overflow-hidden p-2 mx-4 mt-2 space-y-2 text-sm font-medium text-white bg-gray-700 bg-opacity-50 rounded-md shadow-inner"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('users.index')">Usuarios</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('plantas.index')">Plantas y Almacenes</Link>
                        </li>
                    </ul>
                </div>
            </transition>

            <a class="flex items-center mt-4 py-2 px-6 text-gray-100" href="#" @click="showCarga = !showCarga"
            v-if ="$page.props.user.permissions.includes('layout cargas')">
                <i class="fa-solid fa-truck fa-lg" style="color: #ffffff;"></i>
                <span class="mx-3">Cargas</span>
            </a>
            <transition
                enter-to-class="transition-all duration-300 ease-in-out"
                enter-from-class="max-h-0 opacity-25"
                leave-from-class="opacity-100 max-h-xl"
                leave-to-class="max-h-0 opacity-0">
                <div v-show="showCarga">
                    <ul class="overflow-hidden p-2 mx-4 mt-2 space-y-2 text-sm font-medium text-white bg-gray-700 bg-opacity-50 rounded-md shadow-inner"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150"
                        v-if ="$page.props.user.permissions.includes('layout solicitudcarga')">
                            <Link class="w-full" :href="route('solicitudcargas.index')">Solicitud de Carga</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150"
                        v-if ="$page.props.user.permissions.includes('layout conocimientos')">
                            <Link class="w-full" :href="route('conocimientos.index')">Conocimiento de Carga</Link>
                        </li>
                    </ul>
                </div>
            </transition>

            <a class="flex items-center mt-4 py-2 px-6 text-gray-100" href="#" @click="showInventario = !showInventario">
                <i class="fa-solid fa-warehouse fa-lg" style="color: #ffffff;"></i>
                <span class="mx-3">Almacen El Alto</span>
            </a>
            <transition
                enter-to-class="transition-all duration-300 ease-in-out"
                enter-from-class="max-h-0 opacity-25"
                leave-from-class="opacity-100 max-h-xl"
                leave-to-class="max-h-0 opacity-0">
                <div v-show="showInventario">
                    <ul class="overflow-hidden p-2 mx-4 mt-2 space-y-2 text-sm font-medium text-white bg-gray-700 bg-opacity-50 rounded-md shadow-inner"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('solicitudAlmacen.index')">Solicitud Almacenes</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150"
                        v-if ="$page.props.user.permissions.includes('layout ingreso')">
                            <Link class="w-full" :href="route('comprobante_ingreso.index')">Ingreso Almacenes</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150"
                        v-if ="$page.props.user.permissions.includes('layout salida')">
                            <Link class="w-full" :href="route('kardexs.index')">Kardex</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150"
                        v-if ="$page.props.user.permissions.includes('layout kardex')">
                            <Link class="w-full" :href="route('comprobante_salida.index')">Salida Almacenes</Link>
                        </li>
                    </ul>
                </div>
            </transition>
            <nav-link :href="route('etiquetas.index')" :active="route().current('etiquetas.index')">
                <template #icon>
                    <i class="fa-solid fa-tags fa-lg" style="color: #ffffff;"></i>
                </template>
                Etiquetas
            </nav-link>
            <nav-link :href="route('tracking.index')" :active="route().current('tracking.index')">
                <template #icon>
                    <i class="fa-solid fa-location-dot fa-lg"></i>
                </template>
                Tracking
            </nav-link>
            <nav-link :href="route('contratos.index')" :active="route().current('contratos.index')">
                <template #icon>
                    <i class="fa-solid fa-file-signature fa-lg"></i>
                </template>
                Contratos
            </nav-link>
            <nav-link :href="route('costos.index')" :active="route().current('costos.index')">
                <template #icon>
                    <i class="fa-solid fa-coins fa-lg" style="color: #ffffff;"></i>
                </template>
                Costos
            </nav-link>
            <nav-link :href="route('acopio.index')" :active="route().current('acopio.index')">
                <template #icon>
                    <i class="fa-solid fa-tree fa-lg" style="color: #ffffff;"></i>
                </template>
                Planificacion
            </nav-link>
            <nav-link :href="route('poa.index')" :active="route().current('poa.index')">
                <template #icon>
                    <i class="fa-regular fa-file-powerpoint fa-lg" style="color: #ffffff;"></i>
                </template>
                POA
            </nav-link>
            <nav-link :href="route('liberacion.index')" :active="route().current('liberacion.index')">
                <template #icon>
                    <i class="fa-solid fa-check-to-slot fa-lg"></i>
                </template>
                Liberación
            </nav-link>
            <nav-link :href="route('pre_factura.index')" :active="route().current('pre_factura.index')">
                <template #icon>
                    <i class="fa-solid fa-file-invoice-dollar fa-lg" style="color: #ffffff;"></i>
                </template>
                Pre Factura
            </nav-link>
            <nav-link :href="route('estadistica.index')" :active="route().current('estadistica.index')">
                <template #icon>
                    <i class="fa-solid fa-chart-line fa-lg" style="color: #ffffff;"></i>
                </template>
                Estadistica
            </nav-link>
        </nav>
    </div>

</template>

<script>
import NavLink from '@/Components/NavLink.vue';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'

export default {
    components: {
        NavLink,
        Link,
    },

    setup() {
        let showSistema = ref(false);
        let showCarga = ref(false);
        let showInventario = ref(false);

        return {
            showSistema,
            showCarga,
            showInventario
        }
    },


}

</script>

<style scoped>

</style>
