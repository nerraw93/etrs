<template>
    <Modal title="Update Announcement"
        @close="$emit('close')"
        :isOpen="open">
        <!-- Body -->
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Topic</label>
                    <div class="control">
                        <input class="input" type="text"
                            v-model="form.topic">
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Content</label>
                    <div class="control">
                        <textarea class="textarea" v-model="form.content"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Availability of Post</label>
                    <div class="control update-modal">
                        <date-range-picker v-model="dateRange"
                            opens="right"
                            :ranges=false
                            :min-date="new Date()"
                            @update="changeDate" />
                    </div>
                </div>
            </div>
        </div>

        <span slot="footer">
            <button class="button is-info" @click="update">Update</button>
            <button class="button" @click="$emit('close')">Cancel</button>
        </span>
    </Modal>
</template>
<script>
import Modal from "@components/global/Modal";
import DateRangePicker from 'vue2-daterange-picker';
import {isEmpty} from "lodash";
import moment from "moment";
import 'vue2-daterange-picker/dist/lib/vue-daterange-picker.min.css';
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification';
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    mixins: [
      ErrorBagMixin
    ],

    components: {
        Modal,
        DateRangePicker
    },

    props: {
        open: {
            type: Boolean,
            required: true
        },
        announcement: {
            type: Object,
            required: true
        }
    },

    watch: {
      	announcement: function(announcement) {
            if (!isEmpty(announcement)) {
                this.form.id = announcement.data.batch_id;
                this.form.topic = announcement.data.topic;
                this.form.content = announcement.data.content;
                this.form.start_date = announcement.data.start_date;
                this.form.end_date = announcement.data.end_date;

                this.dateRange.startDate = announcement.data.start_date;
                this.dateRange.endDate = announcement.data.end_date;
            }
        }
    },

    data()
    {
        return {
            form: {
                topic: '',
                content: '',
                start_date: '',
                end_date: '',
                id: '',
            },
            dateRange: {
                startDate: '',
                endDate: '',
            },
            isLoading: false,
        };
    },

    methods: {

        /**
         * Update announcement
         * @return {void}
         */
        update()
        {
            this.$store.dispatch('announcements/update', this.form)
                .then((data) => {
                    this.successToast(data.message)
                    this.fetch();
                    this.$emit('close');

                })
                .catch((error) => {
                    this.catchError(error)
                });
        },

        fetch()
        {
            this.$store.dispatch('announcements/fetch', {page: 1, count: 5});
        },

        changeDate()
        {
            this.form.start_date = moment(this.dateRange.startDate).format('YYYY-MM-DD');
            this.form.end_date = moment(this.dateRange.endDate).format('YYYY-MM-DD');
        },
    },

    mounted() {

    }
}
</script>
<style lang="scss" scoped>

</style>
