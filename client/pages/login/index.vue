<template>
  <section>
    <form @submit.prevent="validateBeforeSubmit">
      <b-field
        label="Username"
        :type="{ 'is-danger': errors.has('username') }"
        :message="errors.first('username')"
      >
        <b-input
          type="text"
          v-model="username"
          name="username"
          v-validate="'required|alpha'"
        />
      </b-field>

      <b-field
        label="Password"
        :type="{ 'is-danger': errors.has('password') }"
        :message="errors.first('password')"
      >
        <b-input
          type="password"
          v-model="password"
          name="password"
          v-validate="'required|min:8'"
        />
      </b-field>
      <button type="submit" class="button is-primary">Submit</button>
    </form>
  </section>
</template>

<script>
import Vue from 'vue'
import VeeValidate from 'vee-validate'
import _ from 'lodash'

Vue.use(VeeValidate, {
  events: ''
})

export default {
  name: 'UserPage',

  data() {
    return {
      username: null,
      password: null
    }
  },
  methods: {
    validateBeforeSubmit() {
      this.$validator.validateAll().then(result => {
        if (result) {
          this.$axios
            .post('/user/login', {
              name: this.username,
              password: this.password
            })
            .then(response => {
              this.$route.push(`/${_.get(response, 'id')}`)
            })
        }
        this.$toast.open({
          message: 'Form is not valid! Please check the fields.',
          type: 'is-danger',
          position: 'is-bottom'
        })
      })
    }
  }
}
</script>
