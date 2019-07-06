
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');
window.google = google;
window.swal = require('sweetalert');
window.Cleave = require("cleave.js");
window.cleavephone = require("cleave.js/dist/addons/cleave-phone.ng");
window._ = require("lodash");
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('parcel', require('./components/Parcel.vue').default);
Vue.component('add-biker', require('./components/AddBiker.vue').default);
Vue.component('add-bike', require('./components/AddBike.vue').default);
Vue.component('paid', require('./components/Paid.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
 Vue.use(Vuex);

 const store = new Vuex.Store({
    state: {
        parcel: null,
        items: [],
    },
    mutations: {
        updateItems(state, item){
            state.items.push(item);
        }
    }
 });


 const app = new Vue({
     el: '#app',
     store,
 });

 $('body').on('click', '#clear-estimate-form', (e) => {
    $('#get-estimate').trigger('reset');
 });

// Estimate calculator
if ( $('#get-estimate').length > 0 ){
    let options = {
            types: ['address'],
            componentRestrictions: { country: 'NG' }
        },
        from_address = document.getElementById('estimate_from_address'),
        to_address = document.getElementById('estimate_to_address'),
        from_autocomplete = new google.maps.places.Autocomplete(from_address, options),
        to_autocomplete = new google.maps.places.Autocomplete(to_address, options);

        from_autocomplete.addListener('place_changed', ()=>{
            from_address.value = from_autocomplete.getPlace().formatted_address;
        });

        to_autocomplete.addListener('place_changed', ()=>{
            to_address.value = to_autocomplete.getPlace().formatted_address;
        });

    $('body').on('submit', '#get-estimate', e => {
        e.preventDefault();

        if ( from_address.value === '' ){
            swal({
                icon: "error",
                text: "Please enter the pickup address"
            });
            return;
        }
        if ( to_address.value === '' ){
            swal({
                icon: "error",
                text: "Please enter the receivers address"
            });
            return;
        }

        swal({
            title: "Calculating estimate...",
            content: {
                element: "div",
                attributes: {
                    className: "is-loading"
                }
            },
            button: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
        });
        let distance = getDistance(from_address.value, to_address.value);
        distance.then( result => {
            swal.close();
            let deliveryDistance = Math.ceil(result[0].distance.value / 1000),
                pickupDistance = Math.ceil(result[1].distance.value / 1000 ),
                deliveryCost = ( deliveryDistance > 15 ) ? (deliveryDistance * window.push.costPerKmLong) + window.push.basePrice : (deliveryDistance * window.push.costPerKmShort) + window.push.basePrice,
                pickupCost = ( pickupDistance < 15 ) ? pickupDistance * window.push.pickupCostPerKM : pickupDistance * 15,
                totalCost = deliveryCost + pickupCost;

            swal({
                title: '₦' + totalCost.toLocaleString('en-GB'),
                text: `To pickup your parcel from ${from_address.value} and deliver to ${to_address.value}`,
                closeOnEsc: false,
                closeOnClickOutside: false,
                buttons: {
                    cancel: {
                        text: "OK",
                        value: null,
                        visible: true,
                        closeModal: true,
                    },
                    confirm: {
                        text: "Request Pickup",
                        value: true,
                        closeModal: true,
                    }
                }
            }).then( confirm => {
                if ( confirm ){
                    fbq('track', 'ViewContent', {
                        content_type: 'Confirm Estimate',
                    });
                    window.location.href = `/request-pickup/?sender=${from_address.value}&receiver=${to_address.value}&cost=${totalCost}&distance=${deliveryDistance}`;
                }
            });
            fbq('track', 'ViewContent', {
                content_type: 'Get Estimate',
            });
        }).catch( error => {
            if ( error.error === 404 ){
                swal({
                    icon: "error",
                    text: "We couldn't determine your location. Please check the sender and receiver address and try again.",
                    buttons: {
                        cancel: {
                            text: "Try Again",
                            value: null,
                            visible: true,
                            closeModal: true,
                        }
                    }
                });
            }
            if ( error.error === 406 ){
                swal({
                    icon: "error",
                    text: "Sorry, we don't pickup and deliver parcels at distances longer than 100km within Lagos.",
                    buttons: {
                        cancel: {
                            text: "Choose another destination",
                            value: null,
                            visible: true,
                            closeModal: true,
                        }
                    }
                });
            }
            return;
        });
    });

    function getDistance(origin, destination){
        return new Promise( (resolve, reject) => {
            let distanceMatrix = new google.maps.DistanceMatrixService();
            let distance = distanceMatrix.getDistanceMatrix({
                origins: [origin],
                destinations: [destination, window.push.officeAddress],
                unitSystem: google.maps.UnitSystem.METRIC,
                travelMode: 'DRIVING',
             }, function(results, status){
                 if ( status === 'OK' ){
                     let row = results.rows[0].elements;

                     if ( row[0].status === 'OK' && row[1].status === 'OK'){
                        let totalDistance = row[0].distance.value + row[1].distance.value;
                        if ( totalDistance > 100000 ){
                            reject({ error: 406 });
                        } else {
                            resolve(row);
                        }
                     } else {
                         reject({ error: 404 });
                     }
                 } else {
                     reject({ error: 'Distance cannot be determined!' });
                 }
            });
        } )
    }
}

const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

// Check if there are any navbar burgers
if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
        el.addEventListener('click', () => {

            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
            $('body').toggleClass('is-menu-active');
        });
    });
}

if ( sessionStorage.getItem('disclaimer') === null ){
    setTimeout(()=>{
        $('.modal.disclaimer').addClass('is-active');
        $('.modal.disclaimer').find('.close').on('click', (e)=>{
            $('.modal.disclaimer').removeClass('is-active');
            sessionStorage.setItem('disclaimer', true);
        });
    }, 2000)
}
