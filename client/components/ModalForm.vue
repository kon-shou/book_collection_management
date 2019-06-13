<template>
  <form action="">
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">本の登録</p>
      </header>
      <section class="modal-card-body">
        <b-field label="本のタイトル">
          <b-input type="input" v-model="title" placeholder="タイトル" required>
          </b-input>
        </b-field>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="button" @click="$parent.close()">
          閉じる
        </button>
        <button class="button is-primary" @click="registerBook">
          登録
        </button>
      </footer>
    </div>
  </form>
</template>

<script>
export default {
  name: 'ModalForm',
  props: {
    userId: String
  },
  data() {
    return {
      title: ''
    }
  },
  methods: {
    registerBook: function() {
      this.$axios
        .post('/book/register', {
          user_id: this.userId,
          title: this.title
        })
        .then(response => {
          console.log(response)
        })

      this.$parent.close()
    }
  }
}
</script>

<style scoped></style>
