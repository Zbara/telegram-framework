<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Языки</h3>
            <div class="card-body">
                <div class="d-flex">
                    <div class="ms-auto text-muted">
                        <RouterLink class="btn btn-primary d-sm-inline-block" :to="{name: 'languageText'}">
                            Переводы
                        </RouterLink>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Код</th>
                    <th>Статус</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <template v-for="item in languageItems">
                    <tr :data-id="item.id">
                        <td>
                            {{ item.id }}
                        </td>
                        <td>
                            {{ item.name }}
                        </td>
                        <td>
                            {{ item.code }}
                        </td>
                        <td>
                            <template v-if="item.active === 1">
                                <span class="badge bg-success me-1"></span> Активный
                            </template>
                            <template v-else>
                                <span class="badge bg-danger me-1"></span> Не активный
                            </template>
                        </td>
                        <td class="text-nowrap text-muted">
                            <span class="text-muted cursor-pointer" data-bs-toggle="dropdown" v-if="item.id !== current_lang">
                                <IconPower class="icon icon-tabler icon-tabler-trash" width="24" height="24"/>
                            </span>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-item cursor-pointer" @click="status(item.id, 0)" v-if="item.active === 1">
                                    Выключить
                                </div>
                                <div class="dropdown-item cursor-pointer" @click="status(item.id, 1)" v-if="item.active === 0">
                                    Включить
                                </div>
                            </div>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import AxiosClient from "@/core/axios-client.js";
import {IconPower} from "@tabler/icons-vue";

export default {
    name: "Language",
    components: {
        IconPower
    },
    data() {
        return {
            languageItems: {},
            current_lang: 0,
            headerProps: [{
                breadcrumb: true,
                textBreadcrumb: 'Языки',
                nameRoute: {
                    name: 'language',
                },
            }]
        }
    },

    computed: {
        config() {
            return this.$store.state.settings.config;
        },
    },

    mounted() {
        this.$emit('changeHeaderData', this.headerProps);

        if(this.config.find(x => x.key === 'language') !== undefined){
            this.current_lang = parseInt(this.config.find(x => x.key === 'language').value);
        }

        AxiosClient.get('/admin/language/getLanguages').then(({data}) => {
            this.languageItems = data.response;
        }).catch((error) => {});
    },

    methods: {
        status(itemId, statusId) {

            AxiosClient.post('/admin/language/setStatus', {
                id: itemId,
                status: statusId,
            }).then((resp) => {
                let item = this.languageItems.findIndex(x => x.id === itemId);
                this.languageItems[item].active = statusId;
            }).catch((error) => {});
        },
    }
}
</script>
