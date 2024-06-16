<template>
    <div class="container-xl d-flex flex-column justify-content-center" v-if="isActive">
        <div class="empty">
            <p class="empty-subtitle text-muted">
                Нет результатов
            </p>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'NoResult',
        props: {
            isActive: {
                type: Boolean,
                default: true
            },
        }
    };
</script>
