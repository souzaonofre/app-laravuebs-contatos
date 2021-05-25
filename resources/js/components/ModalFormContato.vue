<template>
  <div class="modal" tabindex="-1" id="modalFormContato">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title text-primary">{{ modalTitle }}</h3>
          <button
            type="button"
            class="btn-close"
            @click="$emit('close-modal')"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <form id="formContato" class="row g-3 align-items-center">
            <div class="row">
              <div class="col mb-1" title="Nome completo, ex: Fulano de Tal">
                <label for="fcNome" class="form-label text-primary text-bold">Nome completo</label>
                <input id="fcNome" ref="fcNome" tabindex="1"
                  type="text"
                  class="form-control"
                  v-model="formData.nome"
                >
              </div>
              <div class="col mb-1" title="Email válido">
                <label for="fcEmail" class="form-label text-primary text-bold">Email</label>
                <input id="fcEmail" tabindex="2"
                  type="email"
                  class="form-control"
                  v-model="formData.email"
                >
              </div>
            </div>
            <div class="row">
              <div class="col mb-1" title="Telefone para contato">
                <label for="fcTelefone" class="form-label text-primary text-bold">Telefone</label>
                <input id="fcTelefone" tabindex="3"
                  type="tel"
                  class="form-control"
                  v-model="formData.telefone"
                >
              </div>
              <div class="col mb-1" title="CEP do endereço do contato">
                <label for="fcCep" class="form-label text-primary text-bold">CEP</label>
                <input id="fcCep" tabindex="4"
                  type="text"
                  class="form-control"
                  v-model="formData.cep"
                >
              </div>
            </div>

            <hr />

            <div class="row">
              <div class="col-6 mb-1" title="Endereço, ex.: Rua ...">
                <label for="fcEndereco" class="form-label text-primary text-bold">Endereço</label>
                <input  id="fcEndereco" tabindex="6"
                  type="text"
                  class="form-control"
                  v-model="formData.endereco"
                >
              </div>
              <div class="col-2 mb-1" title="Numero da residencia no endereço">
                <label for="fcNumero" class="form-label text-primary text-bold">Numero</label>
                <input id="fcNumero" ref="fcNumero" tabindex="5"
                  type="text"
                  class="form-control"
                  v-model="formData.numero"
                >
              </div>
              <div class="col-4 mb-1" title="Bairro onde se localiza o endereço">
                <label for="fcBairro" class="form-label text-primary text-bold">Bairro</label>
                <input id="fcBairro" tabindex="7"
                  type="text"
                  class="form-control"
                  v-model="formData.bairro"
                >
              </div>
            </div>

            <div class="row">
              <div class="col-8 mb-1" title="Cidade onde se localiza o endereço">
                <label for="fcCidade" class="form-label text-primary text-bold">Cidade</label>
                <input id="fcCidade" tabindex="8"
                  type="text"
                  class="form-control"
                  v-model="formData.cidade"
                >
              </div>
              <div class="col-2 mb-1" title="Sigla do Estado onde se localiza a cidade">
                <label for="fcEstado" class="form-label text-primary text-bold">Estado</label>
                <input id="fcEstado" tabindex="9"
                  type="text"
                  class="form-control"
                  v-model="formData.estado"
                >
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-success"
            @click="salvarDados"
          >
            {{ "Salvar" }}
          </button>
          <button
            type="button"
            class="btn btn-primary"
            @click="emitCloseModal"
          >
            {{ "Fechar" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { Modal } from 'bootstrap';
import Api from '../services/api.js';
import { ADDRESS_URL, CONTATOS_URL } from '../env.js';

export default {
  props: {
    modalOpen: {
      type: Boolean,
      default: false
    },
    mode: {
      type: String,
      default: 'inserir'
    },
    contatoData: {
      type: Object,
      default: () => null
    }
  },

  data() {
    return {
      formData: {
        id: null,
        nome: null,
        email: null,
        telefone: null,
        cep: null,
        endereco: null,
        numero: null,
        bairro: null,
        cidade: null,
        estado: null
      },
      modalObj: null
    }
  },

  computed: {
    modalTitle() {
      const verb = this.mode === 'inserir' ? 'Inserir ' : 'Editar ';
      return `${verb} Contato`;
    },

    isInsertMode() {
      return String(this.mode).toLowerCase() === 'inserir';
    },

    isEditMode() {
      return String(this.mode).toLowerCase() === 'editar';
    }
  },

  methods: {
    emitCloseModal() {
      this.$emit('close-modal');
    },

    isValidFormData() {
      let requiredOk = true;
      Object.keys(this.formData).forEach((key) => {
        const val = this.formData[key];
        if (!val || String(val).length <= 0) {
          requiredOk = false;
          return;
        }
      });
      return requiredOk;
    },

    formAddressComplete(addrData=null) {
      console.log(addrData);
      if (addrData && Object.keys(addrData).includes('endereco')) {
        Object.keys(this.formData).forEach((key) => {
          if (Object.keys(addrData).includes(key)) {
            this.formData[key] = addrData[key];
            this.$refs.fcNumero.focus();
            this.$forceUpdate();
          }
        })
      }
    },

    searchAndCompleteAddress(cep='', using='fetch') {
      const baseUrl = ADDRESS_URL;
      const url = String(baseUrl).concat('/').concat(cep);
      const prm = Api.httpGet(url);
      prm.then(addrData => this.formAddressComplete(addrData));
    },

    salvarDados(using='fetch') {
      const url = CONTATOS_URL;
      //debugger;
      if (this.isValidFormData()) {
        const prm = Api.httpPost(url, this.formData);
        prm.then(resp => {
          alert('Dados salvos!');
          this.emitCloseModal();
        });

      } else {
        alert('Dados invalidos!');
      }

    }
  },

  watch: {
    modalOpen: {
      immediate: false,
      deep: false,
      handler: function(val) {
        if (val === true && this.modalObj) {
          this.modalObj.show();
          if (this.isInsertMode) {
            document.getElementById('fcNome').focus();
          }
        }
        if (val === false && this.modalObj) {
          this.modalObj.hide();
        }
      }
    },
    mode: {
      immediate: false,
      deep: false,
      handler: function(val) {
        if (this.contatoData && val && this.isEditMode) {
          Object.keys(this.formData).forEach((key, idx) => {
            if (Object.keys(this.contatoData).includes(key)) {
              this.formData[key] = this.contatoData[key];
            }
          });
        }
      }
    },
    'formData.cep': {
      immediate: false,
      deep: true,
      handler: function(val) {
        if (val && String(val).length >= 8) {
          this.searchAndCompleteAddress(val);
        }
      }
    }
  },

  mounted() {
    const modalOpts = { keyboard: true };
    const elmObj = document.getElementById('modalFormContato');
    console.log('modalElm', elmObj);
    this.modalObj = new Modal(elmObj, modalOpts);
    console.log(this.modalObj, this.mode, this.contatoData);
  },
};
</script>
