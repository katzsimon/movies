import Register from "@packages/auth/resources/js/pages/app/Register";
import Login from "@packages/auth/resources/js/pages/app/Login";
import Home from "@/pages/app/Home";
import Account from "@/pages/app/Account";

import Cinema from "@packages/cinema/resources/js/pages/app/Cinemas";
import Movies from "@packages/movie/resources/js/pages/app/Movies";
import UpcomingMovies from "@packages/cinema/resources/js/pages/app/UpcomingMovies";


import auth from "@packages/auth/resources/js/middleware/auth";
import guest from "@packages/auth/resources/js/middleware/guest";

const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'account',
        path: '/account',
        component: Account,
        meta: {middleware:[auth]}
    },
    {
        name: 'register',
        path: '/register',
        component: Register,
        meta: {middleware:[guest]}
    },
    {
        name: 'login',
        path: '/login',
        component: Login,
        meta: {middleware:[guest]}
    },


    {
        name: 'cinemas',
        path: '/cinemas',
        component: Cinema,
    },
    {
        name: 'movies',
        path: '/movies',
        component: Movies,
    },
    {
        name: 'upcoming-movies',
        path: '/upcoming-movies',
        component: UpcomingMovies,
    },
];

export default routes;
