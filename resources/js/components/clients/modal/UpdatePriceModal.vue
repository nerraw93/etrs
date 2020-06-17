<template>
    <b-modal :active.sync="open" has-modal-card>
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Update Service price</p>
            </header>
            <section class="modal-card-body">
                <b-field label="Price">
                    <b-input
                        type="double"
                        v-model="service.price"
                        required>
                    </b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-primary" @click="update">Update</button>
                <button class="button" type="button" @click="$emit('close')">Close</button>
            </footer>
        </div>
    </b-modal>
</template>

<script>
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    mixins: [
        ErrorBagMixin
    ],
    props: {
        open: {
            type: Boolean,
            required: true
        },
        service: {
            type: Object,
            required: false,
        },
    },

    data() {
        return {

        }
    },

    methods: {

        update()
        {
            this.$store.dispatch('clientServices/update', {service: this.service})
              .then((data) => {
                  this.successToast(data.message)
              })
              .catch((error) => {
                  this.catchError(error)
              })

              this.$emit('close');
        },
    },
}
</script>
