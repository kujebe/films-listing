<template>
  <div>
    <header>
      <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
          <router-link to="/" exact tag="a" class="navbar-brand d-flex align-items-center">
            <strong>Films</strong>
          </router-link>
          <ul class="nav justify-content-end">
            <li class="nav-item">
              <router-link class="nav-link" activeClass="active" tag="a" to="/" exact>Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" activeClass="active" tag="a" to="/films" exact>Films</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" activeClass="active" tag="a" to="/create">New Film</router-link>
            </li>
            <li class="nav-item" v-if="authenticated">
              <a href="#" @click.prevent="logout" class="nav-link">Logout</a>
            </li>
            <li class="nav-item" v-if="!authenticated">
              <router-link class="nav-link" activeClass="active" tag="a" to="/login">Login</router-link>
            </li>
            <li class="nav-item" v-if="!authenticated">
              <router-link class="nav-link" activeClass="active" tag="a" to="/register">Register</router-link>
            </li>
            <li class="nav-item" v-if="user">
              <span class="loggedin-user">Hello, {{user.name}}</span>
            </li>
          </ul>
        </div>
      </div>
    </header>
    <router-view></router-view>
    <app-footer/>
  </div>
</template>

<script>
import Footer from "./Footer";

export default {
  data() {
    return {
      authenticated: auth.check(),
      user: auth.user
    };
  },
  methods: {
    logout() {
      auth.logout();
      this.$router.push("/login");
    }
  },
  mounted() {
    Event.$on("userLoggedIn", () => {
      this.authenticated = true;
      this.user = auth.user;
    });

    Event.$on("userLoggedOff", () => {
      this.authenticated = false;
      this.user = "";
    });
  },
  components: {
    "app-footer": Footer
  }
};
</script>