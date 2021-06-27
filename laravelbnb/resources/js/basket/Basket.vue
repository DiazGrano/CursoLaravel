<template>
    <div>
        <success v-if="successfulOperation"> Congratulations! Your purchase was successful! </success>
        <div class ="row" v-else>
            <!-- Columna de datos del cliente -->
            <div class="col-md-8" v-if="itemsInBasket">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="first_names">First names</label>
                        <input type="text"
                            class="form-control"
                            name="first_names"
                            v-model="customer.first_names"
                           :class="[{'is-invalid' : this.errorFor('customer.first_names')}]"
                        />
                        <v-errors :errors="this.errorFor('customer.first_names')"></v-errors>   
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="last_name">Last name</label>
                        <input type="text" 
                            class="form-control" 
                            name="last_name" 
                            v-model="customer.last_name"
                            :class="[{'is-invalid' : this.errorFor('customer.last_name')}]"
                        />    
                        <v-errors :errors="this.errorFor('customer.last_name')"></v-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="email">Email</label>
                        <input type="text" 
                            class="form-control" 
                            name="email" 
                            placeholder="example@example.com" 
                            v-model="customer.email"
                            :class="[{'is-invalid': this.errorFor('customer.email')}]"
                        />
                        <v-errors :errors="this.errorFor('customer.email')"></v-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="street">Street</label>
                        <input type="text" 
                            class="form-control" 
                            name="street" 
                            v-model="customer.street"
                            :class="[{'is-invalid': this.errorFor('customer.street')}]"
                        />
                        <v-errors :errors="this.errorFor('customer.street')"></v-errors>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="city">City</label>
                        <input type="text" 
                            class="form-control" 
                            name="city" 
                            v-model="customer.city"
                            :class="[{'is-invalid': this.errorFor('customer.city')}]"
                        />
                        <v-errors :errors="this.errorFor('customer.city')"></v-errors>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 form-group">
                        <label for="country">Country</label>
                        <input type="text" 
                            class="form-control" 
                            name="country" 
                            v-model="customer.country"
                            :class="[{'is-invalid': this.errorFor('customer.country')}]"
                        />
                        <v-errors :errors="this.errorFor('customer.country')"></v-errors>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="state">State</label>
                        <input type="text" 
                            class="form-control" 
                            name="state" 
                            v-model="customer.state"
                            :class="[{'is-invalid': this.errorFor('customer.state')}]"
                        />
                        <v-errors :errors="this.errorFor('customer.state')"></v-errors>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="zip">Zip</label>
                        <input type="text" 
                            class="form-control" 
                            name="zip" 
                            v-model="customer.zip"
                            :class="[{'is-invalid': this.errorFor('customer.zip')}]"
                        />
                        <v-errors :errors="this.errorFor('customer.zip')"></v-errors>
                    </div>
                </div>
                <hr />
                <div class="row">
                    <div class="col-md-12 form-group">
                        <!-- click.prevent se usa para prevenir que el botón de tipo submit envíe la form -->
                        <button type="submit"
                            class="btn btn-lg btn-secondary btn-block" 
                            @click.prevent="book"
                            :disabled="loading"
                        >
                            <span v-if="!loading">Book now</span>
                            <span v-else><i class="fas fa-circle-notch fa-spin"></i></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Fin de columna de datos del cliente -->

            <div class="col-md-8" v-else>
                <div class="jumbotron jumbotron-fluid text-center">
                    <h1>Your basket is empty</h1>
                </div>

            </div>

            <!-- Columna del carrito de compras -->
            <div class="col-md-4">
                <div class="d-flex justify-content-between">
                    <h6 class="text-uppercase text-secondary font-weight-bolder">Your cart</h6>
                    <h6 class="badge badge-secondary text-uppercase">
                        <span v-if="itemsInBasket">Items: {{ itemsInBasket }} </span>
                        <span v-else>Empty</span>
                    </h6>
                </div>
                <transition-group name="fade">
                    <div v-for="item in basket" :key="item.bookable.id">  
                        <div class="pt-2 pb-2 border-top d-flex justify-content-between">
                            <span>
                                <router-link :to="{name:'bookable', params:{id: item.bookable.id}}">{{item.bookable.title}}</router-link>
                            </span>
                            <span class="font-weight-bold">
                                ${{item.price.total}}
                            </span>
                        </div>

                        <div class="pt-2 pb-2 d-flex justify-content-between">
                            <span>
                                From {{item.dates.from}}
                            </span>
                            <span>
                                To {{item.dates.to}}
                            </span>
                        </div>

                        <div class="pt-2 pb-2 text-right">
                            <button class="btn btn-sm btn-outline-secondary" @click="$store.dispatch('removeFromBasket', item.bookable.id)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                </transition-group>
                
            </div>
            <!-- Fin de la columna de carrito de compras -->

        </div>
    </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import Success from '../shared/components/Success.vue';
import validationErrors from './../shared/mixins/validationErrors';

export default {
  components: { Success },
    // Se hace uso del archivo de errors, para agregar la variable erros a la data y comprobar si algún campo
    // contiene errores 
    mixins: [validationErrors],
    data(){
        return{
            loading: false,
            successfulBooking: false,
            customer:{
                first_names: null,
                last_name: null,
                email: null,
                street: null,
                city: null,
                country: null,
                state: null,
                zip: null
            }
        };
    },
    computed:{
        ...mapGetters(["itemsInBasket"]),
        ...mapState({
            basket: state => state.basket.items
        }),
        successfulOperation(){
            return !this.loading && this.successfulBooking && this.itemsInBasket === 0
        },
        checkSuccessfulBookingStatus(){
            if(this.itemsInBasket > 0){
                this.successfulBooking = false
            }
        }
    },
    methods: {
        async book(){
            this.loading = true;
            this.errors = null;
            try{
                await axios.post(`/api/checkout`, {
                    customer: this.customer,
                    bookings: this.basket.map(basketItem => ({
                        bookable_id: basketItem.bookable.id,
                        from: basketItem.dates.from,
                        to: basketItem.dates.to,
                    })) 
                });
                this.successfulBooking = true;
                this.$store.dispatch("clearBasket");
            }catch(err){
                // Check if there are errors, erros that come back from the server

                if(err.response != null){
                    // This "errors" property comes from the "validationsErrors" mixin
                    this.errors = err.response.data.errors;
                }
                
            }
            
            this.loading = false;
        }
    }
}
</script>


<style scoped>
    h6.badge{
        font-size: 100%;
    }
    a{
        color: black;
    }
</style>