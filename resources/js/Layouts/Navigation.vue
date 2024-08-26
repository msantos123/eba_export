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
            <!--NAVEGADOR SISTEMA-->
            <a class="flex items-center mt-4 py-2 px-6 text-gray-100" @click="showSistema = !showSistema"
            v-if ="$page.props.user.permissions.includes('read usuario')">
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
            v-if ="$page.props.user.permissions.includes('read cargas')">
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
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('solicitudcargas.index')">Solicitud de Carga</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('conocimientos.index')">Conocimiento de Carga</Link>
                        </li>
                    </ul>
                </div>
            </transition>

            <a class="flex items-center mt-4 py-2 px-6 text-gray-100" href="#" @click="showInventario = !showInventario"
            v-if ="$page.props.user.permissions.includes('read inventario')">
                <i class="fa-solid fa-warehouse fa-lg" style="color: #ffffff;"></i>
                <span class="mx-3">Inventario</span>
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
                            <Link class="w-full" :href="route('comprobante_ingreso.index')">Ingreso Almacenes</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('kardexs.index')">Kardex</Link>
                        </li>
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('comprobante_salida.index')">Salida Almacenes</Link>
                        </li>
                    </ul>
                </div>
            </transition>
            <nav-link :href="route('pre_factura.index')" :active="route().current('pre_factura')">
                <template #icon>
                    <i class="fa-solid fa-file-invoice-dollar fa-lg" style="color: #ffffff;"></i>
                </template>
                Pre Factura
            </nav-link>


            <!--nav-link :href="route('conocimientos.index')" :active="route().current('conocimientos.index')">
                <template #icon>
                    <i class="fa-solid fa-truck fa-lg" style="color: #ffffff;"></i>
                </template>
                Conocimientos
            </nav-link>

            <nav-link :href="route('departments.index')" :active="route().current('departments.index')">
                <template #icon>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </template>
                Department
            </nav-link>

            <nav-link :href="route('employees.index')" :active="route().current('employees.index')">
                <template #icon>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </template>
                Employee
            </nav-link>

            <nav-link :href="route('graphic')" :active="route().current('graphic')">
                <template #icon>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </template>
                Graphic
            </nav-link>

            <nav-link :href="route('reports')" :active="route().current('reports')">
                <template #icon>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </template>
                Reports
            </nav-link>


            <nav-link :href="route('about')" :active="route().current('about')">
                <template #icon>
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                         stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"></path>
                    </svg>
                </template>
                About us
            </nav-link>

            <a class="flex items-center mt-4 py-2 px-6 text-gray-100" href="#" @click="showingTwoLevelMenu = !showingTwoLevelMenu">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                </svg>
                <span class="mx-3">Two-level menu</span>
            </a-->

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
