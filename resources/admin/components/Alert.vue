<template>
    <div :class="style" v-if="isShow">
        <div :class="`alert alert-` + this.type" role="alert">
            <div class="d-flex">
                <div v-if="this.type === 'success'">
                   <IconCheck class="icon alert-icon" width="24" height="24"/>
                </div>
                <div v-if="this.type === 'warning'">
                    <IconAlertTriangle class="icon alert-icon" width="24" height="24"/>
                </div>
                <div v-if="this.type === 'danger'">
                    <IconAlertCircle class="icon alert-icon" width="24" height="24"/>
                </div>
                <div>
                    {{ this.message }}
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import {
    IconAlertCircle,
    IconAlertTriangle,
    IconCheck,
} from "@tabler/icons-vue";

export default {
    components: {
        IconCheck, IconAlertTriangle, IconAlertCircle
    },
    data() {
        return {
            message: null,
            type: null,
            isShow: false,
            style: 'p-2',
        }
    },
    methods: {
        alert(message, type, style = 'p-2') {
            this.isShow = true;
            this.message = message;
            this.type = type;
            this.style = style;

            setTimeout(() => {
                this.isShow = false;
            }, 30000);
        },
    },
};
</script>
