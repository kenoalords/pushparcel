<template>
    <div>
        <!--  Sender details  -->
        <ul class="errors" v-if="errors.length > 0">
            <li v-for="error in errors">{{ error.message }}</li>
        </ul>
        <form action="#" method="post" id="request-form" @change="checkDetailFields" autocomplete="false">
        <input type="hidden" style="display:none" autocomplete="false">
        <h3 class="title is-5">Senders details</h3>
            <div class="field is-grouped">
                <p class="control is-expanded">
                    <label for="fullname">Fullname</label>
                    <input id="fullname" type="text" v-model="parcel.sender.fullname" placeholder="John Olawale" class="input">
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
                    <input type="text" v-model="parcel.sender.address" placeholder="" class="input" id="estimate_from_address" autocomplete="anyrandomstring">
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
                    <input autocomplete="anyrandomstring" type="text" v-model="parcel.receiver.address" class="input" id="estimate_to_address">
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

            <div class="field payment_type">
                <h3 class="title is-5">How will you like to pay?</h3>
                <!-- <div class="select">
                    <select v-model="parcel.payment_type">
                        <option value="0">Select</option>
                        <option v-for="item in parcel.paymentType" :value="item[0]">{{ item[1] }}</option>
                    </select>
                </div> -->
                <label v-for="item in parcel.paymentType">
                    <input type="radio" :value="item[0]" v-model="parcel.payment_type" id=""> {{ item[1] }}
                </label>
            </div>
            <br><br>

            <div class="field box" style="margin-bottom: 2em">
                <div class="level is-mobile">
                    <div class="level-item">
                        <div class="has-text-centered">
                            <div class="spaced-text">Estimated fare</div>
                            <h2 class="title is-1 has-text-danger">₦{{ computedPrice }}</h2>
                        </div>
                    </div>
                    <div class="level-item">
                        <div class="has-text-centered">
                            <div class="spaced-text">Distance</div>
                            <h2 class="title is-1 has-text-danger">{{ computedDistance }}</h2>
                        </div>
                    </div>

                </div>
            </div>

            <div class="field">
                <button class="button is-action is-medium" :class="{ 'is-loading' : isLoading }" @click.prevent="submitParcelRequest" :disabled="!isValid">Make request</button>
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
                isValid: false,
                loggedUser: ( this.user !== null ) ? JSON.parse(this.user) : null,
                geocoder: new google.maps.Geocoder(),
                distance: new google.maps.DistanceMatrixService(),
                errors: [],
                isLoading: false,
            }
        },
        computed: {
            computedPrice(){
                return ( this.parcel.price !== 0 ) ? parseInt(Math.round(this.parcel.price)).toLocaleString() : "0";
            },
            computedDistance(){
                return ( this.parcel.distance !== 0 ) ? Math.round(this.parcel.distance / 1000) + 'km' : "0km";
            },
        },
        props: {
            user: null,
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
            submitParcelRequest(){
                let _this = this;
                _this.errors = [];

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

                // Validate payment method
                if ( _this.parcel.payment_type === null || _this.parcel.payment_type == 0 ){
                    _this.errors.push({ key: 'pt', message: 'Please select an appropraite payment type' });
                }

                // Validate price
                if ( _this.parcel.price === 0 ){
                    _this.errors.push({ key: 'price', message: 'We are unable to process your request because we cannot determine your estimated fare. Please check your address field and correct any mistakes there.' })
                }

                // Validate distance
                if ( _this.parcel.distance === 0 ){
                    _this.errors.push({ key: 'distance', message: 'We are unable to process your request because we cannot determine your estimated distance. This helps us calculate your estimated fare. Please check your address fields for any errors' });
                }

                if ( _this.errors.length > 0 ){
                    alert("Please check for errors");
                    return;
                }

                _this.isLoading = true;
                $('body').addClass('is-loading');
                // Prepare data
                let data = {
                    sender_fullname: _this.parcel.sender.fullname,
                    sender_email: _this.parcel.sender.email,
                    sender_phone: _this.parcel.sender.phone,
                    sender_address: _this.parcel.sender.address,
                    receiver_fullname: _this.parcel.receiver.fullname,
                    receiver_phone: _this.parcel.receiver.phone,
                    receiver_address: _this.parcel.receiver.address,
                    price: _this.parcel.price,
                    distance: _this.parcel.distance,
                    items: _this.parcel.parcelitems,
                    payment_type: _this.parcel.payment_type,
                };

                // Post data to server
                axios.post('/app/parcel', data).then( response => {
                    _this.isLoading = false;
                    let payload = response.data;

                    if ( payload.payment_type === "online" ){
                        let amount = Math.floor(payload.parcel.price) * 100;
                        let paystack = PaystackPop.setup({
                            key: 'pk_test_4dfe0155f15b8fd873e52b04bffc5537993488c7',
                            email: payload.parcel.sender_email,
                            amount: amount,
                            currency: "NGN",
                            callback: (response) => {
                                if ( response.status === 'success' ){
                                    axios.post('/request-pickup/'+payload.parcel.uuid+'/payment', response).then( (response) => {
                                        swal({
                                            title: 'Success',
                                            text: 'Your payment was made successfully. You will be redirected in 3seconds',
                                            icon: 'success',
                                            closeOnClickOutside: false,
                                            closeOnEsc: false,
                                            buttons: false,
                                        });
                                        setTimeout(()=>{
                                            window.location.href = '/thank-you/' + payload.parcel.uuid;
                                        }, 3000);
                                    }).catch( (error) => {
                                        console.log(error);
                                    });
                                }
                                _this.isLoading = false;
                            },
                            onClose: () => {
                                // PayStack window closed
                                _this.isLoading = false;
                            }
                        });
                        paystack.openIframe();
                    }

                } ).catch( e => {
                    console.log('An error occured', e);
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
                if ( this.parcel.sender.fullname &&  this.parcel.sender.email && this.parcel.sender.phone && this.parcel.sender.address && this.parcel.receiver.fullname && this.parcel.receiver.phone && this.parcel.receiver.address ){
                    let _this = this;
                    let data = {
                        senderAddress: this.parcel.sender.address,
                        receiverAddress: this.parcel.receiver.address
                    };
                    _this.isValid = true;
                    let distance = this.distance.getDistanceMatrix({
                        origins: [data.senderAddress],
                        destinations: [data.receiverAddress],
                        unitSystem: google.maps.UnitSystem.METRIC,
                        travelMode: 'DRIVING',
                     }, function(results, status){
                         if ( status === 'OK' ){
                             let row = results.rows[0].elements[0];
                             if ( row.status === 'OK' ){
                                 const basePrice = window.push.basePrice;
                                 const costPerDistance = ( row.distance.value < 15000 ) ? window.push.costPerKmShort : window.push.costPerKmLong;
                                 const distance = (row.distance.value / 1000) * costPerDistance;
                                 _this.parcel.price = basePrice + distance;
                                 _this.parcel.distance = row.distance.value;
                             } else if ( row.status === 'NOT_FOUND' ) {
                                 swal('Oops!', 'we couldn\'t determine distance, please check the addresses and try again', 'error');
                                 _this.isValid = false;
                             }
                         } else {
                             swal('Oops!', 'we couldn\'t determine distance, please check the addresses and try again', 'error');
                         }
                    });
                }
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
                this.parcel.sender = {
                    address: this.getParameterByName('sender'),
                }
            }
            if ( this.getParameterByName('receiver') ){
                this.parcel.receiver = {
                    address: this.getParameterByName('receiver'),
                }
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
                from_address = document.getElementById('estimate_from_address'),
                to_address = document.getElementById('estimate_to_address'),
                from_autocomplete = new google.maps.places.Autocomplete(from_address, options),
                to_autocomplete = new google.maps.places.Autocomplete(to_address, options);
        }
    }
</script>
