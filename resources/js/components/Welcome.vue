<template>
    <div class="container mt-5">
        <div class="col-12 text-center">
            <h1>Events</h1>
            <div class="card">
                <div class="card-header" style="text-align:end">
                    <div class="d-inline-flex">
                        <label class="form-label" style="margin:5px;">Filter:</label>
                        <select class='form-select' v-model='data.selected' @change='filter()'>
                            <option value='' disabled>Select Filter</option>
                            <option value='0'>Reset Filter</option>
                            <option value='1'>Past Event</option>
                            <option value='2'>Upcoming events</option>
                            <option value='3'>Upcoming events within 7 days</option>
                            <option value='4'>Finished events of the last 7 days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row m-4" v-if="events.length > 0">
                        <div class="col-md-4" v-for="(event,key) in events" :key="key">
                            <router-link :to='{name:"event",params:{id:event.id}}'>
                                <div class="card">
                                    <div class="card-body">
                                        <h3>{{ event.title }}</h3>
                                    </div>
                                </div>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    name:"events",
    data(){
        return {
            events:[],
            data:{
                selected:''
            }
        }
    },
    mounted(){
        this.getEvents()
    },
    methods:{
        async getEvents(){
            await axios.get('/api/events').then(response=>{
                this.events = response.data
            }).catch(error=>{
                this.events = []
            })
        },
        async filter(){
            await axios.post('/api/filter', this.data).then(response=>{
                this.events = response.data
            }).catch(error=>{
                this.events = []
            })
        }
    }
}
</script>