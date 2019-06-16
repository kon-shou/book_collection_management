<template>
  <section>
    <b-tabs>
      <b-tab-item label="Table">
        <b-table
          :data="books"
          :columns="columns"
          :checked-rows.sync="checkedRows"
          :is-row-checkable="row => row.id !== 3"
          checkable
        >
          <template slot="bottom-left">
            <b>Total checked</b>: {{ checkedRows.length }}
          </template>
        </b-table>
      </b-tab-item>

      <b-tab-item label="Checked rows">
        <pre>{{ checkedRows }}</pre>
      </b-tab-item>
    </b-tabs>
    <button
      type="button"
      class="button is-primary"
      @click="isComponentModalActive = true"
    >
      本を本棚に登録する
    </button>

    <b-modal :active.sync="isComponentModalActive" has-modal-card>
      <modal-form v-bind="{ userId }" @submit="registerBook"></modal-form>
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
  async asyncData({ params, $axios, store }) {
    const userId = params.id
    const booksResponse = await $axios.get(`/user/${store.state.auth.user.id}`)
    const books = _.get(booksResponse.data, 'books')

    return {
      userId,
      books,
      columns: [
        {
          field: 'id',
          label: 'ID',
          width: '40',
          numeric: true
        },
        {
          field: 'title',
          label: 'タイトル'
        },
        {
          field: 'registered_at',
          label: '登録日'
        },
        {
          field: 'status',
          label: 'ステータス'
        },
        {
          field: 'owner_user_name',
          label: '本の所有者'
        },
        {
          field: 'borrow_user_name',
          label: '本を借りてる人'
        }
      ]
    }
  }
})
export default class extends Vue {
  isComponentModalActive = false
  checkedRows = []
  books

  async registerBook(value: { title: string }) {
    const response = await this.$axios.post('/book/register', {
      user_id: this.$store.state.auth.user.id,
      title: value.title
    })

    if (response.status === 201) {
      this.isComponentModalActive = false
      const booksResponse = await this.$axios.get(
        `/user/${this.$store.state.auth.user.id}`
      )
      this.books = _.get(booksResponse.data, 'books')
    }
  }
}
</script>
