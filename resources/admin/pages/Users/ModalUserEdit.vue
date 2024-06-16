<template>
    <div class="modal modal-blur fade" ref="modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered  modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактирование пользователя</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="modal-body" @submit.prevent="saveUser" id="editFormUser">
                    <Alert ref="alertMessage"/>
                    <div class="mb-3">
                        <label class="form-label">Основной баланс:</label>
                        <input type="text"
                                  class="form-control"
                                  v-model="user.balance"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Замороженный баланс:</label>
                        <input type="text"
                                  class="form-control"
                                  v-model="user.locked_balance"
                        />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Реферальная ссылка:</label>
                        <input type="text"
                                  class="form-control"
                                  v-model="user.referral_link"
                        />
                    </div>
                </form>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Закрыть
                    </a>
                    <button class="btn btn-primary ms-auto" form="editFormUser">
                        Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {Modal} from "bootstrap";
import Alert from "@/components/Alert.vue";
import axiosClient from "@/core/axios-client.js";
export default {
    name: "ModalUserEdit",
    components: {Alert},
    data() {
        return {
            modal: null,
            user: {
                id: 0,
                balance: 0,
                locked_balance: 0,
                referral_link: null,
            }
        };
    },
    mounted() {
        this.modal = new Modal(this.$refs.modal);
    },
    methods: {
        show(item) {
            this.user = item;
            this.modal.show();
        },
        hide() {
            this.modal.hide();
        },
        saveUser() {
            axiosClient.post('/admin/users/editUser', {
                id: this.user.id,
                balance: this.user.balance,
                referral_link: this.user.referral_link,
                locked_balance: this.user.locked_balance
            }).then((resp) => {
                this.$refs.alertMessage.alert('Пользователь обновлен', 'success', '')

                setTimeout(() => {
                    this.hide();
                }, 1500)
            })
        },
    }
}
</script>
