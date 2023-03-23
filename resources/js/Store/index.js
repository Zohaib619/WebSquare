import { createStore } from "vuex";

const store = createStore({
    state: {
        // define variable
        token: localStorage.getItem("token") || 0
    },
    mutations: {
        // Update Variable
        UPDATE_TOKEN(state, payload){
            state.token = payload
        }
    },
    actions: {
        // action to be performed
        setToken(context, payload){
            localStorage.setItem('token', payload);
            context.commit('UPDATE_TOKEN', payload)
        },
        removeToken(context){
            localStorage.removeItem('token');
            context.commit("UPDATE_TOKEN", 0);
        }
    },
    getters:{
        // get state variable value
        getToken: function(state){
            return state.token
        }
    }
});

export default store;