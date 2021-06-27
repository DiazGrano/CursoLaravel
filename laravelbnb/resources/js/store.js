export default{
    state:{
        lastSearch:{
            from: null,
            to: null
        },
        basket:{
            items:[],
        }
        
    },

    mutations:{
        setLastSearch(state, payload){
            state.lastSearch = payload;
        },
        addToBasket(state, payload){
            state.basket.items.push(payload);
        },
        removeFromBasket(state, payload){
            state.basket.items = state.basket.items.filter(item => item.bookable.id !== payload);
        },
        setBasket(state, payload){
            state.basket = payload;
        },
        
    },

    // Son similares a las mutations, pero la diferencia es que en vez de mutar el state, las actions commit las mutations y que
    // las actions pueden contener operaciones asíncronas arbitrarias.
    // Las actions se llaman usando .dispatch('nombreAction', parámetro)
    actions:{
        setLastSearch(context, payload){
            context.commit('setLastSearch', payload);
            localStorage.setItem('lastSearch', JSON.stringify(payload));
        },

        // Esto es ejecutado en el app.js, para cargar los datos guardados localmente y que estos sean accesibles desde cada componente
        loadStoredState(context){
            const lastSearch = localStorage.getItem('lastSearch');
            if(lastSearch){
                context.commit('setLastSearch', JSON.parse(lastSearch));
            };
            // Se lee los datos crudos almacenados localmente, estos se encuentran en formato json en forma de string
            const basket = localStorage.getItem('basket');
            if(basket){
                // Se carga el carrito de compras con los datos guardados localmente transformados a objeto
                context.commit('setBasket', JSON.parse(basket));
            }
        },

        addToBasket({ commit, state }, payload){
            commit('addToBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },

        removeFromBasket({ commit, state }, payload){
            commit('removeFromBasket', payload);
            localStorage.setItem('basket', JSON.stringify(state.basket));
        },
        clearBasket({commit, state}, payload){
            commit("setBasket", {items: []});
            localStorage.setItem("basket", JSON.stringify(state.basket));
        }
    },

    getters:{
        itemsInBasket: (state) => state.basket.items.length,
        inBasketAlready(state){
            return function(id){
                // Se itera entre cada elemento del carrito de compras, retornando inicialmente el resultado por defecto (que es false), item representa el elemento actual
                // y en result se van acumulando los resultados. 
                // O sea que, en cada iteración, se compara la id del item actual que está dentro del carrito de compras y la id del elemento actual que se está intentando agregar
                // al carrito de compras.
                // Como la condición es ||, basta con que uno solo sea true, o sea, que ya exista dentro del carrito de compras, para regresar un true.
                return state.basket.items.reduce((result, item) => result || item.bookable.id === id, false);
            }
        }
    }
};