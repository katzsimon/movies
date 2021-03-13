// Middleware to check if the user is not logged in
// Only allow the route to load if the user is not authenticated

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

    if (store.auth===true) {
        return router.push({name: 'account'});
    } else {
    }
    return next();
}
