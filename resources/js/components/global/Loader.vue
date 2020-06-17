<template>
    <b-loading :active.sync="isLoading"></b-loading>
</template>

<script>


/**
 * Modal component
 *
 * @author {goper}
 */
export default {

    computed: {
        isLoading() {
            return this.$store.getters['app/isLoading']
        }
    },
}
</script>
