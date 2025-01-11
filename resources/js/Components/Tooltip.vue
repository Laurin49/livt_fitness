<template>
    <div class="tooltip-wrapper" @mouseover="showTooltip" @mouseout="hideTooltip">
        <slot></slot>
        <div v-if="visible" class="tooltip" :class="position">
            {{ text }}
        </div>
    </div>
</template>
<script>
export default {
    props: {
        text: { type: String, required: true },
        position: { type: String, default: 'top' }, // top, right, bottom, left
    },
    data() {
        return {
            visible: false,
        };
    },
    methods: {
        showTooltip() {
            this.visible = true;
        },
        hideTooltip() {
            this.visible = false;
        },
    },
};
</script>
<style scoped>
.tooltip-wrapper {
    position: relative;
    display: inline-block;
}

.tooltip {
    position: absolute;
    background-color: #333;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    white-space: nowrap;
    font-size: 12px;
    z-index: 1000;
}

.tooltip.top {
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-bottom: 5px;
}

.tooltip.right {
    top: 50%;
    left: 100%;
    transform: translateY(-50%);
    margin-left: 5px;
}

.tooltip.bottom {
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    margin-top: 5px;
}

.tooltip.left {
    top: 50%;
    right: 100%;
    transform: translateY(-50%);
    margin-right: 5px;
}
</style>
