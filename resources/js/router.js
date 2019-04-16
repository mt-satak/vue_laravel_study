import Vue from 'vue';
import VueRouter from 'vue-router';

// ページコンポーネントをインポートする
import PhotoList from './pages/PhotoList.vue';
import PhotoDetail from './pages/PhotoDetail.vue';
import Login from './pages/Login.vue';
import SystemError from './pages/errors/System.vue';

import store from './store';

// VueRouterプラグインを使用する
Vue.use(VueRouter);

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: PhotoList,
        props: route => {
            const page = route.query.page
            return { page: /^[1-9][0-9]*$/.test(page) ? page * 1 : 1 }
        }
    },
    {
        path: '/photos/:id', // 写真idが利用される
        component: PhotoDetail,
        props: true
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
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes
});

// VueRouterインスタンスをエクスポート(app.jsでインポートさせたい)
export default router;