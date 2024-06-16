<template>
    <div class="card">
        <div class="row g-0">
            <div class="col-8 d-flex flex-column">
                <div class="card-body">
                    <Alert ref="alertSaveSettings"/>
                    <h3 class="card-title">Редактирование администратора</h3>
                    <form id="saveAdmin" @submit.prevent="saveInfo">
                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Роль</label>
                            <div class="col">
                                <select class="form-select" v-model="this.admin.role_id" disabled>
                                    <option v-for="item in roleItems" :key="item" :value="item.id" :selected="this.admin.role_id">
                                        {{ item.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-3 col-form-label required">Пароль</label>
                            <div class="col">
                                <input type="password"
                                       required
                                       min="6"
                                       max="32"
                                       v-model="this.admin.password"
                                       class="form-control"
                                       placeholder="Введите новый пароль"
                                       @focus="hideError('password')"
                                       v-bind:class="{'is-invalid': this.error.password}"
                                >
                                <div class="invalid-feedback"> {{ this.error.text.password }}</div>
                            </div>
                            <div class="col">
                                <input type="password"
                                       required
                                       min="6"
                                       max="32"
                                       v-model="this.admin.password_confirmation"
                                       class="form-control"
                                       placeholder="Повторите пароль"
                                       @focus="hideError('password')"
                                       v-bind:class="{'is-invalid': this.error.password}"
                                >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-transparent mt-auto">
                    <div class="btn-list justify-content-end">
                        <button form="saveAdmin" class="btn btn-primary" :disabled='isRequest'>
                            <span v-if="isRequest" class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {
    IconCheck,
} from '@tabler/icons-vue';
import axiosClient from "@/core/axios-client.js";
import Alert from "@/components/Alert.vue";
export default {
    name: "AdminEdit",
    components: {
        Alert,
        IconCheck
    },
    data() {
        return {
            headerProps: [{
                breadcrumb: true,
                textBreadcrumb: 'Администраторы системы',
                nameRoute: {
                    name: 'settingsAdmin',
                },
            }, {
                breadcrumb: true,
                textBreadcrumb: 'Редактирование',
                nameRoute: {
                    name: 'settingsLang',
                },
            }],
            isRequest: false,
            admin: {
                role_id: null,
                id: null,
                name: null,
                email: null,
                role: null,
                password: null,
                password_confirmation: null,
            },
            roleItems: [
                {
                    name: 'root',
                    id: 0,
                },
                {
                    name: 'Администратор',
                    id: 1,
                },
                {
                    name: 'Техническая поддержка',
                    id: 2,
                }
            ],
            error: {
                text: {
                    password: null,
                },
                password: false,
            },
        }
    },

    computed: {
        getConfig() {
            return this.$store.state.settings.config;
        },
    },

    mounted() {
        this.$emit('changeHeaderData', this.headerProps);

        axiosClient.get('/admin/settings/getAdminById', {
            params: {
                id: this.$route.params.id
            }
        }).then(({data}) => {
            for (const key in data.response) {
                if (data.response.hasOwnProperty(key) && data.response[key] !== null) {
                    this.admin[key] = data.response[key];
                }
            }
        });
    },
    created() {
    },
    methods: {
        saveInfo() {
            this.isRequest = true;

            axiosClient.post('/admin/settings/updateInformationAdmin', this.admin).then(({data}) => {
                this.$refs.alertSaveSettings.alert('Настройки админа обновлены.', 'success', 'p-0');
            }).catch(({response}) => {
                if (response.data && response.data.error) {
                    for (let i in response.data.error) {
                        let text = response.data.error[i][0];

                        if (i.split('.').length === 2) {
                            i = i.split('.')[1];
                        }

                        if (this.error[i] !== undefined) {
                            this.error[i] = true;
                            this.error.text[i] = text;
                        }
                    }
                }
            }).finally(() => {
                this.isRequest = false;
            });
        },
        hideError(name) {
            if (this.error[name] !== undefined) {
                this.error[name] = false;
            }
        },
    },
}
</script>
