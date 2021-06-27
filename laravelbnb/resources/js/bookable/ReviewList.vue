<template>
    <div style="padding: 1.25rem"> 
       <!-- <star-rating :rating="0.9"></star-rating>
        <star-rating :rating="0.5"></star-rating>
        <star-rating :rating="0.3"></star-rating>
        <star-rating :rating="3.9"></star-rating>
        <star-rating :rating="3.2"></star-rating>
        <star-rating :rating="4.9"></star-rating>
        <star-rating :rating="4.3"></star-rating>
        <star-rating :rating="4.0"></star-rating>
        <star-rating :rating="3.0"></star-rating>
        <star-rating :rating="0.0"></star-rating> 
        -->




        <div v-if="loading">
            <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">Loading Reviews...</h6>
        </div>
        <div v-else>
            <h6 class="text-uppercase text-secondary font-weight-bolder pt-4">Review List</h6>
            <div class="border-bottom d-none d-md-block" v-for="(review, index) in this.reviews" :key="index">
                <div class="row pt-4">
                    <div class="col-md-6">Reviewer name</div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <star-rating :rating="review.rating" class="fa-la"></star-rating>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-md-12">{{review.content}}</div>
                </div>

                <div class="row pt-4 pb-4">
                    <!-- | filter -->
                    <!-- Así es como se usan los filtros, para poder así modificar un valor -->
                    <div class="col-md-12">{{ review.created_at | fromNow}}</div>
                </div>
            </div>
        </div>
        
    
    
    </div>
</template>

<<script>

// Si la librería se encuenta en la carpeta node_modules, no es necesario definir la ruta de esta
// Esta librería sirve para dar formato a las fechas
//import moment from "moment";


export default {
    props: {
        bookableId: [String, Number],
    },
    data(){
        return{
            loading: false,
            reviews: null,
        }
    },
    created() {
        this.loading = true;
        axios.get(`/api/bookables/${this.bookableId}/reviews`).then(response => (this.reviews = response.data.data)).then(() => (this.loading = false));
    },

    // Filtros
    // Los filtros se usan para modificar un valor
    // Este filtro de solo de uso local (en este componente).
    // Para poder registrarlo globalmente, es necesario modificar el archivo app.js
    filters:{
        postDate(value){
            // Aquí se hace uso de la librería Moment.js, la cual sirve para dar formato a las fechas
            //return moment(value).fromNow();
        }
    }
}
</script>