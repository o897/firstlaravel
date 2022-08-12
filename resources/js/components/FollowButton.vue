<template>
 <div>
     <button class="btn btn-primary ml-4" @click="followUser" v-text="buttonText"></button>
 </div>
</template>

<script>
// import Axios from 'axios'

    export default {
        props:['userId', 'follows'],

        mounted() {
            console.log('Component mounted. Orapeleng')
        },

        data: function () {
            return {
                status: this.follows,
            }
        },
    //Axios is loaded already when we use bootstrap
        methods: {
            followUser() {
                axios.post('/follow/' + this.userId)
                .then(response => {
                    //toggling this.status (the follows function)
                    this.status = ! this.status;

                  console.log(response.data);
                })
                .catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                });
            }
        },
    

    computed: {
        buttonText() {
            //if this.status == true it means this users follows
            return (this.status) ? 'Unfollow' : 'Follow';
        }
    }
}


</script>
