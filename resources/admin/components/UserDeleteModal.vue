<template>
    <div class="modal modal-blur fade" id="modal-user-delete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Подтвердите удаление</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <p>Вы действительно хотите удалить пользователя?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Отмена</button>
                    <button type="button" class="btn btn-danger" @click="deleteUser">Удалить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as bootstrap from "bootstrap";
export default {
    props: {
        user: Object,
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        deleteUser() {
            this.$emit('deleteUser', this.user);
        },
    },
};
</script>
