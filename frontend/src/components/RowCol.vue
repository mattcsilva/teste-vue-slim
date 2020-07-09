<template>
    <div class="row">
        <div :class="classCol">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    props: ['classCol']
}
</script>