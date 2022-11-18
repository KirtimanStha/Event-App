<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Event</h4>
                </div>
                <div class="card-body">
                    <form @submit.prevent="create">
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
                                    <span v-if="errors.description" :class="['label label-danger']">@{{ errors.description[0] }}</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save</button>
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
    name:"add-event",
    data(){
        return {
            event:{
                title:"",
                description:"",
                start_date:"",
                end_date:""
            },
            errors:[]
        }
    },
    methods:{
        async create(){
            await axios.post('/api/events',this.event).then(response=>{
                this.$router.push({name:"eventList"})
                toastr.success("Event Created Successfully");
            }).catch(error=>{
                $.each(error.response.data.errors, function(index, value){                    
                    toastr.error(value[0]);
                });
            })
        }
    }
}
</script>