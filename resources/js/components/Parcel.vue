<template>
    <div>
        <!--  Sender details  -->
        <ul class="errors" v-if="errors.length > 0">
            <li v-for="error in errors">{{ error.message }}</li>
        </ul>
        <form action="#" method="post" id="request-form" @change="checkDetailFields">
        <input type="hidden" style="display:none" autocomplete="false">
        <h3 class="title is-5">Senders details</h3>
            <div class="field is-grouped">
                <p class="control is-expanded">
                    <label for="fullname">Fullname</label>
                    <input id="fullname" type="text" v-model="parcel.sender.fullname" placeholder="John Olawale" class="input" :class="{ 'is-danger' : formatErrorField('sender_fullname') }">
                </p>
                <p class="control is-expanded">
                    <label for="s-email">Email address</label>
                    <input type="text" id="s-email" v-model="parcel.sender.email" placeholder="john.olawale@gmail.com" class="input">
                </p>
                <p class="control is-expanded">
                    <label for="s-email">Phone number</label>
                    <input type="text" v-model="parcel.sender.phone" maxlength="14" placeholder="08023456789" class="input phone">
                </p>
            </div>

            <div class="field is-grouped">
                <p class="control is-expanded">
                    <label for="estimate_from_address">Address</label>
                    <input type="text" v-model="senderAddress" placeholder="Start typing address..." class="input address-field" id="estimate_from_address" ref="from_address">
                </p>
            </div>

            <hr>

            <!--  Reciever details  -->

            <h3 class="title is-5">Receiver details</h3>
            <div class="field is-grouped">
                <p class="control is-expanded">
                    <label for="">Receiver fullname</label>
                    <input type="text" v-model="parcel.receiver.fullname" placeholder="Bright Okon" class="input">
                </p>
                <p class="control is-expanded">
                    <label for="">Receiver phone number</label>
                    <input type="text" v-model="parcel.receiver.phone" maxlength="14" placeholder="08023456789" class="input phone">
                </p>
            </div>

            <div class="field is-grouped">
                <p class="control is-expanded">
                    <label for="estimate_to_address">Delivery address</label>
                    <input autocomplete="anyrandomstring" type="text" v-model="receiverAddress" class="input address-field" id="estimate_to_address" ref="to_address" placeholder="Start typing address...">
                </p>

            </div>
            <hr>
            <!--  Parcel Items  -->
            <div class="field">
                <h3 class="title is-5">Package items</h3>
            </div>

            <div class="field is-grouped" v-for="(item, index) in parcel.parcelitems" v-bind:key="index">
                <p class="control is-expanded">
                    <label for="">&nbsp;</label>
                    <input type="text" v-model="item.description" placeholder="Description" class="input">
                </p>
                <p class="control">
                    <label>Weight(kg)</label>
                    <input type="text" v-model="item.weight" class="input">
                </p>
                <p class="control">
                    <label>Qty.</label>
                    <input type="number" v-model="item.quantity" class="input">
                </p>
            </div>
            <div class="field">
                <a class="button" @click="addItem">+ add item</a>
            </div>
            <hr>

            <!-- <div class="field payment_type">
                <h3 class="title is-5">How will you like to pay?</h3>
                <label v-for="item in parcel.paymentType">
                    <input type="radio" :value="item[0]" v-model="parcel.payment_type" id=""> {{ item[1] }}
                </label>
            </div>
            <br><br> -->

            <div class="field box" id="parcel-estimate">
                <div class="level is-mobile">
                    <div class="level-item">
                        <div class="has-text-centered">
                            <div class="spaced-text">Estimated fare</div>
                            <h2 class="title is-1 is-size-4-mobile has-text-danger">₦{{ computedPrice }}</h2>
                        </div>
                    </div>
                    <div class="level-item">
                        <div class="has-text-centered">
                            <div class="spaced-text">Distance</div>
                            <h2 class="title is-1 is-size-4-mobile has-text-danger">{{ computedDistance }}</h2>
                        </div>
                    </div>

                </div>
            </div>

            <div class="field">
                <button class="button is-action is-medium" :class="{ 'is-loading' : isLoading }" @click.prevent="submitParcelRequest" :disabled="!isValid"><span>Proceed</span> <span class="icon"><i class="fas fa-arrow-right"></i></span></button>
            </div>
        </form>
        <hr>
        <div class="has-text-centered">
            <h4 class="title is-6 is-size-6-mobile">Secured online payment powered by <a href="https://paystack.com" target="_blank"><strong>PayStack</strong></a></h4>
            <figure class="image" style="max-width: 256px; margin: 1em auto;">
                <a href="https://paystack.com" target="_blank">
                    <img src="/images/paystack.png" alt="PayStack">
                </a>
            </figure>
        </div>
    </div>
