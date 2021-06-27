<template>
    <div>
        <h6 class="text-uppercase text-secondary font-weight-bolder"> 
            Check availability 
            <transition>
                <span v-if="noAvailability" class="text-danger"> Not available</span>
                <span v-if="hasAvailability" class="text-success">Available</span>
            </transition>
            


        </h6>

        <!-- El  ':class="[{'is-invalid' : this.errorFor('from')}]"' sirve para comprobar si ocurrió un error, si sí currió un error se pone como inválido
        El error es individual, para cada campo.-->
        <div class="form-row">
            <div class="form-group col-md-6"> 
                <label for="from">From</label>
                <input 
                    type="text" 
                    name="from" 
                    class="form-control form-control-sm" 
                    placeholder="Start date" 
                    v-model="from" 
                    :class="[{'is-invalid' : this.errorFor('from')}]" />
                <v-errors :errors="this.errorFor('from')"></v-errors>
                <!-- <div class="invalid-feedback" v-for="(error, index) in this.errorFor('from')" :key="'from' + index">{{error}}</div> -->
            </div>


            <div class="form-group col-md-6"> 
                <label for="to">To</label>
                <input 
                    type="text"
                    name="to"
                    class="form-control form-control-sm"
                    placeholder="End date" 
                    v-model="to" 
                    v-on:keyup.enter="check" 
                    :class="[{'is-invalid' : this.errorFor('to')}]"
                />
                <v-errors :errors="this.errorFor('to')"></v-errors>
                <!-- <div class="invalid-feedback" v-for="(error, index) in this.errorFor('to')" :key="'to' + index">{{error}}</div>-->
            </div>
        </div>
        <!-- v-on se usa para escuchar eventos, también se puede poner como @
        Ejemplo: @click="check" 
        el :disabled es para deshabilitar el botón si la condición no se cumple-->
        <button class="btn btn-secondary btn-block" v-on:click="check" :disabled="loading">
        <span v-if="!loading"> Check! </span>
        <span v-else><i class="fas fa-circle-notch fa-spin"></i></span>
        </button>
    </div>
</template>


<script>
import {isError} from "./../shared/utils/response";
// Aquí se hace uso de los mixins, sirven para reutilizar código. Una vez definida la importación y uso del archivo mixins que contiene el código que podrá ser reutilizado,
// simplemente se llama como si el método/función estuviera definida en el mismo archivo, no es necesario nada más.
// En este caso se hace uso de la función errorFor, definida en el archivo validationError
import validationErrors from "./../shared/mixins/validationErrors";
export default {
    mixins: [validationErrors],

    props: {
        bookableId: [String, Number],
    },

    data(){
        return{
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            loading: false,
            status:null,
            errors: null
        };
    },

    methods: {
        async check() {

            /*this.$store.commit('setLastSearch',{
                from: this.from,
                to: this.to
            });*/
            this.$store.dispatch('setLastSearch',{
                from: this.from,
                to: this.to
            });


            console.log(this.$store);
            //alert('I will check something now!');
            this.loading = true;

            this.errors = null;
            // La expresión función flecha, es una alternativa compacta de declarar una función tradicional, no puede usarse como métodos, no tiene sus propios "this",
            // no tiene argumentos, no pueden ser usados como constructores

            // Promesas. 
            // Son usadas para ejecutar de forma asíncrona funciones, dando como como respuesta inmediata una promesa de que se obtendrá un resultado en un futuro.
            // Una promesa puede tener uno de tres estados, pendiente, completada o rechazada. 
            // .then() puede ser usado para ejecutar código si la promesa ha sido completada. 
            // .catch() puede ser usado para ejecutar código si la promesa ha sido rechazada.
            /*const p = new Promise((resolve, reject)=>{
                console.log(resolve);
                console.log(reject);
                setTimeout(()=> resolve("Hello"), 3000);
                //setTimeout(()=> reject("Hello"), 3000);
            })
            .then(result => "Hello again " + result)
            .then(result => console.log(result))
            .catch(result => console.log(`Error ${result}`));
            console.log(p);*/
              
            // HTTP request using axios (también se hace uso de promesas)
            // Es posible obtener el status (los códigos de status, gracias a que lo definimos en BookableAvailabilityController.php)
            
            // Aquí se usa async para realizar la petición
            try{
                this.status = ((await axios.get(`/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`)).status);
                this.$emit("availability", this.hasAvailability);
            }catch(err){
                if(isError(err, 422)){
                    this.errors = err.response.data.errors;
                }
                this.status = err.response.status;
                this.$emit("availability", this.hasAvailability);
            }
            this.loading = false;


            /*
            axios.get(`/api/bookables/${this.bookableId}/availability?from=${this.from}&to=${this.to}`).then(response=>{
                this.status = response.status;
            }).catch(error =>{
                if(isError(error, 422)){
                    this.errors = error.response.data.errors;
                }
                this.status = error.response.status;
            }).then(() => (this.loading = false));*/
            //dd(this.errors);
        },

        // Se comprueba si hay un error para el parámetro proporcionado dentro del array this.errors
        /*errorFor(field){
            
            return this.hasErrors && this.errors[field] ? this.errors[field] : null;
        }*/
    },
    computed: {
        hasErrors(){
            return this.status === 422 && this.errors !== null;
        },
        hasAvailability(){
            return this.status === 200;
        },
        noAvailability(){
            return this.status === 404;
        }
        
    }

};
</script>

<!-- El atributo scoped permite afectar solo a los elementos de forma local, no global -->
<style scoped>
    label{
        font-size: 0.7rem;
        text-transform: uppercase;
        color: gray;
        font-weight: bolder;
    }
    .is-invalid{
        border-color: #b22222;
        background-image: none;
    }

    .invalid-feedback{
        color:#b22222;

    }
</style>