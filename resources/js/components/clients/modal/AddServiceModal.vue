<template>
    <b-modal :active.sync="open" has-modal-card>
        <div class="modal-card" style="width: auto">
            <header class="modal-card-head">
                <p class="modal-card-title">Encode Service price</p>
            </header>
            <section class="modal-card-body">
                <b-field :label="`Set price for ${service.name}`"
                    v-for="service in services" :key="service.id">
                    <b-input
                        type="double"
                        v-model="service.price"
                        required>
                    </b-input>
                </b-field>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-primary" @click="add">Add</button>
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
        services: {
            type: Array,
            required: false,
        },
        sourceId: {
            type: Number,
            required: true,
        }
    },

    watch: {
        open: function(newVal, oldVal) { // watch it
            if (newVal) {
                this.assignDefaultCost();
            }
        }
    },

    data() {
        return {
            price: 0,
        }
    },

    methods: {

        /**
         * Set default cost
         * @return {void}
         */
        assignDefaultCost()
        {
            for (let index of this.services.keys()) {
                this.$set(this.services[index], 'price', this.services[index].default_cost);
            }
        },

        /**
         * Store!
         */
        add()
        {
            this.$store.dispatch('clientServices/store', {
                services: this.services,
                sourceId: this.sourceId,
            })
              .then((data) => {
                  this.successToast(data.message)

                  this.$emit('close', true);
              })
              .catch((error) => {
                  this.catchError(error)
              });
        },
    },
}
</script>
