<template>
  <section>
    <table class="table">
      <tr>
        <th>タイトル</th>
        <th>ステータス</th>
        <th></th>
      </tr>
      <tr v-for="book in books" :key="book.id">
        <td>{{ book.title }}</td>
        <td>{{ book.isBorrowed ? '読書中' : '' }}</td>
        <td>
          <button
            class="button is-primary"
            @click="handleStartReading(book.id)"
          >
            読み始める
          </button>
        </td>
      </tr>
    </table>

    <button
      type="button"
      class="button is-primary"
      @click="isComponentModalActive = true"
    >
      本を本棚に登録する
    </button>

    <b-modal :active.sync="isComponentModalActive" has-modal-card>
      <modal-form
        :user-id="$store.state.auth.user.id"
        @submit="registerBook"
      ></modal-form>
    </b-modal>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import _ from 'lodash'

@Component({
  components: {
    ModalForm: () => import('~/components/ModalForm.vue')
  },
  async asyncData({ app, store }) {
    const user = await app.$userRepository.find(store.state.auth.user.id)
    const bookshelf = await app.$bookshelfRepository.findPersonalBookshelfByUser(
      user
    )
    const books = await app.$bookRepository.findAllBooksByBookshelf(bookshelf)

    return {
      user,
      bookshelf,
      books
    }
  }
})
export default class extends Vue {
  private user
  private bookshelf
  private books

  private isComponentModalActive = false

  async registerBook(value: { title: string; totalPage: number }) {
    try {
      await this.$bookRepository.create(
        value.title,
        value.totalPage,
        this.bookshelf
      )

      this.isComponentModalActive = false
      this.books = await this.$bookRepository.findAllBooksByBookshelf(
        this.bookshelf
      )
    } catch (e) {
      console.error(e)
    }
  }

  async handleStartReading(bookId) {
    const book = _.find(this.books, book => book.id === bookId)
    await this.$bookRepository.startBorrow(book, this.user)
    this.books = await this.$bookRepository.findAllBooksByBookshelf(
      this.bookshelf
    )
  }
}
</script>
