<template>
    <div>
  
        <div v-if="loading"> <h1>Loading items</h1></div>
          
        <div v-else>
            <div class="row mb-4" v-for ="row in rows" :key="'row ' + row">
                 <div class="col d-flex align-items-stretch"  v-for="(bookable, column) in bookablesInRow(row)" :key = "'row' + row + column">
                 
                    <!-- v-bind: (o simplemente :) sirve para preservar el tipo de la propiedad al momento de pasarla a otro componente -->
                    <!-- v-if (y v-else) se usan para hacer comprobaciones, estas se actualizan en tiempo real, al renderizar los componentes -->
                    <!-- Para poder hacer uso del v-for, es necesario que el elemento tenga una key, esto puede ser una id, pero se puede
                    saltar esta restricción haciendo lo siguiente -->
                    <!--<bookable-list-item  v-for="(bookable, index) in bookables" :key="index" :item-title="bookable.itemTitle" :item-description="bookable.itemDescription" :itemPrice="1000" >   </bookable-list-item>  -->   

                    <!-- <bookable-list-item 
                         :item-title="bookable.itemTitle" 
                        :item-description="bookable.itemDescription" 
                        :id="bookable.id">  
                    </bookable-list-item>   -->  

                    <!-- Este modo solo puede ser usado si las propiedades en la base de datos (columnas), tienen el mismo nombre que 
                        las props definidas en el componente -->
                    <bookable-list-item v-bind="bookable"> </bookable-list-item>
                    <!-- <bookable-list-item v-if="bookable1||bookable2" title="Cheap Villa 3" item-description="A very cheap villa 3" v-bind:price="3000">   </bookable-list-item> -->

                 </div>
                 <div class="col" v-for="p in placeholderInRow(row)" :key="'placeholder' + row + p"></div>

            </div>
            
        </div>
        
    </div>
</template>


<!-- Importar localmente -->
<script>
import BookableListItem from "./BookableListItem";
export default {
    components:{
        BookableListItem
    },

    // Definir datos reactivos (reactive data), son propiedades que pueden ser modificadas en tiempo real, ya que son de lectura y escritura,
    // a diferencia de las "props", las cuales son solo lectura. 
    // Los datos son enviados del componente padre al componente hijo.
    data(){
        return{
            bookables: null,
            loading: false,
            columns: 3
        };
    },

    // Las propiedades computadas son recalculadas cada que un elemento dentro de ellas cambia
    computed:{
        rows(){
            return this.bookables == null ? 0 : Math.ceil(this.bookables.length / this.columns);
        }
    },

    methods:{
        // Para obtener los bookables a mostrar en la fila. 
        // Se obtienen los bookables entre el primer parámetro (inclusivo) y el segundo (exclusivo)
        bookablesInRow(row){
            return this.bookables.slice((row -1) * this.columns, row * this.columns);
        },

        placeholderInRow(row){
            return this.columns - this.bookablesInRow(row).length;
        }
    },

    // Lifecycle hook recomendado para cargar archivos del servidor
    mounted() {
        console.log('mounted');
    },

    
    created() {
        this.loading = true;

        /* 
        Función flecha. () =>
         
        function(a){
            return a + 100;
        }

        (a) => {
            return a + 100;
        }

        (a) => a + 100;

        a => a + 100;
        */
        // La expresión función flecha, es una alternativa compacta de declarar una función tradicional, no puede usarse como métodos, no tiene sus propios "this",
        // No tiene argumentos, no pueden ser usados como constructores

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


        // `Texto ${funcion}`
        // Se usa para para usar variables dentro del texto





        // HTTP request using axios (también se hace uso de promesas)
        const request = axios.get("/api/bookables").then(response => {
            this.bookables = response.data.data;
            //this.bookables.push({itemTitle: "x", itemDescription: "x"});
            this.loading = false;
        });
        console.log(request);


        // Modificar una variable reactiva pasados 2 segundos
        /*setTimeout(()=>{

            this.bookables = [
                {
                    itemTitle: "Cheap Villa",
                    itemContent: "A very cheap villa"
                },

                {
                    itemTitle: "Cheap Villa 2",
                    itemContent: "A very cheap villa 2"
                },

                {
                    itemTitle: "Cheap Villa 2",
                    itemContent: "A very cheap villa 2"
                },

                {
                    itemTitle: "Cheap Villa 2",
                    itemContent: "A very cheap villa 2"
                },

                {
                    itemTitle: "Cheap Villa 2",
                    itemContent: "A very cheap villa 2"
                },

                {
                    itemTitle: "Cheap Villa 2",
                    itemContent: "A very cheap villa 2"
                },

                {
                    itemTitle: "Cheap Villa 2",
                    itemContent: "A very cheap villa 2"
                }
            ];
            
            this.loading = false;

        }, 2000);*/
    },


}
</script>