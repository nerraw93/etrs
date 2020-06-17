<template>
    <b-modal class="delete-modal" :class="modalType"
        :active.sync="open"
        :can-cancel="false"
        has-modal-card>
        <div class="card">
            <header class="modal-card-head">
                <p class="modal-card-title">
                    <b-icon :icon="data.icon" /> {{data.title}}
                </p>
            </header>
            <div class="modal-card-body">
                <div class="column" v-text="data.message">

                </div>
                <div class="column">
                    <div class="modal-actions">
                        <b-button
                        class="float-right"
                        :type="cancelButton"
                        @click="$emit('close')"
                        >
                        Cancel
                        </b-button>
                    <b-button class="float-right mr-2"
                        :type="submitButton"
                        @click="$emit('submit')">
                        Yes
                    </b-button>
                    </div>
                </div>
            </div>
        </div>
    </b-modal>
</template>
<script>
export default {
    props: {
        open: {
            type: Boolean,
            required: true
        },
        data: {
            type: Object,
            required: true
        },
        type: {
            type: String,
            required: false,
            default: 'create'
        }
    },

    computed: {

        submitButton()
        {
            let type = 'is-success';
            if (this.type == 'delete')
                type = 'is-danger';

            return type;
        },

        cancelButton()
        {
            return 'is-light';
        },

        modalType()
        {
            let type = '';
            if (this.type == 'delete')
                return {'is-delete-modal': true};
        }
    }
}
</script>
<style lang="scss" scoped>
    @import "../../../sass/components/clients/deleteClientModal.scss";
</style>
