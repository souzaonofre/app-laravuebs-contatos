<template>
  <div class="modal" tabindex="-1" id="modalFormContato">
    <div class="modal-dialog">
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
            <div class="mb-1">
              <label for="fcNome" class="form-label text-bold">Nome completo</label>
              <input type="text" tabindex="1" class="form-control" id="fcNome" placeholder="Fulano de Tal" >
            </div>
            <div class="mb-1">
              <label for="fcEmail" class="form-label text-bold">Email</label>
              <input type="email" tabindex="2" class="form-control" id="fcEmail" placeholder="usuario@dominio.com">
            </div>
            <div class="mb-1">
              <label for="fcTelefone" class="form-label text-bold">Telefone</label>
              <input type="tel" tabindex="3" class="form-control" id="fcTelefone" placeholder="(31) 3222-1133">
            </div>
            <div class="mb-1">
              <label for="fcCep" class="form-label text-bold">CEP</label>
              <input type="text" tabindex="4" class="form-control" id="fcCep" placeholder="30000-000">
            </div>
            <hr />
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
    }
  },

  watch: {
    modalOpen: {
      immediate: false,
      deep: false,
      handler: function(val) {
        if (val === true && this.modalObj) {
          this.modalObj.show();
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
        if (this.contatoData && val && String(val).toLowerCase() === 'editar') {
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
    console.log('elm', elmObj);
    this.modalObj = new Modal(elmObj, modalOpts);
    console.log(this.modalObj);

    console.log(this.modo, this.contatoData);
  },
};
</script>
