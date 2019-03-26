<template>
    <span>
        <button class="button is-action" @click.prevent="isActive = true">Add biker</button>
        <transition name="fade">
            <div class="modal is-active add-bike" v-if="isActive">
                <div class="modal-background" @click="isActive = false"></div>
                <button class="modal-close" @click="isActive = false"></button>
                <div class="modal-content">
                    <div class="box">
                        <h3 class="title is-4">Add Rider</h3>
                        <form class="" @submit.prevent="submitAddRider" method="post">
                            <div class="field">
                                <input type="text" class="input" v-model="rider.fullname" placeholder="Fullname">
                            </div>
                            <div class="field">
                                <input type="text" class="input" v-model="rider.address" placeholder="Address">
                            </div>
                            <div class="field">
                                <input type="text" class="input" v-model="rider.phone" placeholder="Phone number">
                            </div>
                            <div class="field">
                                <input type="text" class="input" v-model="rider.age" placeholder="Age">
                            </div>
                            <div class="field" v-if="rider.bikes">
                                <label for="">Assign bike to rider</label>
                                <div class="select is-fullwidth">
                                    <select v-model="rider.bike">
                                        <option>Select bike</option>
                                        <option :value="bike.id" v-for="bike in rider.bikes">{{ bike.make.toUpperCase() }} {{ bike.model.toUpperCase() }} - {{ bike.licence.toUpperCase() }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <button class="button is-action is-fullwidth" :class="{ 'is-loading' : isBusy }" type="submit" :disable="isBusy">Save Biker</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </transition>
    </span>
</template>

<script>
    export default {
        data(){
            return {
                rider: {
                    bikes: null,
                },
                isActive: false,
                isBusy: false,
            }
        },
        methods: {
            submitAddRider(e){
                e.preventDefault();
                let _this = this;
                _this.isBusy = true;
                if ( _this.rider.fullname == '' || _this.rider.address == '' || _this.rider.phone == '' || _this.rider.age == '' || _this.rider.bike == '' ){
                    swal('Error', 'All fields are required', 'error');
                    _this.isBusy = false;
                    return;
                }
                delete _this.rider.bikes;
                axios.post('/app/riders/add', _this.rider).then( response => {
                    swal('Added!', 'The rider details where added successfully', 'success');
                    _this.rider = {};
                    window.location.reload();
                }).catch( error => {
                    _this.isBusy = false;
                    console.log(error)
                });
            }
        },
        mounted() {
            var _this = this;
            axios.get('/app/bike/get-bikes').then( response => {
                // console.log(response.data);
                _this.rider.bikes = response.data;
            }).catch( error => console.log(error) );
        }
    }
</script>
