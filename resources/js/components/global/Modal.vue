<template>
    <div class="modal" :class="{'is-active': isOpen }">
        <div class="modal-background"></div>
        <div class="modal-card" :class="{'is-wider': isWider, 'is-longer': isLonger}">
            <header class="modal-card-head">
                <p class="modal-card-title" v-text="title"></p>
                <button class="delete" aria-label="close" @click="$emit('close')"></button>
            </header>
            <section class="modal-card-body">
                <slot />
            </section>
            <footer class="modal-card-foot has-justify-flex-end">
                <slot name="footer"></slot>
            </footer>
        </div>
    </div>
</template>

<script>


/**
 * Modal component
 *
 * @author {goper}
 */
export default {

    props: {
        title: {
            type: String,
            required: true,
        },
        isOpen: {
            type: Boolean,
            default: true,
        },
        isWider: {
            type: Boolean,
            default: false,
        },
        isLonger: {
            type: Boolean,
            default: false,
        }
    },
}
</script>
