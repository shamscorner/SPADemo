<template>
  <div>
    <b-progress v-if="loading" :value="100" :max="100" show-progress animated class="mb-3 mt-2"></b-progress>

    <div v-if="error">{{ error }}</div>

    <div class="text-right">
      <router-link :to="{ name: 'users.create' }">
        <b-button variant="info">Add New User</b-button>
      </router-link>
    </div>

    <table class="table table-striped" v-if="users">
      <thead>
        <tr>
          <th scope="col">Id</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="{id, name, email} in users" :key="id">
          <td>{{ id }}</td>
          <td>{{ name }}</td>
          <td>{{ email }}</td>
          <td>
            <router-link :to="{ name: 'users.edit', params: { id } }">
              <b-button size="sm" variant="primary">Edit</b-button>
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>

    <div class="inline-block">
      <b-button :disabled="! prevPage" @click.prevent="goToPrev">Previous</b-button>
      <span class="font-weight-bold text-capitalize">&nbsp;{{ paginatonCount }}&nbsp;</span>
      <b-button :disabled="! nextPage" @click.prevent="goToNext">Next</b-button>
    </div>
  </div>
</template>

<script>
import axios from "axios";

const getUsers = (page, callback) => {
  const params = { page };

  axios
    .get("/api/users", { params })
    .then(response => {
      callback(null, response.data);
    })
    .catch(error => {
      callback(error, error.response.data);
    });
};

export default {
  data() {
    return {
      loading: false,
      users: null,
      meta: null,
      links: {
        first: null,
        last: null,
        next: null,
        prev: null
      },
      error: null
    };
  },
  computed: {
    nextPage() {
      if (!this.meta || this.meta.current_page === this.meta.last_page) {
        return;
      }

      return this.meta.current_page + 1;
    },
    prevPage() {
      if (!this.meta || this.meta.current_page === 1) {
        return;
      }

      return this.meta.current_page - 1;
    },
    paginatonCount() {
      if (!this.meta) {
        return;
      }

      const { current_page, last_page } = this.meta;

      return `${current_page} of ${last_page}`;
    }
  },
  beforeRouteEnter(to, from, next) {
    getUsers(to.query.page, (err, data) => {
      next(vm => vm.setData(err, data));
    });
  },
  // when route changes and this component is already rendered,
  // the logic will be slightly different.
  beforeRouteUpdate(to, from, next) {
    this.users = this.links = this.meta = null;
    getUsers(to.query.page, (err, data) => {
      this.setData(err, data);
      next();
    });
  },
  methods: {
    goToNext() {
      this.$router.push({
        query: {
          page: this.nextPage
        }
      });
    },
    goToPrev() {
      this.$router.push({
        name: "users.index",
        query: {
          page: this.prevPage
        }
      });
    },
    setData(err, { data: users, links, meta }) {
      if (err) {
        this.error = err.toString();
      } else {
        this.users = users;
        this.links = links;
        this.meta = meta;
      }
    }
  }
};
</script>