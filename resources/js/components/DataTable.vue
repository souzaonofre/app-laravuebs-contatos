<template>
  <div>
    <div class="card">
      <div class="card-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <div class="navbar-brand" href="#">
              <h3 class="text-primary">{{ "Agenda de Contatos" }}</h3>
            </div>
            <div>
              <button id="addContato"
                type="button"
                class="btn btn-primary"
                @click="inserirContato"
              >
                <span class="text-white">{{ 'Inserir Contato' }}</span>
              </button>
            </div>
          </div>
        </nav>
      </div>
      <div class="card-body">
        <table class="table table-striped">
          <thead class="table-primary">
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Email</th>
              <th scope="col">Telefone</th>
              <th scope="col">CEP</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="contato in contatos" :key="contato['nome']">
              <th scope="row">{{ contato["nome"] }}</th>
              <td>{{ contato["email"] }}</td>
              <td>{{ contato["telefone"] }}</td>
              <td>{{ contato["cep"] }}</td>
              <td>
                <div class="btn-group" role="group" aria-label="Acoes">
                  <button type="button"
                    class="btn btn-outline-warning"
                    @click="editarContato(contato)"
                  >
                    {{ "Editar" }}
                  </button>
                  <button type="button"
                    class="btn btn-outline-danger"
                    @click="removerContato(contato)"
                  >
                    {{ "Remover" }}
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <modal-form-contato
      :modalOpen="modalFormContatoOpen"
      :mode="formMode"
      :contatoData="contatoData"
      @close-modal="modalFormContatoOpen=false"

    />
  </div>
</template>

<script>
import ModalFormContato from './ModalFormContato.vue';
export default {
  components: { ModalFormContato },
  props: {
    contatos: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      contatoData: null,
      formMode: 'inserir',
      modalFormContatoOpen: false
    };
  },

  methods: {

    inserirContato() {
      this.contatoData = null;
      this.formMode = 'inserir';
      this.modalFormContatoOpen = true;
    },

    editarContato(contato = null) {},

    removerContato(contato = null) {},
  },

  mounted() {
    console.log("Component mounted.");
  },
};
</script>
