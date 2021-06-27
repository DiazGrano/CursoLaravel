<template>

    <div v-if="!loading">
        <div class="row">
            <div class="col-md-8 pb-4">
                <div class="card">
                    <div class="card-body">
                        <h2>{{ bookable.title }}</h2>
                        <hr />
                        <article> {{bookable.description}} </article>
                    </div>
                </div>
                <review-list v-bind:bookable-id="this.$route.params.id"></review-list>
            </div>
            <div class="col-md-4 pb-4">
                
                <availability v-bind:bookable-id="this.$route.params.id" v-on:availability="checkPrice($event)" class="mb-4"></availability>

                <transition name="fade">
                    <price-breakdown v-if="price" :price="price" class="mb-4"></price-breakdown>
                </transition>

                <transition name="fade">
                    <button class="btn btn-outline-secondary btn-block" v-if="price" @click="addToBasket" :disabled="inBasketAlready">Book now!</button>
                </transition>
                <transition name="fade">
                    <button class="btn btn-outline-danger btn-block" v-if="inBasketAlready" @click="removeFromBasket">Remove item from basket</button>
                </transition>

                <div v-if="inBasketAlready" class="mt-4 text-muted warning">
                    Seems like you have added this object to basket already
                </div>
                

            </div>      
        </div>
        
    </div>
    <div v-else>
        <h2> Loading items... </h2>
    </div>
</template>

<script>
import Availability from  "./Availability";
import ReviewList from "./ReviewList";
import PriceBreakdown from "./PriceBreakdown";
import {mapState} from "vuex";


export default {

    components: {
        Availability,
        ReviewList,
        PriceBreakdown
    },


    data(){
        return{
            bookable: null,
            loading: true,
            price: null,
        }
    },
    created(){
        this.loading = true;
        axios.get(`/api/bookables/${this.$route.params.id}`).then(response => {
            this.bookable = response.data.data;
            this.loading = false;
        });
    },


    computed: {
        ...mapState({
            lastSearch: "lastSearch",
            /*
            // Fue movido a la store.js, para poder ser utilizado por cualquier componente
            inBasketAlready(state){
            if(this.bookable === null){
                return false;
            }
            // Se itera entre cada elemento del carrito de compras, retornando inicialmente el resultado por defecto (que es false), item representa el elemento actual
            // y en result se van acumulando los resultados. 
            // O sea que, en cada iteración, se compara la id del item actual que está dentro del carrito de compras y la id del elemento actual que se está intentando agregar
            // al carrito de compras.
            // Como la condición es ||, basta con que uno solo sea true, o sea, que ya exista dentro del carrito de compras, para regresar un true.
            return state.basket.items.reduce((result, item) => result || item.bookable.id === this.bookable.id, false);
            },*/
            
            inBasketAlready(){
                if(this.bookable === null){
                    return false;
                }

                return this.$store.getters.inBasketAlready(this.bookable.id);
            }
        })
    },   

    methods:{
        async checkPrice(hasAvailability){
            if(!hasAvailability){
                this.price = null;
                return;
            }

            try{
                this.price = (await axios.get(`/api/bookables/${this.bookable.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data;
            }catch(err){
                this.price = null;
            }
        },

        addToBasket(){
            // Commit es para mutations y dispatch para actions
            this.$store.dispatch("addToBasket",{
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            });
            /*
            this.$store.commit("addToBasket",{
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            });*/
        },
        removeFromBasket(){
            this.$store.dispatch("removeFromBasket", this.bookable.id);
            /*this.$store.commit("removeFromBasket", this.bookable.id);*/
        }
    }
}
</script>

<style scoped>
    .warning{
        font-size: 0.7rem;
    }
</style>