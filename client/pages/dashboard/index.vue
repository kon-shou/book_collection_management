<template>
  <section class="has-text-centered">
    <div class="card has-text-centered">
      <header class="card-header">
        <p class="card-header-title has-text-grey">
          Now Reading ... !
        </p>
      </header>

      <footer class="card-footer">
        <div class="card-footer-item has-text-centered">
          <table class="table">
            <tr>
              <th>タイトル</th>
              <th>読んだページ数</th>
              <th></th>
            </tr>
            <tr v-for="book in books" :key="book.id">
              <td>{{ book.title }}</td>
              <td>
                <input
                  class="slider is-fullwidth"
                  step="1"
                  min="0"
                  max="100"
                  value="50"
                  type="range"
                />
              </td>
              <td>
                <button class="button" @click="finishReading(book.id)">
                  読了！
                </button>
              </td>
            </tr>
          </table>
        </div>
      </footer>
    </div>

    <div class="bottom">
      <button
        class="button is-medium is-primary"
        @click.prevent="$router.push('/bookshelf/personal')"
      >
        個人用の本棚を見る
      </button>
      <button
        disabled
        class="button is-medium is-info"
        @click.prevent="$router.push('/bookshelf/organization')"
      >
        オフィスの本棚を見る
      </button>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import _ from 'lodash'

@Component({
  components: {
    ModalForm: () => import('~/components/ModalForm.vue')
  },
  async asyncData({ store, app }) {
    const user = await app.$userRepository.find(store.state.auth.user.id)
    const books = await app.$bookRepository.findAllBooksByBorrowUser(user)

    return {
      books,
      user
    }
  }
})
export default class extends Vue {
  private isComponentModalActive = false
  private books
  private user

  async finishReading(bookId) {
    const book = _.find(this.books, book => book.id === bookId)
    await this.$bookRepository.endBorrow(book, this.user)
    this.books = await this.$bookRepository.findAllBooksByBorrowUser(this.user)
  }
}
</script>
