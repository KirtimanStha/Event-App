<template>
    <div class="row">
        <div class="col-12 mb-2 text-end">
            <router-link :to='{name:"eventCreate"}' class="btn btn-primary">Create</router-link>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Events</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody v-if="events.length > 0">
                                <tr v-for="(event,key) in events" :key="key" :id="event.slug">
                                    <td>{{ event.title }}</td>
                                    <td>{{ event.start_date }}</td>
                                    <td>{{ event.end_date }}</td>
                                    <td>
                                        <router-link :to='{name:"eventUpdate",params:{id:event.slug}}' class="btn btn-success btn-sm">Edit</router-link>
                                        <button type="button" @click="deleteEvent(event.slug)" class="btn btn-danger btn-sm" style="margin-left: 5px;">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="4" align="center">No Events Found.</td>
                                </tr>
                            </tbody>
                        </table>
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
            events:[]
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
        deleteEvent(id){
            // axios delete
            // axios.delete(`/api/events/${id}`).then(response=>{
            //     this.getEvents()
            // }).catch(error=>{
            //     toastr.error('Something Went Wrong!');
            // })

            // ajax delete
            if(confirm("Are you sure to delete this event ?")){
                $.ajax({
                    method: "DELETE",
                    url: `/api/events/${id}`,
                    data: {
                        '_token': $('input[name=_token]').val(),
                    },
                    success: function (response) {
                        if(response.status == "success"){
                            $("#"+`${id}`).remove();
                            if($('tbody tr').length == 0){
                                $('tbody').html("<tr><td colspan='4' align='center'>No Events Found.</td></tr>");
                            }
                            toastr.success("Event Deleted Successfully!");
                        }
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    toastr.error('Something Went Wrong!');
                });
            }
        }
    }
}
</script>