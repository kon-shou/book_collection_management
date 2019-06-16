<template>
  <form action="">
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">本の登録</p>
      </header>
      <section class="modal-card-body">
        <b-field label="本のタイトル">
          <b-input v-model="title" type="input" placeholder="タイトル" required>
          </b-input>
        </b-field>
        <b-field label="本のページ数">
          <b-input
            v-model="totalPage"
            type="input"
            placeholder="ページ数"
            required
          >
          </b-input>
        </b-field>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="button" @click="$parent.close()">
          閉じる
        </button>
        <button class="button is-primary" @click.prevent="dispatchSubmit">
          登録
        </button>
      </footer>
    </div>
  </form>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component({})
export default class extends Vue {
  title = ''
  totalPage = null

  dispatchSubmit() {
    this.$emit('submit', { title: this.title, totalPage: this.totalPage })
  }
}
</script>

<style scoped></style>
