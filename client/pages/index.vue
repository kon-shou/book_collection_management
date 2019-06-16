<template>
  <section class="section">
    <div class="has-text-centered">
      <h1 class="title">個人/オフィス蔵書管理へようこそ!!</h1>
      <div v-if="$auth.loggedIn" class="bottom">
        <button
          class="button is-medium is-primary"
          @click.prevent="$router.push('/dashboard')"
        >
          ダッシュボード
        </button>
      </div>
      <div v-else class="bottom">
        <button
          class="button is-medium is-primary"
          @click.prevent="$router.push('/login')"
        >
          ログイン
        </button>
        <button
          class="button is-medium is-info"
          @click.prevent="$router.push('/register')"
        >
          新規登録
        </button>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import _ from 'lodash'

@Component({
  components: {
    LoginForm: () => import('~/components/LoginForm.vue')
  },
  auth: false
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
    await this.$auth
      .loginWith('local', {
        data: {
          email: value.email,
          password: value.password
        }
      })
      .catch(() => {
        this.$toast.open({
          message: 'Form is not valid! Please check the fields.',
          type: 'is-danger',
          position: 'is-bottom'
        })
      })

    if (this.$auth.loggedIn) {
      this.$router.push(`/user/${_.get(this.$auth.$state, 'user.id')}`)
    }
  }

  async handleRegister(value: { email: string; password: string }) {
    const response = await this.$axios.post('/user/register', {
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
