<template>
    <div>
        Dashboard
    </div>
</template>

<script>
export default {
    name: "Dashboard",
    data() {
        return {
            msg: 'Dashboard Body'
        }
    },
    mounted: function(){

        //console.log('icon: ', window.icons.home);
        axios.post('/api/dashboard')
            .then((res)=>{
                this.msg = res.data;
            })
            .catch((error)=>{
                this.errors = error.response.data.errors;
            });

        /*
        axios.get('/sanctum/csrf-cookie').then(response => {

        });

         */
    }
}
</script>

<style scoped>

</style>
