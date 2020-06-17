<template>
    <div class="columns">
        <div class="column">
            <b-table :data="announcements" bordered striped hoverable
                :row-class="(row, index) => (row.read_at === null || row.read_at == '') && 'has-primary-background'">
                <template slot-scope="props">
                    <b-table-column field="topic" label="Topic">
                        <strong>{{ props.row.data.topic }}</strong>
                    </b-table-column>
                    <b-table-column field="content" label="Content">
                        {{ props.row.data.content }}
                    </b-table-column>
                    <b-table-column field="read_at" label="Status">
                        {{ getStatus(props.row) }}
                    </b-table-column>
                    <b-table-column field="created_at" label="Created At" width="140">
                        <small>{{ parseDate(props.row.created_at) }}</small>
                    </b-table-column>
                </template>
                <template slot="empty">
                    <section class="section">
                        <div class="content has-text-grey has-text-centered">
                            <p>
                                <b-icon icon="emoticon-sad" size="is-large" />
                            </p>
                            <p>No announcements for now.</p>
                        </div>
                    </section>
                </template>
            </b-table>
        </div>
    </div>
</template>

<script>
import moment from "moment";

export default {

    props: {

    },

    computed: {

        announcements()
        {
            return this.$store.getters['userAnnouncement/allAnnouncements'];
        },
    },

    data() {
        return {

        }
    },

    methods: {

        parseDate(date)
        {
            return moment(date).format('LL');
        },

        getStatus(announcement)
        {
            let status = 'Read';

            if (announcement.read_at === null || announcement.read_at == '')
                status = 'Unread';

            return status;
        },
    },

    mounted()
    {

    }
}
</script>
