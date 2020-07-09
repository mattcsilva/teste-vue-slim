<template>
    <li class="nav-item">
        <a :class="'nav-link' + active" :href="'#' + tabName" data-toggle="tab">{{titulo}}</a>
    </li>
</template>

<script>
export default {
    props: ['selecionado', 'tabName', 'titulo'],
    computed: {
        active: function() {
            return this.selecionado ? ' active' : '';
        }
    }
}
</script>