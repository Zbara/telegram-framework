<template>
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark" v-if="this.currentUser">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark">
                <RouterLink :to="{name: 'main'}">
                    Bot Admin
                </RouterLink>
            </h1>
            <div class="navbar-nav flex-row d-lg-none">
                <div class="navbar-nav flex-row order-md-last">
                    <span class="nav-link px-3 hide-theme-dark cursor-pointer"
                          @click="theme('dark')"
                    >
                        <IconMoon class="icon" width="24" height="24"/>
                    </span>
                    <span class="nav-link px-3 hide-theme-light cursor-pointer"
                          @click="theme('light')"
                    >
                    <IconSun class="icon" width="24" height="24"/>
                    </span>
                    <a :href="'https://t.me/' + $store.state.settings.config.username" target="_blank"
                       class="nav-link me-3" title="Открыть бот">
                        <IconRobot class="icon" width="24" height="24"/>
                    </a>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="false">
                        <span class="avatar avatar-sm">{{ this.currentUser?.username[0] ?? '' }}</span>
                        <div class="d-none d-xl-block ps-2">
                            <div>{{ this.currentUser.username }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a @click.prevent="logOut" class="dropdown-item cursor-pointer">Выход</a>
                    </div>
                </div>
            </div>
            <div class="navbar-collapse collapse toggled hide" id="sidebar-menu">
                <ul class="navbar-nav pt-lg-3 p-3">
                    <li class="nav-item">
                        <RouterLink :to="{name: 'main'}" class="nav-link">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconHome/>
                            </span>
                            <span class="nav-link-title">
                                Главная
                            </span>
                        </RouterLink>
                    </li>
                    <li class="nav-item" v-if="this.isRole.admin.includes(currentUser.role)">
                        <RouterLink :to="{name: 'users'}" class="nav-link">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconUsers/>
                            </span>
                            <span class="nav-link-title">
                                Пользователи
                            </span>
                        </RouterLink>
                    </li>
                    <li class="nav-item dropdown" v-if="this.isRole.admin.includes(currentUser.role)">
                        <a class="nav-link dropdown-toggle" href="#navbar-layout" data-bs-toggle="dropdown"
                           data-bs-auto-close="false" role="button" aria-expanded="true"
                           @click.prevent="toggleMenu('settings')">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <IconTool class="icon icon-tabler icon-tabler-truck-delivery" width="24" height="24"/>
                            </span>
                            <span class="nav-link-title">
                                Настройки
                            </span>
                        </a>
                        <div class="dropdown-menu" :class="{ 'show': $store.state.menu.menus['settings'] }">
                            <div class="dropdown-menu-columns">
                                <div class="dropdown-menu-column">
                                    <RouterLink :to="{name: 'settings'}" class="dropdown-item" active-class="active">
                                        Основные
                                    </RouterLink>
                                    <RouterLink :to="{name: 'language'}" class="dropdown-item" active-class="active">
                                        Текст сообщений
                                    </RouterLink>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
    <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none" v-if="this.currentUser">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-nav flex-row order-md-last">
                <span class="nav-link px-0 hide-theme-dark cursor-pointer"
                      @click="theme('dark')"
                      data-bs-toggle="tooltip"
                      data-bs-placement="bottom"
                      aria-label="Включить темную тему"
                      data-bs-original-title="Включить темную тему">
                    <IconMoon class="icon" width="24" height="24"/>
                </span>
                <span class="nav-link px-0 hide-theme-light cursor-pointer"
                      @click="theme('light')"
                      data-bs-toggle="tooltip"
                      data-bs-placement="bottom"
                      aria-label="Включить светлую тему"
                      data-bs-original-title="Включить светлую тему">
                    <IconSun class="icon" width="24" height="24"/>
                </span>
                <a :href="'https://t.me/' + $store.state.settings.config.username" target="_blank"
                   class="nav-link px-xxl-3" title="Открыть бот">
                    <IconRobot class="icon" width="24" height="24"/>
                </a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                       aria-label="Open user menu">
                        <span class="avatar avatar-sm">{{ currentUser.username[0] }}</span>
                        <div class="d-none d-xl-block ps-2">
                            <div> {{ currentUser.username }}</div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a @click.prevent="logOut" class="dropdown-item cursor-pointer">Выход</a>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse">
                <Breadcrumb v-bind:headersBreadcrumb="headersBreadcrumb"/>
            </div>
        </div>
    </header>
</template>
<script>
import {
    IconBuildingStore,
    IconUsers,
    IconBrandTelegram,
    IconRobot,
    IconHome,
    IconCloudSearch,
    IconTool,
    IconCash,
    IconHelp,
    IconLeaf,
    IconRadioactiveFilled,
    IconMoon,
    IconSun,
    IconBell,
    IconUserStar,
    IconNetwork,
    IconTruckDelivery
} from '@tabler/icons-vue';
import {tooltip} from "@/core/libs/tooltip.js";
import {ref} from 'vue';
import TooltipWrapper from './TooltipWrapper.vue';
import Breadcrumb from './Breadcrumb.vue';

export default {

    data() {
        return {
            registerUser: false,
            username: null,
            unreadQuestions: 0,
            openQuestions: 0,
            isRole: {
                admin: [0, 1]
            }
        }
    },

    components: {
        IconBuildingStore,
        IconCash,
        IconUsers,
        IconBrandTelegram,
        IconRobot,
        IconHome,
        IconTool,
        IconHelp,
        IconRadioactiveFilled,
        IconLeaf,
        IconCloudSearch,
        IconMoon,
        IconSun,
        IconNetwork,
        IconBell,
        IconUserStar,
        IconTruckDelivery,
        Breadcrumb,
        'v-tooltip': TooltipWrapper,
    },

    props: {
        headersBreadcrumb: {
            type: Array
        }
    },

    computed: {
        currentUser() {
            return this.$store.state.auth.user;
        },
    },
    setup() {
        const tooltipOptions = ref({
            delay: {show: 50, hide: 50},
            html: false, // Установите значение true, если это необходимо
            placement: 'auto', // Установите желаемое значение расположения
        });

        return {
            tooltipOptions,
        };
    },
    mounted() {
        tooltip();
    },
    methods: {
        logOut() {
            this.$store.dispatch('auth/logout');
            this.$router.push('/admin/login');
        },
        toggleMenu(menuId) {
            this.$store.commit('menu/toggleMenu', menuId);
        },
        theme(params) {
            let selectedTheme = null;

            if (!!params) {
                localStorage.setItem('admin-theme', params)
                selectedTheme = params
            } else {
                const storedTheme = localStorage.getItem('admin-theme')
                selectedTheme = storedTheme ? storedTheme : "light"
            }

            if (selectedTheme === 'dark') {
                document.body.setAttribute("data-bs-theme", selectedTheme)
            } else {
                document.body.removeAttribute("data-bs-theme")
            }
        }
    }
}
</script>
