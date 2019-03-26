<template>
    <div>
        <form action="#" method="post" class="normal-form" @submit.prevent="addNewBike">
            <div class="field is-grouped">
                <p class="control">
                    <input type="text" class="input" v-model="bike.make" placeholder="Make">
                </p>
                <p class="control">
                    <input type="text" class="input" v-model="bike.model" placeholder="Model">
                </p>
                <p class="control">
                    <input type="text" class="input" v-model="bike.licence" placeholder="Licence plate">
                </p>
                <div class="control">
                    <div class="select">
                        <select v-model="bike.condition">
                            <option value="">Condition</option>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                        </select>
                    </div>
                </div>
                <p class="control">
                    <button class="button is-action" type="submit">Add bike</button>
                </p>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                bike: {},
            }
        },
        methods: {
            addNewBike(e){
                e.preventDefault();
                let _this = this;
                if ( this.bike.make === '' || this.bike.model === '' || this.bike.licence === '' || this.bike.condition === '' ){
                    swal('Check for errors', 'All fields are required', 'error');
                    return;
                }
                axios.post('/app/bike/add', this.bike).then( response => {
                    swal('Done!', 'The bike record was added successfully', 'success');
                    _this.bike = {};
                    window.location.reload(true);
                }).catch( error => {
                    swal('Server error', 'There was an error processing your request', 'error');
                });
            }
        },
        mounted() {

        }
    }
</script>
