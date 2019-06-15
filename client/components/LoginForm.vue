<template>
  <form action="">
    <div class="modal-card" style="width: auto">
      <header class="modal-card-head">
        <p class="modal-card-title">{{ modalTitle }}</p>
      </header>
      <section class="modal-card-body">
        <b-field
          label="Email"
          :type="{ 'is-danger': errors.has('email') }"
          :message="errors.first('email')"
        >
          <b-input
            v-model="email"
            v-validate="'required|email'"
            name="email"
            type="email"
            placeholder="email"
          >
          </b-input>
        </b-field>

        <b-field
          label="Password"
          :type="{ 'is-danger': errors.has('password') }"
          :message="errors.first('password')"
        >
          <b-input
            v-model="password"
            v-validate="'required'"
            name="password"
            type="password"
            password-reveal
            placeholder="password"
          >
          </b-input>
        </b-field>
      </section>
      <footer class="modal-card-foot">
        <button class="button" type="button" @click.prevent="$parent.close()">
          閉じる
        </button>
        <button class="button is-primary" @click.prevent="submit">
          {{ submitWord }}
        </button>
      </footer>
    </div>
  </form>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import VeeValidate from 'vee-validate'

Vue.use(VeeValidate, {
  events: ''
})

@Component({
  props: {
    modalTitle: String,
    submitWord: String
  }
})
export default class extends Vue {
  email = ''
  password = ''

  async submit(e) {
    const passed = await this.$validator.validateAll()
    if (passed) {
      this.$emit('submit', {
        email: this.email,
        password: this.password
      })
      this.$parent.close()
    }
  }
}
</script>

<style scoped></style>
