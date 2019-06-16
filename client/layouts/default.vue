<template>
  <div>
    <nav
      class="navbar header has-shadow is-primary"
      role="navigation"
      aria-label="main navigation"
    >
      <div class="navbar-brand">
        <a class="navbar-item" href="/">
          <h1>個人/オフィス蔵書管理</h1>
        </a>
      </div>

      <div v-if="$auth.loggedIn" class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <button class="button" @click="$router.push('/dashboard')">
              ダッシュボード
            </button>
            <button class="button is-danger" @click="handleLogout">
              ログアウト
            </button>
          </div>
        </div>
      </div>
    </nav>

    <section class="main-content columns">
      <div class="container column is-10">
        <nuxt />
      </div>
    </section>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'

@Component({})
export default class extends Vue {
  items = [
    {
      title: 'Home',
      icon: 'home',
      to: { name: 'index' }
    },
    {
      title: 'Inspire',
      icon: 'lightbulb',
      to: { name: 'inspire' }
    }
  ]

  async handleLogout() {
    await this.$auth.logout().catch(() => {
      this.$toast.open({
        message: 'Form is not valid! Please check the fields.',
        type: 'is-danger',
        position: 'is-bottom'
      })
    })

    this.$router.push('/')
  }
}
</script>
