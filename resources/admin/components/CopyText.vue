<template>
    <span class=" cursor-pointer px-1" @click="copyText">
        <IconCopy v-if="!copyStatus" class="icon icon-tabler icon-tabler-trash" width="24" height="24"/>
        <IconCheck v-if="copyStatus" class="icon icon-tabler icon-tabler-trash" width="24" height="24"/>
    </span>
</template>

<script>
import {IconCopy, IconCheck} from '@tabler/icons-vue';
export default {
    props: {
        text: String,
        url: String
    },
    components: {
        IconCheck,
        IconCopy
    },
    data() {
        return {
            copyStatus: false,
        }
    },
    methods: {
        copyText() {
            const textArea = document.createElement("textarea");
            textArea.value = this.text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand("copy");
            document.body.removeChild(textArea);

            this.copyStatus = true;
        }
    }
};
</script>
