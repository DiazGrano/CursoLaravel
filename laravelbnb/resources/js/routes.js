import VueRouter from "vue-router";
import Bookables from "./bookables/Bookables";
import Bookable from "./bookable/Bookable";
import Review from "./review/Review";
import Basket from "./basket/Basket";
import Login from "./auth/Login";

// Rutas que se sobreponen al enrutamiento de laravel
const routes = [
    {
        path: "/",
        component: Bookables,
        name: "home",
    },
    {
        path: "/bookable/:id",
        component: Bookable,
        name: "bookable",
    },
    {
        path: "/review/:id",
        component: Review,
        name: "review",
    },
    {
        path: "/basket",
        component: Basket,
        name: "basket"
    },
    {
        path: "/auth/login",
        component: require("./auth/Login").default,
        name: "login"
    }
];

// Se indica que la ruta forma parte del VueRouter
const router = new VueRouter({
    routes,
    // Activar el modo history. Se usa para que ya no sea necesario usar el # para simular una url completa,
    // Para así se nevegue por los url sin recargar la página
    mode: "history",
});


// Se exporta el router
export default router;