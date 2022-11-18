<template>
    <div class="row">
        <div class="col-12 mb-2 text-end">
            <router-link to="/event"><button class="btn btn-sm btn-info">Back</button></router-link>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update Event</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="update">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" v-model="event.title" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label>Start Date</label>
                                    <input type="date" class="form-control" v-model="event.start_date" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    <label>End Date</label>
                                    <input type="date" class="form-control" v-model="event.end_date" min="" required>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea type="text" class="form-control" v-model="event.description" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name:"update-event",
    data(){
        return {
            event:{
                title:"",
                description:"",
                start_date:"",
                end_date:"",
                _method:"patch"
            }
        }
    },
    mounted(){
        this.showEvent()
    },
    methods:{
        async showEvent(){
            await axios.get(`/api/events/${this.$route.params.id}`).then(response=>{
                const { title, description, start_date, end_date } = response.data
                this.event.title = title
                this.event.description = description
                this.event.start_date = start_date
                this.event.end_date = end_date
            }).catch(error=>{
                toastr.error("Something went wrong!");
            })
        },
        async update(){
            await axios.post(`/api/events/${this.$route.params.id}`,this.event).then(response=>{
                this.$router.push({name:"eventList"})
                toastr.success("Event Updated Successfully");
            }).catch(error=>{
                $.each(error.response.data.errors, function(index, value){                    
                    toastr.error(value[0]);
                });
            })
        }
    }
}
</script>