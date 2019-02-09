import './bootstrap';
import Vue from 'vue';
import router from './router';
import store from './store';
import App from './App.vue';

const createApp = async () => {
    await store.dispatch('auth/currentUser');

    new Vue({
        el: '#app',
        router, // ルーティング定義をここで読み込んでいる
        store,
        components: {App}, // ルートコンポーネントの使用を宣言する
        template: '<App />' // ルートコンポーネントを描画している
    });
}

createApp();