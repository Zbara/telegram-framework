<template>
    <div class="row row-cards">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Всего пользователей</div>
                    <div class="h3 m-0">{{ mainInfo.total }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Активные</div>
                    <div class="h3 m-0">{{ mainInfo.active }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Не активные</div>
                    <div class="h3 m-0">{{ mainInfo.banned }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="subheader">Онлайн за 24 часа</div>
                    <div class="h3 m-0">{{ mainInfo.online }}</div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import UtilitiesService from "../services/utilities.service";

export default {
    name: "Main",
    data() {
        return {
            headerProps: [],
            mainInfo: {}
        }
    },
    mounted() {
        this.$emit('changeHeaderData', this.headerProps);

        UtilitiesService.getMain().then((res) => {
            this.mainInfo = res.data.stats;
        }).catch(error => {
            console.log(error)
        })
    }
}
</script>

<style scoped>

</style>
