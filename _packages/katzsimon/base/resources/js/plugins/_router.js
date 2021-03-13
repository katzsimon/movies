import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

import routes from '@/plugins/router_routes';

const router = new VueRouter({
    mode: 'history',
    routes: routes,
    base: '/',
    linkExactActiveClass: "active",
});

function nextFactory(context, middleware, index) {
    const subsequentMiddleware = middleware[index];
    if (!subsequentMiddleware) return context.next;
    return (...parameters) => {
        context.next(...parameters);
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({ ...context, next: nextMiddleware });
    };
}

router.beforeEach((to, from, next) => {
    if (to.meta.middleware) {
        const middleware = Array.isArray(to.meta.middleware) ? to.meta.middleware : [to.meta.middleware];
        const context = {from, next, router, to };
        const nextMiddleware = nextFactory(context, middleware, 1);
        //console.log('next: ', nextMiddleware());
        //console.log('middle: ', middleware[0]);
        //middleware[0]({ ...context, next: nextMiddleware });
        return middleware[0]({ ...context, next: nextMiddleware });
    }
    return next();
});

export default router;













/*
function auth({ next, router }) {
    console.log('testing auth middleware');

    if (!localStorage.getItem('jwt')) {
        return router.push({ name: 'login' });
    }

    //return next();
}
*/
