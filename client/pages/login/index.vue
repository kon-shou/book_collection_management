<template>
  <section class="section">
    <div class="columns is-mobile">
      <div class="column">
        <div class="card">
          <header class="card-header">
            <p class="card-header-title has-text-grey">
              ログイン
            </p>
          </header>

          <footer class="card-footer">
            <div class="card-footer-item has-text-centered">
              <span>
                <login-form
                  :submit-word="`ログイン`"
                  :is-register="false"
                  @submit="handleLogin"
                />
              </span>
            </div>
          </footer>
        </div>
      </div>

      <div class="column">
        <div class="card">
          <header class="card-header">
            <p class="card-header-title has-text-grey">
              新規登録
            </p>
          </header>

          <footer class="card-footer">
            <div class="card-footer-item has-text-centered">
              <span>
                <login-form
                  :submit-word="`登録する`"
                  :is-register="true"
                  @submit="handleRegister"
                />
              </span>
            </div>
          </footer>
        </div>
      </div>
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component({
  components: {
    LoginForm: () => import('~/components/LoginForm.vue')
  },
  auth: false
})
export default class extends Vue {
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
      this.$router.push('/dashboard')
    }
  }

  async handleRegister(value: {
    name: string
    email: string
    password: string
  }) {
    await this.$axios.post('/auth/register', {
      name: value.name,
      email: value.email,
      password: value.password
    })

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
      this.$router.push('/dashboard')
    }
  }
}
</script>
