<template>
    <div class="container-xl d-flex flex-column justify-content-center" v-if="isActive">
        <div class="empty">
            <p class="empty-subtitle text-muted">
                Загрузка данных
            </p>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'progress',
        props: {
            isActive: {
                type: Boolean,
                default: true
            },
        }
    };
</script>
