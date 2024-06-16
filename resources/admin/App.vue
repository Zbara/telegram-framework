<template>
    <div class="page" v-if="initApp">
        <Header v-bind:headersBreadcrumb="headerProps"/>
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-fluid">
                    <router-view v-slot="{ Component }">
                        <component :is="Component" @changeHeaderData="changeHeaderInfo"/>
                    </router-view>
                </div>
            </div>
        </div>
    </div>
    <LoadingApp :is-active="!initApp"/>
</template>
<script>
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";
import Breadcrumb from "@/components/Breadcrumb.vue";
import AuthService from "@/core/auth.service";
import store from "@/store";
import LoadingApp from "@/components/LoadingApp.vue";

export default {
    components: {
        LoadingApp,
        Header,
        Footer,
        Breadcrumb
    },
    data() {
        return {
            headerProps: [{
                breadcrumb: false,
                textBreadcrumb: '',
                nameRoute: '',
            }],
            initApp: false
        }
    },

    async created() {
        await store.dispatch('theme/initTheme');

        if(store.state.auth.user !== null && this.$store.state.auth.user){
            AuthService.getSession('admin').then(async (resp) => {
                await store.dispatch('menu/initApp');
                await store.dispatch('user/initUser');
                await store.dispatch('settings/initApp');

                setTimeout(() => {
                    this.initApp = true;
                }, 500)
            }).catch((error) => {
                this.$store.dispatch('auth/logout');
                this.$router.push({
                    name: 'login',
                });
            });
        }
        if(store.state.auth.user === null){
            setTimeout(() => {
                this.initApp = true;
            }, 500)
        }
    },
    methods: {
        changeHeaderInfo(data){
            this.headerProps = data;
        },
    }
}
</script>
