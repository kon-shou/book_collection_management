<template>
  <section class="section">
    <div class="has-text-centered">
      <h1 class="title">個人/オフィス蔵書管理へようこそ!!</h1>
      <div class="bottom"></div>

      <button
        class="button is-medium is-primary"
        @click.prevent="openLoginModal"
      >
        ログイン
      </button>

      <button
        class="button is-medium is-info"
        @click.prevent="openRegisterModal"
      >
        新規登録
      </button>

      <b-modal :active.sync="isLoginModalActive" has-modal-card>
        <login-form
          :modal-title="`ログイン`"
          :submit-word="`ログイン`"
          @submit="handleLogin"
        />
      </b-modal>

      <b-modal :active.sync="isRegisterModalActive" has-modal-card>
        <login-form
          :modal-title="`新規登録`"
          :submit-word="`登録`"
          @submit="handleRegister"
        />
      </b-modal>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import _ from 'lodash'

@Component({
  components: {
    LoginForm: () => import('~/components/LoginForm.vue')
  }
})
export default class extends Vue {
  isLoginModalActive = false
  isRegisterModalActive = false

  openLoginModal() {
    this.isLoginModalActive = true
  }

  openRegisterModal() {
    this.isRegisterModalActive = true
  }

  async handleLogin(value: { email: string; password: string }) {
    console.log(value)
    const response = await this.$axios.post('/api/user/login', {
      email: value.email,
      password: value.password
    })

    if (response.status === 200) {
      this.$route.push(`/${_.get(response, 'id')}`)
    }
  }

  async handleRegister(value: { email: string; password: string }) {
    console.log(value)
    const response = await this.$axios.post('/api/user/register', {
      email: value.email,
      password: value.password
    })

    if (response.status === 200) {
      this.$toast.open({
        message: '新規登録に成功しました。ログインしてください。',
        type: 'is-primary',
        position: 'is-bottom'
      })
    }
  }
}
</script>
