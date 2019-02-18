<template>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-4 offset-md-4">
          <div class="alert alert-success" v-if="register_success">Film updated successfully</div>
          <form @submit.prevent="login">
            <div class="form-group">
              <label for="Username">Username</label>
              <input
                type="email"
                class="form-control"
                placeholder="Username"
                v-model="email"
                required
              >
            </div>
            <div class="form-group">
              <label for="Password">Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Password"
                v-model="password"
                required
              >
            </div>
            <button class="btn btn-danger float-right">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      register_success: false
    };
  },

  methods: {
    login() {
      let data = {
        email: this.email,
        password: this.password
      };

      axios
        .post("/api/login", data)
        .then(({ data }) => {
          console.log(data);
          auth.login(data.token, data.user);
          this.$router.push("/");
        })
        .catch(({ err }) => {
          /*if (response.status === 401) {
            this.logout();
          }*/

          console.log(err);
        });
    }
  },
  created() {
    //alert(Event.$on("userRegistered"));
    Event.$on("userRegistered", () => {
      this.register_success = true;
      //console.log("Hello there");
    });
  }
};
</script>