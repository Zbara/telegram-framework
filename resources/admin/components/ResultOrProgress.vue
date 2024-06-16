<template>
    <div v-if="isProgress || isResult" class="card">
        <div class="container-xl d-flex flex-column justify-content-center">
            <div class="empty">
                <p class="empty-subtitle text-muted" v-if="isProgress">
                    Загрузка данных...
                </p>
                <p class="empty-subtitle text-muted" v-if="isResult">
                    Нет результатов
                </p>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: 'progress',
        props: {
            isProgress: {
                type: Boolean,
                default: true
            },
            isResult: {
                type: Boolean,
                default: true
            },
        }
    };
</script>
