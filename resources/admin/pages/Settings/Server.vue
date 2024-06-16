<template>
    <div class="row row-cards">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Характеристики сервера</h3>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>Версия PHP</td>
                                <td>{{version_php}}</td>
                            </tr>
                            <tr>
                                <td>Расширения</td>
                                <td>{{extensions}}</td>
                            </tr>
                            <tr>
                                <td>Сервер</td>
                                <td>{{server}}</td>
                            </tr>
                            <tr>
                                <td>Загрузка</td>
                                <td>{{load}}</td>
                            </tr>
                            <tr>
                                <td>RAM</td>
                                <td>{{total_memory}}</td>
                            </tr>
                            <tr>
                                <td>RAM FREE</td>
                                <td>{{avail_memory}}</td>
                            </tr>

                            <tr>
                                <td>RAM USED</td>
                                <td>{{zan_memory}}</td>
                            </tr>
                            <tr>
                                <td>Laravel Version</td>
                                <td>{{laravel.version}}</td>
                            </tr>
                            <tr>
                                <td>Laravel Mode</td>
                                <td>{{laravel.is_mode}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="card-header">
                        <h3 class="card-title">Процессы бота</h3>
                    </div>
                    <div class="panel-body p-2" v-html="midjourney"></div>
                </div>
                <div class="panel panel-default">
                    <div class="card-header">
                        <h3 class="card-title">Процессы Node</h3>
                    </div>
                    <div class="panel-body p-2" v-html="pm2"></div>
                </div>
                <div class="panel panel-default">
                    <div class="card-header">
                        <h3 class="card-title">Дисковое пространство</h3>
                    </div>
                    <div class="panel-body p-2" v-html="disk"></div>
                </div>
                <div class="panel panel-default">
                    <div class="card-header">
                        <h3 class="card-title">Процессы сервера</h3>
                    </div>
                    <div class="panel-body p-2" v-html="tasks"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import UtilitiesService from "@/services/utilities.service";

export default {
    name: "Server",
    data() {
        return {
            debugItem: [],
            totalItems: 0,
            noResult: true,
            headerProps: [{
                breadcrumb: true,
                textBreadcrumb: 'Сервер',
                nameRoute: {
                    name: 'settingsServer',
                },
            }],
            version_php: null,
            extensions: null,
            server: null,
            load: null,
            total_memory: null,
            avail_memory: null,
            zan_memory: null,
            tasks: null,
            midjourney: null,
            disk: null,
            laravel: {
                version: 0,
                is_mode: null,
            }
        }
    },
    computed: {
        currentUser() {
            return this.$store.state.user;
        },
    },
    mounted() {
        this.$emit('changeHeaderData', this.headerProps);

        UtilitiesService.getServer().then(res => {
            const server = res.data.server;

            this.version_php = server.version_php;
            this.extensions = server.extensions;
            this.server = server.server;
            this.load = server.load;
            this.total_memory = server.total_memory;
            this.avail_memory = server.avail_memory;
            this.zan_memory = server.zan_memory;
            this.tasks = server.tasks;
            this.midjourney = server.midjourney;
            this.disk = server.disk;
            this.laravel = server.laravel;
        })
    },
}
</script>
