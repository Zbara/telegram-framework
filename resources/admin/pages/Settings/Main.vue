<template>
    <div class="row row-cards">
        <div class="col-xl-7">
            <div class="row row-cards">
                <div class="col-12">
                    <Alert ref="alertRef"/>
                    <form class="card card-md" @submit.prevent="saveSettings">
                        <div class="card-header">
                            <h4 class="card-title">Настройки</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label required">Токен бота</label>
                                <div class="input-group">
                                    <input type="text"
                                           class="form-control"
                                           placeholder="Токен бота"
                                           autocomplete="off"
                                           v-model="bot_token"
                                           required/>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Логин бота</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        https://t.me/
                                    </span>
                                    <input type="text" class="form-control"
                                           placeholder="Введите логин бота"
                                           autocomplete="off"
                                           required
                                           v-model="bot_username"/>
                                </div>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label required">Язык бота</label>
                                <div>
                                    <select class="form-select" v-model="language">
                                        <option v-for="item in languages" :key="item" :value="item.id"
                                                :selected="language">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <div class="d-flex">
                                <button class="btn btn-primary ms-auto">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Веб-хук инфо</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <vue-json-pretty :data="webhookInfo"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Alert from "@/components/Alert.vue";
import VueJsonPretty from "vue-json-pretty";
import 'vue-json-pretty/lib/styles.css';
import axiosClient from "@/core/axios-client.js";

export default {
    name: "Main",
    components: {
        VueJsonPretty,
        Alert,
    },
    data() {
        return {
            bot_token: null,
            webhook: null,
            webhookInfo: {},
            bot_username: null,
            language: 1,
            headerProps: [{
                breadcrumb: true,
                textBreadcrumb: 'Настройки',
                nameRoute: {
                    name: 'settings',
                },
            }],
        }
    },
    computed: {
        languages() {
            return this.$store.state.settings.language;
        },
    },

    mounted() {
        this.$emit('changeHeaderData', this.headerProps);

        axiosClient.get('/admin/settings/getSettings')
            .then((resp) => {
                this.webhook = resp.data.webhook;
                for (let i in resp.data.config) {
                    this[resp.data.config[i].key] = resp.data.config[i].value;
                }
                this.webhookInfo = resp.data.webhookInfo;
                this.languageItems = resp.data.language;
            });
    },

    methods: {
        saveSettings(data) {
            axiosClient
                .post('/admin/settings/setSettings', {
                    bot_token: this.bot_token,
                    bot_username: this.bot_username,
                    language: this.language,
                }).then((resp) => {
                this.$refs.alertRef.alert('Настройки сохранены', 'success')
            }).catch((error) => {
                this.$refs.alertRef.alert('Ошибка при сохранение', 'danger')
            });
        }
    }
}
</script>
