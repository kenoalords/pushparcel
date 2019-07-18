<template>
    <span>
        <!-- Teaser section -->
        <section class="section is-brand">
            <div class="container">
                <div class="columns is-aligned-center is-mobile">
                    <div class="column is-4">
                        <figure class="image">
                            <img :src="icon" alt="Elite Club Badge">
                        </figure>
                    </div>
                    <div class="column is-8">
                        <h2 class="title is-3 is-size-5-mobile">Join our Elite club and save 10x MORE on your pickup and delivery cost</h2>
                        <p>
                            <a href="javascript:;" class="button is-highlight" @click.prevent="openModal">Become a member</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal" :class="{ 'is-active': isModalActive }" id="phone-lead" aria-label="modal" ref="leadModal">
            <div class="modal-background" @click="closeModal"></div>
            <div class="modal-content">
                <div class="box square has-text-centered">
                    <header>
                        <img :src="icon" alt="Elite Club Badge">
                        <h2 class="title is-3 is-size-5-mobile is-marginles">Save MORE on delivery cost when you join our Elite Club.</h2>
                        <p>
                            Get up to 50% discounts on pickup and delivery cost. <strong>Enter your Name and Phone number below</strong> to sign up.
                        </p>
                    </header>
                    <div class="content">
                        <form action="">
                            <div class="field">
                                <input type="text" class="input" v-model="name" placeholder="e.g Tola Hassan" tabindex="0">
                            </div>
                            <div class="field">
                                <input type="number" class="input" v-model="phone" placeholder="e.g 08012345678">
                            </div>
                            
                            <div class="field">
                                <button type="submit" class="button is-highlight is-fullwidth" @click.prevent="submitLead()">Sign me up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close" @click="closeModal"></button>
        </div>
    </span>
    
</template>

<script>
    export default {
        data(){
            return {
                phone: null,
                name: null,
                icon: window.push.images + '/award.svg?v=1',
                isModalActive: false,
            }
        },
        methods:{
            closeModal: function(){
                this.isModalActive = false;
            },
            openModal: function(){
                this.isModalActive = true;
                this.$refs.leadModal.setAttribute('tabindex', 0);
                this.$refs.leadModal.focus();
            },
            submitLead: function(){
                if ( this.phone === null || this.phone.length < 11 || this.phone.length > 15 ){
                    alert('Please enter a valid phone number');
                    return;
                }
                if ( this.name === null || this.name.length < 2 ){
                    alert('Please enter your name');
                    return;
                }
                let data = { phone_number: this.phone, name: this.name }
                axios.post('/lead', data).then( (response) => {
                    let res = response.data;
                    switch ( res.message ){
                        case "SAVED":
                            swal({ title: 'Congratulations!', text: 'You are now a member of our Elite Club.' });
                            break;
                        case "DUPLICATE":
                            swal({ title: 'Congratulations!', text: 'You are already a member of our elite club.' });
                            break;
                        case "INVALID_METHOD":
                            swal({ icon: 'error', title: 'Ooops!!!', text: 'Something went wrong, please try again later.' });
                            break;
                        default:
                            swal({ icon: 'error', title: 'Ooops!!!', text: 'Something went wrong, please try again later.' });
                            break;
                    }
                    this.phone = null;
                    this.name = null;
                    this.isModalActive = false;
                    return;
                }).catch( (error) => {
                    swal({ icon: 'error', title: 'Ooops!!!', text: 'Something went wrong, please try again later.' });
                    this.phone = null;
                    this.isModalActive = false;
                    return;
                });
            }
        },
        mounted() {
            
        }
    }
</script>
