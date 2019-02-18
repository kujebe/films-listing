class Auth {
    constructor() {
        this.token = window.localStorage.getItem("token");

        let userData = window.localStorage.getItem("user");
        this.user = userData ? JSON.parse(userData) : null;

        if (this.token) {
            axios.defaults.headers.common["Authorization"] =
                "Bearer " + this.token;

            //this.getUser();
        }
    }

    login(token, user) {
        window.localStorage.setItem("token", token);
        window.localStorage.setItem("user", JSON.stringify(user));

        axios.defaults.headers.common["Authorization"] = "Bearer " + token;

        this.token = token;
        this.user = user;

        Event.$emit("userLoggedIn");
    }

    logout(tokenExists = true) {
        if (tokenExists) {
            api.call("post", "/api/logout").then(({ data }) => {
                console.log(data.message);
            });
        }
        /*axios
            .post("/api/logout")
            .then(response => {
                //this.$router.push("/login");
                console.log(response);
            })
            .catch(({ response }) => {
                console(response.data.message);
            }); */
        window.localStorage.setItem("token", "");
        window.localStorage.setItem("user", "");

        axios.defaults.headers.common["Authorization"] = "";

        this.token = "";
        this.user = "";
        //Event.$emit("userLoggedOff");
    }

    check() {
        return !!this.token;
    }

    getUser() {
        /*axios
            .get("/api/get-user")
            .then(({ data }) => {
                this.user = data;
            })
            .catch(({ response }) => {
                if (response.status === 401) {
                    this.logout();
                }
            });*/
        api.call("get", "/api/get-user").then(({ data }) => {
            this.user = data;
        });
    }
}

//export default new Auth();
export default Auth;
