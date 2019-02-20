<template>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-4 offset-md-4">
          <form @submit.prevent="register">
            <div class="form-group">
              <label for="Name">Name</label>
              <input
                type="text"
                class="form-control"
                placeholder="Your Name"
                v-model="name"
                required
              >
            </div>
            <div class="form-group">
              <label for="Email">Email</label>
              <input type="email" class="form-control" placeholder="Email" v-model="email" required>
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
            <div class="form-group">
              <label for="Confirm Password">Confirm Password</label>
              <input
                type="password"
                class="form-control"
                placeholder="Confirm Password"
                v-model="password_confirmation"
                required
              >
            </div>
            <button class="btn btn-danger float-right">Register</button>
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
      name: "",
      email: "",
      password: "",
      password_confirmation: ""
    };
  },

  methods: {
    register() {
      let data = {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      };

      axios
        .post(process.env.MIX_APP_URL + "api/register", data)
        .then(({ data }) => {
          console.log(data);
          //auth.login(data.token, data.user);
          Event.$emit("userRegistered");
          this.$emit("userRegistered");
          this.$router.push("/login");
          console.log(Event);
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
    this.$emit("register-success");
    console.log(Event);
  }
};
</script>