</template>

<script>

    export default {
        data(){
            return{
                parcel: {
                    sender: {},
                    receiver: {},
                    parcelitems: [{
                        description: null,
                        weight: "0.0",
                        quantity: 1,
                    }],
                    paymentType:[
                        [ 'online', 'Online payment' ],
                        [ 'pop', 'Pay on pickup' ],
                    ],
                    price: 0,
                    distance: 0,
                    payment_type: null,
                },
                senderAddress: '',
                receiverAddress: '',
                isValid: true,
                loggedUser: ( this.user !== null ) ? JSON.parse(this.user) : null,
                geocoder: new google.maps.Geocoder(),
                distance: new google.maps.DistanceMatrixService(),
                errors: [],
                isLoading: false,
                distanceCost: null,
                pickupCost: null,
            }
        },
        computed: {
            computedPrice(){
                return ( this.parcel.price !== 0 ) ? parseInt(Math.round(this.parcel.price)).toLocaleString() : "0";
            },
            computedDistance(){
                return ( this.parcel.distance !== 0 ) ? this.parcel.distance + 'km' : "0km";
            },
        },
        props: {
            user: null,
        },
        watch: {
            senderAddress: function() {
                this.debounceGetDistance();
            },
            receiverAddress: function() {
                this.debounceGetDistance();
            },
        },
        created: function(){
            this.debounceGetDistance = _.debounce(this.getDistanceEstimate, 1000);
        },
        methods: {
            getParameterByName(name, url) {
                if (!url) url = window.location.href;
                name = name.replace(/[\[\]]/g, '\\$&');
                var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
                if (!results) return null;
                if (!results[2]) return '';
                return decodeURIComponent(results[2].replace(/\+/g, ' '));
            },
            formatErrorField(name){
                return ( this.errors.indexOf(name) !== -1 ) ? true : false;
            },
            submitParcelRequest(){
                let _this = this;
                _this.errors = [];

                // Validate fullname
                if ( !_this.parcel.sender.fullname ){
                    _this.errors.push({ key: 'sender_fullname', message: 'Please provide the senders fullname' });
                }

                if ( !_this.parcel.receiver.fullname ){
                    _this.errors.push({ key: 'receiver_fullname', message: 'Please provide the receivers fullname' });
                }

                if ( !_this.parcel.receiver.phone ){
                    _this.errors.push({ key: 'receiver_phone', message: 'Please provide the receivers phone number' });
                }

                if ( !_this.parcel.sender.phone ){
                    _this.errors.push({ key: 'sender_phone', message: 'Please provide the senders phone number' });
                }

                // validate email addresses
                if ( !this.validEmail(_this.parcel.sender.email)  ){
                    _this.errors.push({ key: 'email', message: 'Please check your email for errors' });
                }

                // Validate parcel items
                for ( let i = 0; i < _this.parcel.parcelitems.length; i++ ){
                    if ( _this.parcel.parcelitems[i].description == null ){
                        _this.errors.push({ key: 'items', message: 'Please provide a description, weight and quantity of the item you want shipped' });
                    }
                }

                // Validate price
                if ( _this.parcel.price === 0 ){
                    _this.errors.push({ key: 'price', message: 'We are unable to process your request because we cannot determine your fare. Please check your address fields for errors or call us on ' + window.push.contactNumber + ' to make your request.'  })
                }

                if ( _this.errors.length > 0 ){
                    swal({ text: "Please check the form for errors", title: "Errors Found!", icon: 'error' });
                    return;
                }

                _this.isLoading = true;
                $('body').addClass('is-loading');
                // Prepare data
                let data = {
                    sender_fullname: _this.parcel.sender.fullname,
                    sender_email: _this.parcel.sender.email,
                    sender_phone: _this.parcel.sender.phone,
                    sender_address: _this.senderAddress,
                    receiver_fullname: _this.parcel.receiver.fullname,
                    receiver_phone: _this.parcel.receiver.phone,
                    receiver_address: _this.receiverAddress,
                    price: _this.parcel.price,
                    distance: _this.parcel.distance,
                    items: _this.parcel.parcelitems,
                };

                // Post data to server
                axios.post('/app/parcel', data).then( response => {
                    _this.isLoading = false;
                    let payload = response.data;
                    // $('body').removeClass('is-loading');
                    window.location.href = '/app/parcel/' + payload.parcel.uuid + '/checkout';
                    return;

                } ).catch( e => {
                    console.log('An error occured', e);
                    $('body').removeClass('is-loading');
                    _this.isLoading = false;
                });

            },
            addItem(){
                for ( let i = 0; i < this.parcel.parcelitems.length; i++ ){
                    if ( this.parcel.parcelitems[i].description === null ) return;
                }
                this.parcel.parcelitems.push({ description: null, weight: "0.0", quantity: 1 });
            },
            validEmail(email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },
            getUserProfile(id){
                let _this = this;
                axios.get('/app/' + id + '/profile').then( response => {
                    if ( response.data ){
                        let res = response.data;
                        _this.parcel.sender = {
                            fullname: res.first_name + ' ' + res.last_name,
                            email: _this.loggedUser.email,
                            phone: res.phone,
                        }
                    }
                }).catch( e => console.log(e) );
            },

            checkDetailFields(){
                if ( this.parcel.sender.fullname &&  this.parcel.sender.email && this.parcel.sender.phone && this.senderAddress && this.parcel.receiver.fullname && this.parcel.receiver.phone && this.receiverAddress ){
                    this.isValid = true;
                } else {
                    this.isValid = false;
                }
            },

            getDistanceEstimate(){
                let _this = this;
                if ( _this.senderAddress && _this.receiverAddress ){
                    let distance = _this.getDistance(_this.senderAddress, _this.receiverAddress).then( result => {
                        let deliveryDistance = Math.ceil(result[0].distance.value / 1000),
                            pickupDistance = Math.ceil(result[1].distance.value / 1000 ),
                            deliveryCost = ( deliveryDistance > 15 ) ? (deliveryDistance * window.push.costPerKmLong) + window.push.basePrice : (deliveryDistance * window.push.costPerKmShort) + window.push.basePrice,
                            pickupCost = (pickupDistance < 15) ? pickupDistance * window.push.pickupCostPerKM : pickupDistance * 15,
                            totalCost = deliveryCost + pickupCost;

                        _this.parcel.price = totalCost;
                        _this.parcel.distance = deliveryDistance;
                    });
                }
            },

            getDistance(origin, destination){
                let _this = this;
                return new Promise( (resolve, reject) => {
                    let distance = _this.distance.getDistanceMatrix({
                        origins: [origin],
                        destinations: [destination, window.push.officeAddress],
                        unitSystem: google.maps.UnitSystem.METRIC,
                        travelMode: 'DRIVING',
                     }, function(results, status){
                         if ( status === 'OK' ){
                             let row = results.rows[0].elements;
                             // console.log(results);
                             if ( row[0].status === 'OK' ){
                                 resolve(row);
                             } else if ( row.status === 'NOT_FOUND' ) {
                                 reject({ error: 'Address Not Found' });
                             }
                         } else {
                             reject({ error: 'Distance cannot be determined!' });
                         }
                    });
                } )
            },
        },
        mounted() {

            $('.phone').each(function(i, el){
                new Cleave(el, {
                    phone: true,
                    phoneRegionCode: 'NG',
                });
            });

            if ( this.loggedUser !== null ){
                this.getUserProfile(this.loggedUser.id);
            }
            if ( this.getParameterByName('sender') ){
                    this.senderAddress = this.getParameterByName('sender');
            }
            if ( this.getParameterByName('receiver') ){
                this.receiverAddress = this.getParameterByName('receiver');
            }
            if ( this.getParameterByName('cost') ){
                this.parcel.price = this.getParameterByName('cost');
            }
            if ( this.getParameterByName('distance') ){
                this.parcel.distance = this.getParameterByName('distance');
            }

            let options = {
                    types: ['address'],
                    componentRestrictions: { country: 'NG' }
                },
                _this = this,
                from_address = document.getElementById('estimate_from_address'),
                to_address = document.getElementById('estimate_to_address'),
                from_autocomplete = new google.maps.places.Autocomplete(this.$refs.from_address, options),
                to_autocomplete = new google.maps.places.Autocomplete(this.$refs.to_address, options);
                // set the address
                from_autocomplete.addListener( 'place_changed', () => {
                    _this.senderAddress = from_autocomplete.getPlace().formatted_address;
                    // _this.getDistanceEstimate();
                });
                to_autocomplete.addListener( 'place_changed', () => {
                    _this.receiverAddress = to_autocomplete.getPlace().formatted_address;
                    // _this.getDistanceEstimate();
                });
        }
    }
</script>
