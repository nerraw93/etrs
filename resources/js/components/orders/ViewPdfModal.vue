<template>
    <Modal title="Batch Order Summary"
        @close="$emit('close')"
        isWider isLonger
        :isOpen="open">
        <!-- Body -->
        <div class="columns" style="height: 100%">
            <div class="column">
                <iframe :src="source"
                    class="is-full" style="width: 100%; height: 100%"></iframe>
            </div>
        </div>
        <span slot="footer">
            <button class="button" @click="$emit('close')">Close</button>
        </span>
    </Modal>
</template>
<script>
import Modal from "@components/global/Modal";

export default {

    components: {
        Modal,
    },

    props: {
        open: {
            type: Boolean,
            required: true
        },
        source: {
            type: String,
            required: false,
            default: ''
        }
    },
}
</script>
<style lang="scss" scoped>
    @import "../../../sass/components/orders/batchOrders.scss";
</style>
