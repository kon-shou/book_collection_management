<template>
  <form action="">
    <section class="modal-card-body">
      <b-field
        v-if="isRegister"
        label="name"
        :type="{ 'is-danger': errors.has('name') }"
        :message="errors.first('name')"
      >
        <b-input
          v-model="name"
          v-validate="'required'"
          name="name"
          type="name"
          placeholder="name"
        >
        </b-input>
      </b-field>

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
    <button class="button is-primary" @click.prevent="submit">
      {{ submitWord }}
    </button>
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
    submitWord: String,
    isRegister: Boolean
  }
})
export default class extends Vue {
  name = ''
  email = ''
  password = ''

  async submit() {
    const passed = await this.$validator.validateAll()
    if (passed) {
      this.$emit('submit', {
        name: this.name,
        email: this.email,
        password: this.password
      })
    }
  }
}
</script>

<style scoped></style>
