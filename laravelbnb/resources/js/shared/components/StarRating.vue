<template>
    <div class="d-flex">
        <!-- Estas estrellas se hicieron usando font awesome, ver notas -->
        <!-- Haciendo uso de la propiedad 'v-on:="emit(método, parámetro)"', se pueden invocar métodos y pasar parámetros
        en un componente padre, aquí se está llamando a un evento en el componente Review, llamado "rating:changed", cada que 
        se hace click sobre una estrella-->
        <i class="fas fa-star" v-for="star in fullStars" :key="'full' + star" v-on:click="$emit('rating:changed', star)"></i>
        <i class="fas fa-star-half-alt" v-if="halfStar"></i>
        <i class="far fa-star" v-for="star in emptyStars" :key="'empty' + star" v-on:click="$emit('rating:changed', fullStars + star)"></i>
    </div>
</template>
 
<script>
export default {
    props: {
        rating: Number,
    },
    computed: {
        
        fullStars(){
            return Math.round(this.rating);
        },

        
        /*
        created(){
            const numbers = [];
        }*/
        halfStar(){
            /*const fraction = Math.round((this.rating - Math.floor(this.rating)) * 100);
            return fraction > 0 && fraction < 50;*/
            return (Math.ceil(this.rating) - Math.round(this.rating)) > 0;
        },

        emptyStars(){
            return 5 - Math.ceil(this.rating);
        },

    },
}
</script>