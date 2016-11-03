Vue.component('add-payment-method', {
    props: ['user', 'customer'],

    data() {
        return {
            showCardForm: false,
            updatingCreditCard: false,
            form: new IfcForm({
                stripe_token: '',
                address: '',
                address_line_2: '',
                city: '',
                state: '',
                zip: '',
                country: 'US'
            }),

            addCardForm: new IfcForm({
                name: '',
                number: '',
                cvc: '',
                month: '',
                year: '',
                zip: ''
            })
        }
    },

    mounted() {
        if (this.isCreditCardMissing) {
            this.showCardForm = true;
        }

        Stripe.setPublishableKey(Ifc.stripe_key);

        this.initializeBillingAddress();
    },

    created() {

    },

    computed: {
        isCreditCardMissing() {
            return (_.isUndefined(this.customer.card_last_four) || _.isEmpty(this.customer.card_last_four));
        },

        isCreditCardFormShowing() {
            return this.showCardForm;
        },

        buttonText() {
            return this.updatingCard ? 'Update Card' : 'Add Card';
        },

        alertText() {
            return this.isCreditCardMissing ? 'Your card has been updated' : 'Your card has been added';
        },

        /**
         * Determines whether
         *
         * @returns boolean
         */
        updatingCard() {
            return this.updatingCreditCard;
        },

        disablePlaceOrderButton() {
            return (!this.customer.card_last_four) || this.showCardForm
        }
    },

    methods: {
        /**
         * Initialize the billing address form for the billable entity.
         */
        initializeBillingAddress() {

            this.form.address = '';
            this.form.address_line_2 = '';
            this.form.city = '';
            this.form.state = '';
            this.form.zip = '';
            this.form.country = 'US';
        },

        /**
         * Add new card
         */
        addCard() {
            this.form.busy = true;
            this.form.errors.forget();
            this.form.successful = false;
            this.addCardForm.errors.forget();

            // Here we will build out the payload to send to Stripe to obtain a card token so
            // we can create the actual subscription. We will build out this data that has
            // this credit card number, CVC, etc. and exchange it for a secure token ID.
            const payload = {
                name: this.addCardForm.name,
                number: this.addCardForm.number,
                cvc: this.addCardForm.cvc,
                exp_month: this.addCardForm.month,
                exp_year: this.addCardForm.year,
                address_line1: this.form.address,
                address_line2: this.form.address_line_2,
                address_city: this.form.city,
                address_state: this.form.state,
                address_zip: this.form.zip,
                address_country: this.form.country,
            };

            // Once we have the Stripe payload we'll send it off to Stripe and obtain a token
            // which we will send to the server to update this payment method. If there is
            // an error we will display that back out to the user for their information.
            Stripe.card.createToken(payload, (status, response) => {
                if (response.error) {
                    this.addCardForm.errors.set({number: [
                        response.error.message
                    ]});

                    this.form.busy = false;
                } else {
                    this.sendCardToServer(response.id);
                }
            });
        },

        /**
         * Send the credit card update information to the server.
         */
        sendCardToServer(token) {
            this.form.stripe_token = token;

            if (! this.customer.stripe_id) {
                Ifc.post('/payment-methods', this.form)
                    .then(() => {
                        this.showCardForm = false;

                        Bus.$emit('updateUser');

                        this.clearForm();
                    }, response => {
                        console.log(response);
                    });
            } else {
                Ifc.put('/payment-methods', this.form)
                    .then(() => {
                        Bus.$emit('updateUser');

                        this.clearForm();

                        this.updatingCreditCard = false;

                        this.toggleCardForm();
                    }, response => {
                        console.log(response);
                    });
            }
        },

        clearForm() {
            //this.addCardForm.name = '';
            this.addCardForm.number = '';
            this.addCardForm.cvc = '';
            this.addCardForm.month = '';
            this.addCardForm.year = '';
        },

        updateCard() {
            this.updatingCreditCard = true;

            this.toggleCardForm();
        },

        toggleCardForm() {
            this.showCardForm = !this.showCardForm;
        },

        cancelCardUpdate() {
            this.updatingCreditCard = false;

            this.toggleCardForm();
        }
    }
});