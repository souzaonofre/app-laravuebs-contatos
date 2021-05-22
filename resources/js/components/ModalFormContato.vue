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
                <input type="text" tabindex="1" class="form-control" id="fcNome" ref="fcNome">
              </div>
              <div class="col mb-1" title="Email válido">
                <label for="fcEmail" class="form-label text-primary text-bold">Email</label>
                <input type="email" tabindex="2" class="form-control" id="fcEmail">
              </div>
            </div>
            <div class="row">
              <div class="col mb-1" title="Telefone para contato">
                <label for="fcTelefone" class="form-label text-primary text-bold">Telefone</label>
                <input type="tel" tabindex="3" class="form-control" id="fcTelefone">
              </div>
              <div class="col mb-1" title="CEP do endereço do contato">
                <label for="fcCep" class="form-label text-primary text-bold">CEP</label>
                <input type="text" tabindex="4" class="form-control" id="fcCep">
              </div>
            </div>
            <hr />
            <div class="row">
              <div class="col-6 mb-1" title="Endereço, ex.: Rua ...">
                <label for="fcEndereco" class="form-label text-primary text-bold">Endereço</label>
                <input type="text" tabindex="6" class="form-control" id="fcEndereco">
              </div>
              <div class="col-2 mb-1" title="Numero da residencia no endereço">
                <label for="fcNumero" class="form-label text-primary text-bold">Numero</label>
                <input type="text" tabindex="5" class="form-control" id="fcNumero" ref="fcNumero">
              </div>
              <div class="col-4 mb-1" title="Bairro onde se localiza o endereço">
                <label for="fcBairro" class="form-label text-primary text-bold">Bairro</label>
                <input type="text" tabindex="7" class="form-control" id="fcBairro">
              </div>
            </div>
            <div class="row">
              <div class="col-8 mb-1" title="Cidade onde se localiza o endereço">
                <label for="fcCidade" class="form-label text-primary text-bold">Cidade</label>
                <input type="text" tabindex="8" class="form-control" id="fcCidade">
              </div>
              <div class="col-2 mb-1" title="Sigla do Estado onde se localiza a cidade">
                <label for="fcEstado" class="form-label text-primary text-bold">Estado</label>
                <input type="text" tabindex="9" class="form-control" id="fcEstado">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            @click="$emit('close-modal')"
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
