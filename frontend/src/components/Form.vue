<template>
    <form :id="id" autocomplete="off">
        <slot></slot>
        <button v-if="button" class="btn btn-primary" v-on:click.prevent="send">Criar</button>
    </form>
</template>

<script>
import $ from 'jquery';

export default {
    props: ['id', 'button', 'url', 'body', 'campos', 'alerta'],
    data: function() {
        return {
            nome: "",
            email: ""
        }
    },
    methods: {
        send: function() {

            let body = {};

            for (let i = 0; i < this.campos.length; i++) {
                body[this.body[i]] = $('#' + this.campos[i]).val()
            }

            this.axios.post(this.url, body, {
                headers: {
                    'Content-type': 'application/json'
                }
            }).then(response => {

                if(response.status == 200) {

                    let resultado = response.data;

                    if(resultado.retorno == "OK") {
                        if(this.alerta) {
                            alert('Operação realizada com sucesso!');
                        } else {
                            alert("[id: "+resultado.detalhes.id+", nome: "+resultado.detalhes.nome+", email: "+resultado.detalhes.email+"] foi cadastrado com sucesso!");
                        }
                    } else {
                        alert("Ocorreu um erro: "+resultado.detalhes);
                    }

                    location.reload();
                }

            });
        }
    }
}
</script>