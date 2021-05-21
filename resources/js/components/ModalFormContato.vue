<template>
  <div class="modal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <p>Modal body text goes here.</p>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal"
          >
            {{ "Fechar" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modo: {
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
      }
    }
  },

  watch: {
    modo: {
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
    console.log(this.modo, this.contatoData);
  },
};
</script>
