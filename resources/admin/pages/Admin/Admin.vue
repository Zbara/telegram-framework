<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Администраторы системы</h3>
            <div class="card-body">
                <div class="d-flex">
                    <div class="ms-auto text-muted">
                        <button class="btn btn-primary d-sm-inline-block" @click="modal.show()">
                            Добавить аккаунт
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Имя</th>
                    <th>Role</th>
                    <th>Дата создания</th>
                    <th>Дата изменения</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <template v-for="item in accountItems">
                    <tr :data-id="item.id">
                        <td>
                            {{ item.id }}
                        </td>
                        <td>
                            {{ item.email }}
                        </td>
                        <td>
                            {{ item.name }}
                        </td>
                        <td>
                            {{ item.role }}
                        </td>
                        <td>
                            {{ getDate(item.created_at) }}
                        </td>
                        <td>
                            {{ getDate(item.updated_at) }}
                        </td>
                        <td class="text-nowrap text-muted">
                            <span class="text-muted cursor-pointer" @click="removeAuth" :data-id="item.id" v-if="item.role_id === 1 || item.role_id === 2">
                                <IconTrash class="icon icon-tabler icon-tabler-trash" width="24" height="24"/>
                            </span>
                            <RouterLink class="text-muted cursor-pointer" :to="{name: 'settings.admin.edit', params: {id: item.id}}">
                                <IconEdit class="icon icon-tabler icon-tabler-trash" width="24" height="24"/>
                            </RouterLink>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal" ref="authAccountModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавление администратора</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" @submit.prevent="createAccount" id="authAdmin">
                    <div class="mb-3">
                        <label class="form-label required">Имя</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.name"
                            placeholder="Введите имя"
                            @focus="hideError"
                            v-bind:class="{'is-invalid': this.error.name}"
                        />
                        <div class="invalid-feedback">{{ this.error.text.name }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.email"
                                placeholder="Введите email"
                                @focus="hideError"
                                v-bind:class="{'is-invalid': this.error.email}"
                            />
                        <div class="invalid-feedback">{{ this.error.text.email }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Пароль</label>
                        <input
                            type="password"
                            class="form-control"
                            v-model="form.password"
                            placeholder="Введите пароль"
                            @focus="hideError"
                            v-bind:class="{'is-invalid': this.error.password}"
                        />
                        <div class="invalid-feedback">{{ this.error.text.password }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Роль</label>
                        <div>
                            <select
                                    class="form-select"
                                    v-model="form.role_id"
                                    @focus="hideError"
                                    v-bind:class="{'is-invalid': this.error.role_id}"
                            >
                                <option v-for="item in roleItems" :key="item" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
                        <div class="invalid-feedback">{{ this.error.text.role_id }}</div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-primary ms-auto" form="authAdmin">
                        Создать
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {IconTrash, IconEdit} from "@tabler/icons-vue";
import * as bootstrap from "bootstrap";
import moment from "moment/min/moment-with-locales";
import axiosClient from "@/core/axios-client.js";

export default {
    name: "Admin",
    components: {IconTrash, IconEdit},
    data() {
        return {
            accountItems: {},
            headerProps: [{
                breadcrumb: true,
                textBreadcrumb: 'Администраторы системы',
                nameRoute: {
                    name: 'settingsAdmin',
                },
            }],
            form: {
                name: '',
                email: '',
                password: '',
                role_id: 0,
            },
            error: {
                text: {
                    name: null,
                    email: null,
                    password: null,
                    role_id: null,
                },
                name: false,
                email: false,
                password: false,
                role_id: false,
            },
            modal: [],
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
            ]
        }
    },
    mounted() {
        this.$emit('changeHeaderData', this.headerProps);
        this.getAccount();
        this.modal = new bootstrap.Modal(this.$refs.authAccountModal);
    },

    methods: {
        getAccount(){
            axiosClient.get('/admin/settings/getAdmin').then((resp) => {
                this.accountItems = resp.data.result;
            });
        },
        createAccount(){
            axiosClient.post('/admin/settings/createdAdmin', this.form).then((resp) => {
                this.modal.hide();
                this.getAccount();
            }).catch((error) => {
                if (error.response.data && error.response.data.errors) {
                    for (let i in error.response.data.errors) {
                        let text = error.response.data.errors[i][0];

                        if (this.error[i] !== undefined) {
                            this.error[i] = true;
                            this.error.text[i] = text;
                        }
                    }
                }
            });
        },
        removeAuth(event){
            let itemId = parseInt(event.currentTarget.dataset.id);
            axiosClient.post('/admin/settings/removeAdmin',{
                id: itemId,
            }).then((resp) => {
                let item = this.accountItems.findIndex(x => x.id === itemId);
                this.accountItems.splice(item, 1)
            });
        },
        hideError(el) {
            if (this.error[el.target.name] !== undefined) {
                this.error[el.target.name] = false;
            }
        },
    }
}
</script>
