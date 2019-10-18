<template>
  <div class="container">
    <b-jumbotron
      header="SPA Demo"
      lead="A Single Page Application Demo Using Laravel, Vue, Bootstrap-Vue, Vue-Router & Axios"
      class="col-md-8 offset-md-2 mt-4"
    >
      <hr />
      <b-nav pills>
        <b-nav-item>
		  <router-link
            :to="{ name: 'users.index' }"
            :class="{active: isActive('users.index')}"
          >Users</router-link>
        </b-nav-item>
        <b-nav-item>
          <router-link :to="{ name: 'home' }" :class="{active: isActive('home')}">Home</router-link>
        </b-nav-item>
        <b-nav-item>
          <router-link :to="{ name: 'hello' }" :class="{active: isActive('hello')}">Hello World</router-link>
        </b-nav-item>
      </b-nav>
      <div class="container">
        <router-view></router-view>
      </div>
    </b-jumbotron>
  </div>
</template>
<script>
export default {
  methods: {
    isActive(link) {
      return link == this.$router.currentRoute.name;
    }
  }
};
</script>

<style lang="scss" scoped>
a {
  text-decoration: none;
}
.active {
  color: rgb(163, 16, 16);
  padding: 8px 10px;
  border-bottom: 2px solid rgb(163, 16, 16);
}
</style>