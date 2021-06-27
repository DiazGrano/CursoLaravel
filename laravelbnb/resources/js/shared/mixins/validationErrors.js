export default{
    // Agrega lavariable errors a la data
    data(){
        return{
            errors:null,
        }
    },
    methods: {
        errorFor(field){
            // Si la variable erros, y errors[field] no son nulos, retorna el error que sucedió
            // Si no, retorna null
            return null !== this.errors && this.errors[field] ? this.errors[field] : null;
        }
    },
};