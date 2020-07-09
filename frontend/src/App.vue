<template>
    <div id="app">
        <div class="container pt-2">
            <ul class="nav nav-tabs justify-content-center" id="tab">
                <NavItem :selecionado="true" tabName="criar_vendedor" titulo="Criar vendedor"></NavItem>
                <NavItem :selecionado="false" tabName="listar_vendedores" titulo="Listar todos os Vendedores"></NavItem>
                <NavItem :selecionado="false" tabName="lancar_nova_venda" titulo="Lançar nova Venda"></NavItem>
                <NavItem :selecionado="false" tabName="listar_todas_vendas_vendedor"
                    titulo="Listar todas as vendas de um vendedor"></NavItem>
                <NavItem :selecionado="false" tabName="enviar_email" titulo="E-mail"></NavItem>
            </ul>
            <div class="tab-content">
                <TabItem id="criar_vendedor" :selecionado="true">
                    <RowCol classCol="col-12">
                        <FormComponent id="criar_vendedor" url="/vendedor" :button="true" :body="['nome', 'email']"
                            :campos="['txtNome', 'txtEmailCriar']">
                            <div class="form-group">
                                <label for="txtNome">Nome</label>
                                <input type="txt" class="form-control" id="txtNome" name="nome"
                                    placeholder="Informe o nome do vendedor">
                            </div>
                            <div class="form-group">
                                <label for="txtEmailCriar">Email</label>
                                <input type="email" class="form-control" id="txtEmailCriar" name="email"
                                    placeholder="Informe o email do vendedor">
                            </div>
                        </FormComponent>
                    </RowCol>
                </TabItem>
                <TabItem id="listar_vendedores">
                    <div class="pt-3">
                        <TableComponent url="/vendedor" :button="true">
                            <thead slot="thead">
                                <tr>
                                    <th data-field="id">ID</th>
                                    <th data-field="NOME">Nome</th>
                                    <th data-field="EMAIL">Email</th>
                                    <th data-field="COMISSAO">Comissão</th>
                                </tr>
                            </thead>
                        </TableComponent>
                    </div>
                </TabItem>
                <TabItem id="lancar_nova_venda">
                    <RowCol classCol="col-12">
                        <FormComponent id="criar_vendedor" url="/venda" :button="true" :body="['id', 'valor']"
                            :campos="['txtIdVendedor', 'txtValorVenda']">
                            <div class="form-group">
                                <label for="txtIdVendedor">Id do vendedor</label>
                                <input type="txt" class="form-control" id="txtIdVendedor"
                                    placeholder="Informe o id do vendedor">
                            </div>
                            <div class="form-group">
                                <label for="txtValorVenda">Valor da venda</label>
                                <input type="number" class="form-control" id="txtValorVenda"
                                    placeholder="Informe o valor da venda">
                            </div>
                        </FormComponent>
                    </RowCol>
                </TabItem>
                <TabItem id="listar_todas_vendas_vendedor">
                    <RowCol classCol="col-12">
                        <FormComponent>
                            <div class="form-group">
                                <label for="txtIdVendedorListar">Id do vendedor</label>
                                <input type="txt" class="form-control" id="txtIdVendedorListar"
                                    placeholder="Informe o id do vendedor" v-model="idVendedor">
                            </div>
                        </FormComponent>
                        <TableComponent :url="'/venda?id=' + idVendedor" :button="true">
                            <thead slot="thead">
                                <tr>
                                    <th data-field="id">ID</th>
                                    <th data-field="NOME">Nome</th>
                                    <th data-field="EMAIL">Email</th>
                                    <th data-field="COMISSAO">Comissão</th>
                                    <th data-field="VALOR">Valor da Venda</th>
                                    <th data-field="DATA">Data da Venda</th>
                                </tr>
                            </thead>
                        </TableComponent>
                    </RowCol>
                </TabItem>
                <TabItem id="enviar_email">
                    <RowCol classCol="col-12">
                        <FormComponent id="criar_vendedor" url="/email" :button="true" :body="['emailauth', 'senhaauth', 'emailenviar']"
                            :campos="['txtEmailAuth', 'txtSenha', 'txtEmailEnviar']" :alerta="true">
                            <div class="form-group">
                                <label for="txtEmailAuth">Email para Autenticação [GMAIL]</label>
                                <input type="email" class="form-control" id="txtEmailAuth"
                                    placeholder="Informe o email para autenticar">
                            </div>
                            <div class="form-group">
                                <label for="txtSenha">Senha para Autenticação</label>
                                <input type="password" class="form-control" id="txtSenha"
                                    placeholder="Informe a senha para autenticar">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="txtEmailEnviar">Email para envio do relatório</label>
                                <input type="email" class="form-control" id="txtEmailEnviar"
                                    placeholder="Informe o email para quem deseja enviar">
                            </div>
                        </FormComponent>
                    </RowCol>
                </TabItem>
            </div>
        </div>
    </div>
</template>

<script>
    import RowCol from './components/RowCol.vue';
    import NavItem from './components/navbar/NavItem.vue';
    import TabItem from './components/navbar/TabItem.vue';
    import FormComponent from './components/Form.vue';
    import TableComponent from './components/Table.vue';

    export default {
        name: 'App',
        components: {
            RowCol,
            NavItem,
            TabItem,
            FormComponent,
            TableComponent
        },
        data: function () {
            return {
                idVendedor: ""
            }
        }
    }
</script>

<style>
    #app {
        font-family: Avenir, Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
        margin-top: 60px;
    }
</style>