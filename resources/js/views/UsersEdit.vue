<template>
  <div class="mt-3">
    <b-alert v-if="message" :variant="alertVariant" show>{{ message }}</b-alert>
    <b-progress v-if="! loaded" :value="100" :max="100" show-progress animated class="mb-3"></b-progress>
    <b-form v-else @submit.prevent="onSubmit($event)">
      <b-form-group label="Full Name:" label-for="input-name">
        <b-form-input id="input-name" v-model="user.name" type="text" required></b-form-input>
      </b-form-group>

      <b-form-group label="Email address:" label-for="input-email">
        <b-form-input id="input-email" v-model="user.email" type="email" required></b-form-input>
      </b-form-group>

      <b-form-group>
        <b-button variant="warning" :disabled="saving" @click.prevent="goHome()">Cancel</b-button>
        <b-button type="submit" variant="success" :disabled="saving">Update</b-button>
        <b-button variant="danger" :disabled="saving" @click.prevent="onDelete($event)">Delete</b-button>
      </b-form-group>
    </b-form>
  </div>
</template>

<script>
import api from "../api/users";

export default {
  data() {
    return {
      message: null,
      saving: false,
      loaded: false,
      user: {
        id: null,
        name: "",
        email: ""
      },
      alertVariant: "info"
    };
  },
  methods: {
    onSubmit(event) {
      this.saving = true;
      this.loaded = true;

      api
        .update(this.user.id, {
          name: this.user.name,
          email: this.user.email
        })
        .then(response => {
          this.loaded = false;
          this.message = "User updated";
          this.alertVariant = "success";
          setTimeout(() => {
            this.message = null;
            this.goHome();
          }, 2000);
        })
        .catch(error => {
          this.message = error.response.data.message || error.toString();
          this.alertVariant = "danger";
          setTimeout(() => {
            this.message = null;
          }, 2000);
        })
        .then(_ => {
          this.saving = false;
        });
    },
    onDelete(event) {
      this.saving = true;
      this.loaded = true;

      api.delete(this.user.id).then(response => {
        this.loaded = false;
        this.message = "User Deleted";
        this.alertVariant = "success";
        setTimeout(() => {
          // redirect back to the users page
          this.goHome();
        }, 1000);
      });
    },
    goHome() {
      this.$router.push({ name: "users.index" });
    }
  },
  created() {
    api
      .find(this.$route.params.id)
      .then(response => {
        setTimeout(() => {
          this.loaded = true;
          this.user = response.data.data;
        }, 1000);
      })
      .catch(err => {
        this.$router.push({ name: "404" });
      });
  }
};
</script>