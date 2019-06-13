<template>
  <section>
    <button
      class="button field is-danger"
      @click="checkedRows = []"
      :disabled="!checkedRows.length"
    >
      <b-icon icon="close"></b-icon>
      <span>Clear checked</span>
    </button>

    <b-tabs>
      <b-tab-item label="Table">
        <b-table
          :data="data"
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
      <modal-form v-bind="{ userId }"></modal-form>
    </b-modal>
  </section>
</template>

<script>
import _ from 'lodash'
import axios from 'axios'
import ModalForm from '~/components/ModalForm'

export default {
  name: 'UserDetailPage',
  components: {
    ModalForm
  },
  async asyncData({ params }) {
    const userId = params.id
    const booksResponse = await axios.get(`/api/user/${userId}`)
    const books = _.get(booksResponse.data, 'books')

    return {
      userId,
      data: books,
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
  },
  data() {
    return {
      isComponentModalActive: false,
      checkedRows: []
    }
  }
}
</script>
