<template>
    <div>
        <RowCol classCol="col-12" v-if="button">
            <div class="d-flex justify-content-center p-3">
                <button class="btn btn-primary" @click="load">Listar Vendedores</button>
            </div>
        </RowCol>
        <table class="table table-bordered">
            <slot name="thead"></slot>
            <tbody>
                <tr v-for="item in itemsTable" :key="item.ID">
                    <th scope="row" v-for="i in item" :key="i">{{i}}</th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import RowCol from './RowCol.vue';

    export default {
        props: ['url', 'button'],
        components: {
            RowCol
        },
        data: function() {
            return {
                itemsTable: [],
            }
        },
        methods: {
            load: function() {
                this.axios.get(this.url).then(response => {
                    if(response.status == 200)
                        this.itemsTable = response.data.detalhes;
                    else
                        this.itemsTable = [];
                }).catch(function(e){
                    alert(e);
                });
            }
        },
    }

</script>
