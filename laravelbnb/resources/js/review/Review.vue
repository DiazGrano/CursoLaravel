<template>
    <div>
        <div v-if="loading">
            <h2>Loading review...</h2>
        </div>
        <div v-else>
            <div class="row" v-if="error"> 
                <div  class="col-md-12">
                    <fatal-error></fatal-error>
                </div>
            </div>
            <div class="" v-if="success && !error">
                <div class="col-md-12">
                    <successfull-review> Your review has been submited successfully</successfull-review>
                </div>
            </div>
            <div class="row" v-else>
                <div :class="[{'col-md-4': !loading && !existingReview}, {'d-none': loading || existingReview}]">
                    <div v-if="!alreadyReviewd">
                        <div class="card">
                            <div class="card-body">
                                <p>
                                    Stayed at
                                    <router-link :to="{name: 'bookable', params: {id: booking.bookable.id}}">{{booking.bookable.title}}</router-link>
                                </p>
                                <p>From: {{booking.from}}, to: {{booking.to}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div :class="[{'col-md-8': !loading && !existingReview}, {'col-md-12': !loading && existingReview}]">   
                    <div v-if="alreadyReviewd"> 
                        <h3>You have already left a review</h3> 
                    </div>
                    <div v-else> <h3>You have not left a review yet</h3> 
                        <div class="form-group">
                            <label for="" class="text-muted">Select the star rating (1 - 5)</label>
                            <!-- Se le pasa un rating de 5 al componente "StarRating", se le da el formato "fa-3x"
                            v-on:rating:changed es llamado desde el componente hijo "StarRating", cuando alguna estrella es presionada, 
                            el nombre de este método es definido en el componente hijo, "v-on:" solo se encarga de escuchar cuando
                            este método es llamado. Una vez llamado, este invoca el método "OnRatingChanged", definido en este componente-->
                            <!--
                            <star-rating :rating="5" class="fa-3x" v-on:rating:changed="onRatingChanged"></star-rating>
                            -->
                            <!-- Otra forma de invocar métodos es la siguiente-->
                            <star-rating :rating="review.rating" class="fa-3x" v-on:rating:changed="review.rating = $event"></star-rating>
                        </div>

                        <div class="form-group">
                            <label for="content" class="text-muted">Describe your experience with </label>
                            <!-- v-model sirve para vincular dos elementos de ida y venida, si uno es modificado, el otro también lo será, y viceversa
                                En este caso, cuando el contenido del textarea es modificado, o sea, que se escribe algo en él, también se modifica el valor almacenado en
                                la variable "content", debido a que estas están vinculadas por el v-model="review.content".
                                v-model también permite la invocación de métodos de hijo a padre-->
                            <textarea name="content" id="" cols="30" rows="10" class="form-control" v-model="review.content" :class="[{'is-invalid': errorFor('content')}]"></textarea>


                            <v-errors :errors="this.errorFor('content')"></v-errors>
                            <!-- <div class="invalid-feedback" v-for="(error, index) in errorFor('content')" :key="'content' + index">{{ error }}</div> -->
                        </div>
                        <button class="btn-lg btn-primary btn-block" @click.prevent="submit" :disabled="sending">Submit</button>
                    </div>

                </div>

            </div>
            
            
        </div>
        
    </div>
    
</template>

<script>
import {is404} from "./../shared/utils/response";
import {isError} from "./../shared/utils/response";

// Aquí se hace uso de los mixins, sirven para reutilizar código. Una vez definida la importación y uso del archivo mixins que contiene el código que podrá ser reutilizado,
// simplemente se llama como si el método/función estuviera definida en el mismo archivo, no es necesario nada más.
// En este caso se hace uso de la función errorFor, definida en el archivo validationError
import validationErrors from "./../shared/mixins/validationErrors";
//import Success from '../shared/components/Success.vue';
export default {

    mixins: [validationErrors],

    data(){
        return{
            review:{
                id: null,
                rating: 5,
                content: null,
            },
            existingReview: null,
            loading: false,
            booking: null,
            error: false,
            success: false,
            /*errors: null,*/
            sending: false,
        };
    },
    /*
    methods: {
        onRatingChanged(rating){
            console.log(rating);
        }
    }*/
    async created() {
        this.review.id = this.$route.params.id;
        this.loading = true;
        // this.$route.params.id sale del componente BookableListItem.vue
        // En el parámetro 'response.data' se almacena la información de forma cruda, con todos los parámetros que se tengan como respuesta, al usar el segundo data,
        // se accede al parámetro 'data', que se encuentra dentro de 'response.data'
        

        try{
            this.existingReview = (await axios.get(`/api/reviews/${this.review.id}`)).data.data;
        }catch(err){
            if (isError(err, 404)){
                try{
                this.booking = (await axios.get(`/api/booking-by-review/${this.review.id}`)).data.data;
                }catch(err){
                    this.error = !isError(err, 404);
                }
            }else{
                this.error = true;
            }
        }
        this.loading = false;
        
        /* // Se manda una solicitud HTTP a la ruta, para obtener la página de la review dada.
        axios.get(`/api/reviews/${this.review.id}`)
        // Entonces, si la solicitud fue exitosa, se almacena en la variable existingReview, los datos de la review obtenida.
            .then(response => {this.existingReview = response.data.data})
            // Si la solicitud no fue exitosa
            .catch(err => {
                    
                // Si se obtuvo una respuesta en el error, si el estado de la respuesta del error es diferente de 0, y si el error es el 404
                // Esta función se importa de resources/shared/utils/response
                if( isError(err, 404)){
                    
                    // En esta parte, como anteriormente se introdujo una id inválida, ahora se intenta consultar la review dando la review_key almacenada en la tabla de bookings
                    return axios.get(`/api/booking-by-review/${this.review.id}`)
                    .then(response => {
                        this.booking = response.data.data;
                    }).catch((err) => {
                        if( !isError(err, 404)){
                            this.error = true;
                        }
                    });
                }
            })
            .then(() => {
                this.loading = false}); */
    },
    computed:{
        alreadyReviewd(){
            return this.hasReview || !this.booking;
        },
        hasReview(){
            return this.existingReview !== null;
        },
        hasBooking(){
            return this.booking !== null;
        },
    },
    methods:{
        //Store review
        submit(){

            this.errors = null;
            this.sending = true;
            this.success = false;
            axios.post(`/api/reviews/`, this.review)
                .then(response => {
                    if(response.status === 201){
                        this.success = true;
                    }
                })
                .catch(err => {
                    if(isError(err, 422)){
                        const errors = err.response.data.errors;
                        // Lodash es una librería con varias funcionalidades útiles, esta es importada por defecto en el archivo bootstrap.js, por defecto está 
                        // disponible globalmente haciendo uso del símbolo "_"
                        // Aquí se revisa, si el error que se obtiene es el 422, que este tenga una propiedad de content, indicando que el error estuvo en el contenido,
                        // y si, y solo si, la cantidad de propiedades que contiene el error (o sea, que solo hubo error en una de las propiedades), es igual a 1
                        if(errors["content"] && _.size(errors) === 1){
                            this.errors = errors;
                            return;
                        }
                    }
                    this.error = true; 
                    }
                )
                .then(() => (this.sending = false));
        },
        
    /*
        errorFor(field){
            
            return null !== this.errors && this.errors && this.errors[field] ? this.errors[field] : null;
        },*/


    }

}
</script>