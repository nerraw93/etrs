<template>
  <section class="clients-list">
    <div class="header-portlet">
      <h1> <b-icon icon="account-star" /> CLIENTS LIST</h1>
    </div>
    <b-field grouped>
      <b-input
        v-model="form.search"
        placeholder="Search Client"
        @input="$emit('search', form.search)"
      />
    </b-field>
    <b-table
      :data="clients"
      bordered
      striped
      hoverable
    >
      <template slot-scope="props">
        <b-table-column
          field="username"
          label="Client"
        >
          <router-link
            :to="{ name: 'client_details', params: { code: props.row.code } }"
            class="client-link"
          >
            {{ props.row.username }}
          </router-link>
        </b-table-column>
        <b-table-column
          field="name"
          label="Name"
          width="500"
        >
          <a
            href="javascript:;"
            @click="$emit('editMode', props.row)"
            class="client-link"
          >
            {{ props.row.first_name }} {{ props.row.last_name }}
          </a>
        </b-table-column>
        <b-table-column
          field="created_at"
          label="Date Added"
        >
          <span>{{ getCreatedAtDate(props.row.created_at)}}</span>
          <small>({{ props.row.created_at | relativeTime }})</small>
        </b-table-column>
        <b-table-column
          field="actions"
          label="Actions"
        >
          <SendResetButton :user="props.row" />
          <b-button
            type="is-danger"
            @click="openDeleteModal(props.row.id, props.row.username)"
          >
            Archive
          </b-button>
        </b-table-column>
      </template>
    </b-table>
    <div class="pagination-controls mt-2">
      <b-button
        type="is-danger"
        :disabled="current === 1"
        @click="$emit('prev')"
      >
        Previous
      </b-button>
      <b-button
        type="is-danger"
        :disabled="current === getLastPage"
        @click="$emit('next')"
      >
        Next
      </b-button>
    </div>
    <DeleteClientModal
      :open="open"
      :modal-username="modalUsername"
      @archive="archive"
      @close="open = false"
    />
  </section>
</template>
<script>
import moment from 'moment';
import { mapGetters } from 'vuex';
import { relativeTime } from '@/filters/date';
import SendResetButton from "@components/global/SendResetPasswordButton";
import DeleteClientModal from "@components/clients/DeleteClientModal";

export default {

    components: {
        DeleteClientModal,
        SendResetButton,
    },

    filters: {
        relativeTime
    },
    props: {
        clients: {
            type: Array,
            required: true
        },
        current: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            form: {
                search: ''
            },
            open: false,
            userToArchive: '',
            modalUsername: ''
        }
    },
    computed: {
        ...mapGetters('client', ['getLastPage'])
    },
    methods: {
        openDeleteModal(id, username) {
            this.userToArchive = id
            this.modalUsername = username
            this.open = true
        },
        archive() {
            this.$emit('archive', this.userToArchive)
            this.open = false
        },

        getCreatedAtDate(date) {
            return moment(date).format('MMM DD, YYYY');
        }
    }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/clients/list.scss";
</style>
