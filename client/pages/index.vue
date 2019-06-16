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
          ログイン/ユーザー登録
        </button>
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
export default class extends Vue {}
</script>
