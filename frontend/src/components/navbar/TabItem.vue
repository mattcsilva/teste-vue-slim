<template>
    <div :class="'tab-pane fade show' + active" :id="id" role="tab">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: ['id', 'selecionado'],
    computed: {
        active: function() {
            return this.selecionado ? ' active' : '';
        }
    }
}
</script>