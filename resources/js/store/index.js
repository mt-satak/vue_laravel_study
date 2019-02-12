import Vue from 'vue';
import Vuex from 'vuex';
import auth from './auth';
import error from './error';
import message from './message';

Vue.use(Vuex);

// auth.jsをモジュール登録してストアを作成する
const store = new Vuex.Store({
    modules: {
        auth,
        error,
        message
    }
});

export default store;