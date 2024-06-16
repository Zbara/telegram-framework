<template>
    <div class="row row-cards">
        <div class="col-xl-12">
            <div class="card">
                <form class="card-body" @submit.prevent="search">
                    <div class="row row-cards">
                        <div class="col-md-2">
                            <label class="form-label required">Имя клиента или username</label>
                            <input type="text" class="form-control" name="name" v-model="searchForm.name"
                                   placeholder="Введите имя клиента">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Статус</label>
                            <div>
                                <select class="form-select" name="status" v-model="searchForm.status">
                                    <option value="-1">Не выбран</option>
                                    <option value="1">Активный</option>
                                    <option value="0">Заблокирован</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label required">Дата регистрации</label>
                            <input type="date" class="form-control" name="created_at" v-model="searchForm.created_at">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"> &nbsp; </label>
                            <div class="row align-items-center">
                                <div class="col-auto" v-if="filterStatus">
                                    <button class="btn btn-secondary" @click="clearForm(this)">
                                        Сбросить
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-primary">
                                        Фильтр
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <ResultOrProgress :is-progress="isload" :is-result="noResult"/>
                <div class="card-header" v-if="!noResult && !isload">
                    <h3 class="card-title">Список пользователей - {{countUsers}} </h3>
                </div>
                <div class="table-responsive" v-if="!noResult && !isload">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                        <tr>
                            <th @click="sortTable('platform_id')" class="cursor-pointer">
                                ID - Tg
                                <span v-if="sortColumn === 'telegram_id'">
                                    {{ sortType === 'desc' ? '▲' : '▼' }}
                                </span>
                            </th>
                            <th @click="sortTable('username')" class="cursor-pointer">
                                UserName
                                <span v-if="sortColumn === 'username'">
                                    {{ sortType === 'desc' ? '▲' : '▼' }}
                                </span>
                            </th>
                            <th @click="sortTable('first_name')" class="cursor-pointer">
                                Имя
                                <span v-if="sortColumn === 'first_name'">
                                    {{ sortType === 'desc' ? '▲' : '▼' }}
                                </span>
                            </th>
                            <th>Статус</th>
                            <th @click="sortTable('created_at')" class="cursor-pointer">
                                Первый запуск
                                <span v-if="sortColumn === 'created_at'">
                                    {{ sortType === 'desc' ? '▲' : '▼' }}
                                </span>
                            </th>
                            <th @click="sortTable('last_activity')" class="cursor-pointer">
                                Последняя активность
                                <span v-if="sortColumn === 'last_activity'">
                                    {{ sortType === 'desc' ? '▲' : '▼' }}
                                </span>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in usersItem" :data-user-id="item.id">
                            <td>
                                {{ item.telegram_id }}
                            </td>
                            <td>
                                {{ item.username ?? 'no user name' }}
                            </td>
                            <td>
                                {{ item.first_name }}
                            </td>
                            <td>
                                <template v-if="item.is_status === 0">
                                    <span class="badge bg-danger me-1"></span> Заблокирован
                                </template>
                                <template v-if="item.is_status === 3">
                                    <span class="badge bg-danger me-1"></span> Заблокировал
                                </template>
                                <template v-if="item.is_status === 1">
                                    <span class="badge bg-success me-1"></span> Активен
                                </template>
                            </td>
                            <td>
                                {{ getDate(item.created_at) }}
                            </td>
                            <td>
                                {{ getDate(item.last_activity) }}
                            </td>
                            <td class="text-nowrap text-muted">
                                <span class="col-auto ms-2" @click="editModal(item.id)">
                                    <IconEdit class="icon cursor-pointer" width="24" height="24"/>
                                </span>

                                <span class="col-auto ms-2" @click="formMessage(item.id)">
                                    <IconSend class="icon cursor-pointer" width="24" height="24"/>
                                </span>
                                <span class="text-muted cursor-pointer ms-2" data-bs-toggle="dropdown">
                                    <IconPower class="icon icon-tabler icon-tabler-trash" width="24" height="24"/>
                                </span>
                                <div class="dropdown-menu dropdown-menu-end" @click="status" :data-id="item.id">
                                    <div class="dropdown-item cursor-pointer" data-status-id="0"
                                         v-if="item.is_status === 1">
                                        Заблокирован
                                    </div>
                                    <div class="dropdown-item cursor-pointer" data-status-id="1"
                                         v-if="item.is_status === 0">
                                        Активный
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center" v-if="totalItems >= 1 && !filterStatus">
                    <div class="pagination m-0 ms-auto">
                        <paginate
                            :page-count="totalItems"
                            :click-handler="getUsers"
                            :initial-page="this.$route.query.page"
                            :prev-text="'&lsaquo;'"
                            :next-text="'&rsaquo;'"
                            :container-class="'pagination'"
                        >
                        </paginate>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ModalUserEdit ref="modalUserEdit"/>

    <div class="modal" id="messageModal" aria-hidden="true" aria-labelledby="messageModalLabel"
         tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Отправка сообщения для - {{ form.first_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" @submit.prevent="sendMessage" id="messageFormUser">
                    <Alert ref="alertMessage"/>
                    <div class="mb-3">
                        <label class="form-label">Введите сообщение</label>
                        <textarea type="text"
                                  rows="15"
                                  class="form-control"
                                  name="message"
                                  placeholder="Введите текст сообщения..."
                                  v-model="form.messages"
                                  v-bind:class="{'is-invalid': this.error.message}"
                                  required
                                  @focus="hideError"
                        />
                        <div class="invalid-feedback">{{ this.error.text.message }}</div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-primary ms-auto" form="messageFormUser">
                        Отправить сообщение
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment/min/moment-with-locales";
import {IconEdit, IconPower, IconAlarm, IconUsers, IconTrash, IconRefresh, IconSend} from '@tabler/icons-vue';
import Paginate from "vuejs-paginate-next";
import {Modal} from "bootstrap";
import Noresult from "@/components/NoResult.vue";
import ResultOrProgress from "@/components/ResultOrProgress.vue";
import UserDeleteModal from "@/components/UserDeleteModal.vue";
import Alert from "@/components/Alert.vue";
import axiosClient from "@/core/axios-client.js";
import ModalUserEdit from "@/pages/Users/ModalUserEdit.vue";
import 'tom-select/dist/css/tom-select.bootstrap5.css'

export default {
    name: "users",
    components: {
        ModalUserEdit,
        Alert,
        UserDeleteModal,
        Noresult,
        ResultOrProgress,
        paginate: Paginate,
        IconEdit,
        IconPower,
        IconAlarm,
        IconUsers,
        IconTrash,
        IconRefresh,
        IconSend,
    },
    data() {
        return {
            usersItem: [],
            filterStatus: false,
            noResult: false,
            editUserName: null,
            editCreatedAtDate: 0,
            totalItems: 0,
            countUsers: 0,
            headerProps: [{
                breadcrumb: true,
                textBreadcrumb: 'Пользователи бота',
                nameRoute: {
                    name: 'users',
                },
            }],
            initialDate: new Date().toISOString().substr(0, 10),
            searchForm: {
                name: null,
                status: -1,
                phone: null,
                created_at: null,
            },
            sortType: 'desc',
            sortColumn: 'created_at',
            selectedUserToDelete: null,
            isload: true,
            error: {
                referral: false,
                message: false,
                text: {
                    referral: null,
                    message: null
                }
            },
            form: {
                first_name: null,
                id: 0,
                messages: null
            },
            messageModal: null,
        }
    },
    watch: {
        '$route.query': {
            immediate: true,
            handler() {
                this.getUsers(this.$route.query.page);
            },
        },
    },
    mounted() {
        this.$emit('changeHeaderData', this.headerProps);
        this.messageModal = new Modal(document.getElementById('messageModal'));
    },
    methods: {
        editModal(userId){
            this.$refs.modalUserEdit.show(this.usersItem.find(x => x.id === userId))
        },
        async getUsers(pageNum) {
            this.filterStatus = false;
            this.noResult = false;

            await this.$router.push({
                query: {
                    ...this.$route.query,
                    page: pageNum,
                    ...this.searchForm
                }
            });

            axiosClient.get('/admin/users/getUsers', {
                params: {...this.$route.query}
            }).then(({data}) => {
                if (data.response.length) {
                    this.usersItem = data.response;
                    this.countUsers = data.meta.total;
                    this.totalItems = Math.round(data.meta.total / 20);
                } else this.noResult = true;

            }).finally(() => {
                this.isload = false
            })
        },

        search() {
            axiosClient.get('/admin/users/getUsers', {
                params: {
                    ...this.$route.query,
                    ...this.searchForm
                }
            }).then(({data}) => {
                this.filterStatus = true;

                if (data.response.length) {
                    this.usersItem = data.response;
                    this.countUsers = data.meta.total;
                    this.totalItems = Math.round(data.meta.total / 20);
                } else this.noResult = true;

            }).finally(() => {
                this.isload = false
            })
        },
        getDate(date) {
            if (date !== null) {
                return moment(date).locale(window.navigator.language).format('L H:mm')
            }
            return 'No Date'
        },
        status(event) {
            let itemId = parseInt(event.currentTarget.dataset.id);
            let statusId = parseInt(event.target.dataset.statusId);

            axiosClient.post('/admin/users/setStatus', {
                id: itemId,
                status: statusId,
            }).then((resp) => {
                let item = this.usersItem.findIndex(x => x.id === itemId);

                this.usersItem[item].is_status = statusId;
            })
        },

        clearForm() {
            this.getUsers(1);
            this.searchForm.status = 1;
            this.searchForm.name = null;
            this.searchForm.phone = null;
            this.searchForm.created_at = null;
        },

        async sortTable(type){
            if(this.sortType === 'desc'){
                this.sortType = 'asc';
            } else this.sortType = 'desc';

            this.sortColumn = type;

            await this.$router.push({
                query: {
                    ...this.$route.query,
                    sort: type,
                    direction: this.sortType,
                }
            });

            axiosClient.get('/admin/users/getUsers', {
                params: {...this.$route.query}
            }).then(({data}) => {
                if (data.response.length) {
                    this.usersItem = data.response;
                    this.countUsers = data.meta.total;

                    if (this.$route.query.page === 1) {
                        this.totalItems = Math.round(data.meta.total / 20);
                    }
                } else this.noResult = true;

            });
        },
        hideError(el) {
            if (this.error[el.target.name] !== undefined) {
                this.error[el.target.name] = false;
            }
        },
        formMessage(userId){
            let item = this.usersItem.find(x => x.id === userId);

            if(item){
                this.form.id = item.id;
                this.form.first_name = item.first_name;
                this.messageModal.show();
            }
        },
        sendMessage(){
            axiosClient.post('/admin/users/sendMessage', {
                id: this.form.id,
                message: this.form.messages
            }).then((resp) => {
                this.$refs.alertMessage.alert('Сообщение отправлено.', 'success', '')

                setInterval(() => {
                    this.form.id = null;
                    this.form.first_name = null;
                    this.form.messages = null;

                    this.messageModal.hide();
                }, 2200)

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
    }
}
</script>
