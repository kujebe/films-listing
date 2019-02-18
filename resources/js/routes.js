import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

import Films from "./components/Films";
import Film from "./components/Film";
import EditFilm from "./components/EditFilm";
import NewFilm from "./components/NewFilm";
import Login from "./components/auth/Login";
import Register from "./components/auth/Register";

let routes = [
    {
        path: "/",
        redirect: { name: "films" }
    },
    {
        path: "/films",
        //component: require("./components/Films").default
        component: Films,
        name: "films"
    },
    {
        path: "/film/:slug",
        component: Film,
        name: "singleFilm"
    },
    {
        path: "/film/:slug/edit",
        component: EditFilm,
        name: "editFilm"
    },
    {
        path: "/create",
        component: NewFilm,
        meta: { middlewareAuth: true }
    },
    {
        path: "/login",
        component: Login,
        meta: { middlewareGuest: true }
    },
    {
        path: "/register",
        component: Register,
        meta: { middlewareGuest: true }
    }
];

const router = new VueRouter({
    routes,
    mode: "history"
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.middlewareAuth)) {
        if (!auth.check()) {
            next({
                path: "/login",
                query: { redirect: to.fullPath }
            });

            return;
        }
    }

    if (to.matched.some(record => record.meta.middlewareGuest)) {
        if (auth.check()) {
            next({
                path: "/films"
            });
            return;
        }
    }

    next();
});

export default router;
