<template>
    <div class="card w-100">
        <div class="card-body">
            <!-- para crear una ruta se usa router-link, :to= se usa para definir hacia dónde se dirigirá (esto es definido en routes.js), como 
                esta ruta espera una id, este parámetro se pasa usando una coma, luego el nombre de la propiedad y luego la variable que contiene la id -->
            <!-- De la siguiente manera, pasando la id de la siguiente manera params:{id:id}, los componentes hijo podrán acceder a estos datos de forma fácil, de la 
            siguiente manera this.$route.params.id
            El primer id representa el nombre del parámetro, los componentes hijos podrán acceder a los datos almacenados en esta variable usando ese nombre,
            el segundo id es la variable local id, la cual almacena la id del bookable-->
            <router-link :to="{name: 'bookable', params:{id: id}}">
            
                <!--<router-link :to="{name: 'bookable', params:{id: id}}"> -->
                <h5 class="card-title"> {{title}}</h5>
            </router-link>
            <p class="card-title">{{description}}</p>
            <!--<p class="card-title">{{itemPrice}}</p>-->
            
            
        </div>

        
    </div>
</template>



<!-- Definir propiedades que pueden ser usadas en el componente, estas se reciben de otros componentes -->
<script>
/*
export default {
    props: ['title', 'itemDescription', "price"]
};*/
// Definir propiedades con tipo en específico
export default {
    props: {title: String, description: String, id: Number},

    /*
    mounted() {
        console.log(this.title);

        setTimeout(()=>{
            this.title = "New title";
        }, 1500);
    },*/
};



</script>