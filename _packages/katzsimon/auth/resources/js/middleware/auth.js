// Middleware to check if the user is logged in
// Do not allow the route to load if the user is not authenticated

export default function auth({ next, router }) {
    let store = localStorage.getItem('store');

    try {
        // Try to decode if store is encoded
        store = atob(store);
    } catch(e) {
    }

    try {
        store = JSON.parse(store);
    } catch(e) {
    }

    if (store.auth!==true) {
        //console.log('auth failed');
        return router.push({name: 'login'});
    } else {
        //console.log('auth passed');
    }
    return next();
}
