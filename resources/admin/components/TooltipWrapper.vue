<template>
    <div>
        <slot ref="trigger" @mouseover="showTooltip" @mouseout="hideTooltip"></slot>
    </div>
</template>

<script>
import { onMounted, ref, watchEffect } from 'vue';
import { Tooltip } from 'bootstrap';

export default {
    setup(props) {
        const tooltipInstance = ref(null);
        const triggerRef = ref(null);

        onMounted(() => {
            tooltipInstance.value = new Tooltip(triggerRef.value, props.options);
        });

        watchEffect(() => {
            tooltipInstance.value?.dispose();
            tooltipInstance.value = new Tooltip(triggerRef.value, props.options);
        });

        const showTooltip = () => {
            tooltipInstance.value?.show();
        };

        const hideTooltip = () => {
            tooltipInstance.value?.hide();
        };

        return {
            triggerRef,
            showTooltip,
            hideTooltip,
        };
    },
    props: {
        options: Object,
    },
};
</script>
