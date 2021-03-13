// Logout function if using Laravel Sanctum

export default {
    methods: {
        onLogout: function(){
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/logout')
                    .then((res)=>{
                        this.$store.commit('logout');
                        this.$router.push({name:'home'});
                    })
                    .catch((error)=>{
                        this.errors = error.response.data.errors;
                    });
            });
            this.$store.commit('logout');
            this.$router.push({name:'home'});
        }
    },
}
