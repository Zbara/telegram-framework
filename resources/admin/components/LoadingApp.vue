<script>
export default {
    name: "LoadingApp",
    props: {
        isActive: {
            type: Boolean,
        }
    }
}
</script>

<template>
    <div class="page page-center" v-if="isActive">
        <div class="container container-slim" style="margin-top: 45vh;">
            <div class="text-center">
                <div class="text-secondary mb-3">Загрузка данных панели...</div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-indeterminate"></div>
                </div>
            </div>
        </div>
    </div>
</template>
