<template>
    <span>
        <button class="button is-primary is-small" @click.prevent="markParcelAsPaid" v-if="isPaid === false">Mark as paid</button>
        <span class="button is-small" v-if="isPaid === true">
            <span class="icon"><i class="fas fa-check"></i></span>
            <span>Paid</span>
        </span>
    </span>
</template>

<script>
    export default {
        name: 'Paid',
        data(){
            return {
                parcel_id: this.id,
                isPaid: false,
            }
        },
        props: {
            id: null,
        },
        methods: {
            markParcelAsPaid(){
                let _this = this;
                swal({
                    title: "Mark as paid",
                    text: "Are you sure you want to mark this parcel as paid?",
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                    buttons: {
                        cancel: {
                            text: "No",
                            value: null,
                            visible: true,
                            closeModal: true,
                        },
                        confirm: {
                            text: "Yes, mark as paid",
                            value: true,
                            closeModal: true,
                        }
                    }
                }).then( confirm => {
                    if ( confirm ){
                        $('body').addClass('is-loading');
                        axios.post('/app/parcel/' + this.parcel_id + '/paid').then( response => {
                            if ( response.data.status === true ){
                                $('body').removeClass('is-loading');
                                _this.isPaid = true;
                            }
                        }).catch( error => {

                        });
                    }
                });
            },
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>
