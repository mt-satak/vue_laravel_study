import Vue from 'vue';
import VueRouter from 'vue-router';

// ページコンポーネントをインポートする
import PhotoList from './pages/PhotoList.vue';
import Login from './pages/Login.vue';

import store from './store';
import SystemError from './pages/errors/System.vue';

// VueRouterプラグインを使用する
Vue.use(VueRouter);

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: PhotoList
    },
    {
        path: '/login',
        component: Login,
        beforeEnter (to, from, next) {
            if (store.getters['auth/check']) {
                next('/');
            } else {
                next();
            }
        }
    },
    {
        path: '/500',
        component: SystemError
    }
];

// VueRouterインスタンスを生成する
const router = new VueRouter({
    mode: 'history',
    routes
});

// VueRouterインスタンスをエクスポート(app.jsでインポートさせたい)
export default router;