<template>
  <section class="section">
    <div class="has-text-centered">
      <login-form
        :modal-title="`新規登録`"
        :submit-word="`登録する`"
        @submit="handleRegister"
      />
    </div>
  </section>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component({
  components: {
    LoginForm: () => import('~/components/LoginForm.vue')
  },
  auth: 'guest'
})
export default class extends Vue {
  async handleRegister(value: { email: string; password: string }) {
    await this.$axios.post('/auth/register', {
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
