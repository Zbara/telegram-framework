<template>
    <ol class="breadcrumb breadcrumb-arrows ps-1" aria-label="breadcrumbs">
        <li class="breadcrumb-item" :class="{active: headersBreadcrumb.length === 0}">
            <RouterLink to="/admin">Главная</RouterLink>
        </li>
        <li v-for="(item, index) in headersBreadcrumb" :key="index" :class="{'breadcrumb-item': index !== headersBreadcrumb.length - 1, 'breadcrumb-item active': index === headersBreadcrumb.length - 1}" :aria-current="index === headersBreadcrumb.length - 1 ? 'page' : null">
            <RouterLink :to="item.nameRoute">{{ item.textBreadcrumb }}</RouterLink>
        </li>
    </ol>
</template>

<script>
export default {
    name: "Breadcrumb",

    props: {
        headersBreadcrumb: {
            type: Array
        }
    },
    computed: {
        lastItemIndex() {
            return this.headersBreadcrumb.length - 1;
        }
    }
}
</script>
