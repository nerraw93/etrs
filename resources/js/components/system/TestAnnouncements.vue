<template>
    <section class="test-announcement">
        <div class="column">
            <form>
                <div class="columns">
                    <div class="column no-left-padding is-half">
                        <h2>Test/Services Announcements</h2>
                        <br>
                        <b-field label="Topic"
                            :type="{'is-danger': errors.has('topic')}"
                            :message="errors.first('topic')">
                            <b-input v-model="form.topic"
                                v-validate="rules.topic"
                                name="topic" />
                        </b-field>
                        <b-field label="Content"
                            :type="{'is-danger': errors.has('content')}"
                            :message="errors.first('content')">
                            <b-input v-model="form.content"
                                v-validate="rules.content"
                                name="content" type="textarea" />
                        </b-field>
                        <b-button type="app-primary"
                            class="is-pulled-right"
                            @click="add"
                            :loading="form.isBusy">
                            Save
                        </b-button>
                    </div>
                    <div class="column">
                        <h2>Availability of Post</h2>
                        <br>
                        <b-field label="Start/End">
                            <date-range-picker
                            v-model="dateRange"
                            @update="onDateSelected"
                            />
                        </b-field>
                    </div>
                </div>
            </form>
        </div>
        <div class="list-announcement">
            <List :announcements="announcementList"
                @next="next()"
                @prev="prev()" />
        </div>
    </section>
</template>
<script>
import moment from 'moment'
import { mapActions, mapState, mapGetters } from 'vuex'
import DateRangePicker from 'vue2-daterange-picker'
import validationMixin from '@/mixins/validation'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import List from '@/components/system/announcement/List.vue'

import 'vue2-daterange-picker/dist/lib/vue-daterange-picker.min.css'

import ErrorBagMixin from "@/mixins/ErrorBagMixin";

export default {

    components: {
        DateRangePicker,
        List
    },

    mixins: [validationMixin, ErrorBagMixin],

    mounted()
    {
        this.fetch({ page: this.page, count: 5 });
    },

    data() {
        let futureDate = new Date()
        futureDate.setDate(futureDate.getDate() + 5)

        return {
            page: 1,
            form: {
                topic: null,
                content: null,
                start: moment(new Date()).format('YYYY-MM-DD'),
                end: moment(futureDate).format('YYYY-MM-DD'),
                isBusy: false,
            },
            dateRange: {
                startDate: new Date(),
                endDate: futureDate
            },
            rules: {
                topic: {
                    required: true
                },
                content: {
                    required: true
                }
            },
            storeData: {}
        }
    },
    computed: {
        ...mapGetters('announcements', { announcementList: 'getAnnouncements' }),
    },
    methods: {
        ...mapActions('announcements', ['fetch']),

        /**
        * Create new announcement
        */
        add() {
            this.form.isBusy = true;
            const payload = {
                data: {
                    topic: this.form.topic,
                    content: this.form.content,
                    start_date: this.dateRange.startDate,
                    end_date: this.dateRange.endDate,
                }
            };

            this.$store.dispatch('announcements/store', payload)
                .then((data) => {
                    this.fetch({ page: this.page, count: 5 });
                    this.clearForm();
                    this.clearErrors();

                    this.successToast(data.message);
                })
                .catch((error) => {
                    this.catchError(error);
                    this.form.isBusy = false;
                });
        },
        onDateSelected() {
            this.form.start = moment(this.dateRange.startDate).format('YYYY-MM-DD')
            this.form.end = moment(this.dateRange.endDate).format('YYYY-MM-DD')
        },
        clearForm() {
            this.form.topic = '';
            this.form.content = '';
            this.form.isBusy = false;
        },
        async next() {
            this.page++
            await this.fetch({ page: this.page, count: 5 })
        },
        async prev() {
            this.page--
            await this.fetch({ page: this.page, count: 5 })
        }
    }
}
</script>
<style lang="scss" scoped>
@import "../../../sass/components/system/testAnnouncements.scss";
</style>
