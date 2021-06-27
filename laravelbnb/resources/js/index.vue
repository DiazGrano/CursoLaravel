<template>
    <div>
        <nav class="navbar bg-white border-bottom navbar-light">
        
            <!-- router-link se usa para crear links que llevan a rutas soportadas por router vue, con estas 
                rutas no es necesario que se recargue la página -->
            <router-link class="navbar-brand mr-auto" :to="{name: 'home'}">LaravelBnb</router-link>

            <router-link class="btn nav-button" :to="{name: 'basket'}">
                Basket
                <span v-if="itemsInBasket" class="badge badge-secondary">{{itemsInBasket}}</span>
            </router-link>
            
            <!-- v-bind:  se usa para indicar que el parámetro debe ser tratado especialmente, ya sea como una función, un parámetro,
                un método, javascript. 
                En este caso, se usa v-bind:to   para poder acceder a una ruta mediante su nombre. Esto se puede acortar usando
                simplemente los dos puntos ":", ejemplo :to="{name: 'home2'}"
            <router-link class="btn nav-button" v-bind:to="{name: 'home2'}">Second</router-link>-->

        </nav>

        <div class="container mt-4 mb-4 pr-4 pl-4">
        
            <!-- router-view se usa para indicar en dónde debe ser renderizado el componente especificado de la ruta -->
            <router-view></router-view>

        </div>

        
    </div>
</template>

<script>

// mapState sirve para poder actualizar automáticamente los datos almacenados en la store de vuex. Dado que estos no son actualizados automáticamente 
// entre componentes.

import { mapState, mapGetters } from 'vuex';

export default {
    data() {
        return {
            lastSearch: this.$store.state.lastSearch
        };
    },

    // Así se define
    /*
    computed: mapState({
        //lastSearchComputed: state => state.lastSearch
        lastSearchComputed: "lastSearch"
    })*/

    // Si se desea también hacer uso de otras variables computadas, es necesario definir el mapa de la siguiente manera
    computed: {
        ... mapState({
        lastSearchComputed: "lastSearch"
    }),
        ... mapGetters({
        itemsInBasket: "itemsInBasket"
    }),

    otroComputado(){
        return 3+2;
    }
    }
};
</script>