require('./bootstrap');


import VueRouter from "vue-router";

// Se importa el router desde el archivo routes
import router from "./routes";


import index from "./index";
import moment from "moment";



import StarRating from "./shared/components/StarRating";
import FatalError from "./shared/components/FatalError";
import Success from "./shared/components/Success";
import ValidationErrors from "./shared/components/ValidationErrors";

import storeDefinition from "./store";

import Vue from "vue";

import Vuex from "vuex";
import axios from "axios";



window.Vue = require('vue');
Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(storeDefinition);
// Registrar componente globalmente
/*Vue.component("example-component",
 require("./components/ExampleComponent.vue").default
 );*/
/*
 Vue.component("example-2",
 require("./components/Example2.vue").default
 );*/

 /*
 const store = new Vuex.Store({
    state: {
        count: 0,
        name: "Joseluis"
    },
    mutations:{
        increment(state){
            state.count++;
            console.log(state);
        },
        changeName(state, payload){
            console.log(state);
            state.name = payload;
            console.log(state);
        }
    }
});
store.commit('increment');
store.commit('increment');
store.commit('changeName', 'Luismiguel');*/




// Así se registra globalmente un filtro
// Vue.filter("nombreFiltro", value => función);
Vue.filter("fromNow", value => moment(value).fromNow());

Vue.component("star-rating", StarRating);
Vue.component("fatal-error", FatalError);
Vue.component("successfull-review", Success);
Vue.component("v-errors", ValidationErrors);

const app = new Vue({
    el: '#app',
    
    store,

    // Se indica que se debe hacer uso del router
    router,

    // Registrar componentes localmente
    components: {
        "index": index,
    
    },

    // Carga los datos guardados localmente, para poder ser usados en cada componente.
    // Este método se encuentra declarado en store.js
    async beforeCreate(){
        this.$store.dispatch("loadStoredState");

        /*
        // Para poder hacer uso de sanctum, primero se tiene que obtener una csrf cookie
        await axios.get('/sanctum/csrf-cookie'); 

        // Se manda una petición asíncrona, para poder logearse
        await axios.post("/login", {
            email:'dschmitt@example.net',
            password: 'password'
        });

        await axios.get('/user');*/
    }
});
