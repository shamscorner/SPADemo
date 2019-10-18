<template>
  <div class="mt-3">
    <b-alert v-if="message" variant="danger" show>{{ message }}</b-alert>

    <b-form v-else @submit.prevent="onSubmit($event)" @reset="onReset">
      <b-form-group
        label="Your Full Name:"
        label-for="input-name"
        description="We'll display this name in your profile."
      >
        <b-form-input
          id="input-name"
          v-model="user.name"
          type="text"
          required
          placeholder="Enter name"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        label="Email address:"
        label-for="input-email"
        description="We'll never share your email with anyone else."
      >
        <b-form-input
          id="input-email"
          v-model="user.email"
          type="email"
          required
          placeholder="Enter email"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        label="Enter a Password:"
        label-for="input-password"
        description="Provide a strong password mixing with letters, numbers and symbols."
      >
        <b-form-input
          id="input-password"
          v-model="user.password"
          type="password"
          required
          placeholder="Enter password"
        ></b-form-input>
      </b-form-group>

      <b-button
        type="submit"
        variant="primary"
        :disabled="saving"
      >{{ saving ? 'Creating...' : 'Create' }}</b-button>
      <b-button type="reset" variant="danger">Reset</b-button>
    </b-form>
  </div>
</template>
<script>
import api from "../api/users";

export default {
  data() {
    return {
      saving: false,
      message: false,
      user: {
        name: "",
        email: "",
        password: ""
      }
    };
  },
  methods: {
    onSubmit($event) {
      this.saving = true;
      this.message = false;

      api
        .create(this.user)
        .then(response => {
          this.$router.push({
            name: "users.edit",
            params: {
              id: response.data.data.id
            }
          });
        })
        .catch(e => {
          this.message =
            e.response.data.message || "There was an issue creating the user.";
        })
        .then(() => {
          this.saving = false;
        });
    },
    onReset() {
      this.user.name = "";
      this.user.email = "";
      this.user.password = "";
    }
  }
};
</script>