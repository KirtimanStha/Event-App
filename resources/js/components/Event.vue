<template>
    <div class="container">
        <div class="card-header text-end">
            <router-link :to='{name:"home"}'><button class="btn btn-sm btn-info">Back</button></router-link>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>{{ event.title }}</h5>
                <br>
                <p>{{ event.description }}</p>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    name:"event",
    data(){
        return {
            event:''
        }
    },
    mounted(){
        this.getEvent()
    },
    methods:{
        async getEvent(){
            await axios.get(`/api/events/${this.$route.params.id}`).then(response=>{
                this.event = response.data
            }).catch(error=>{
                this.event = ''
            })
        }
    }
}
</script>
