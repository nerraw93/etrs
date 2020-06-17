<template>
  <section class="staff-list">
    <div class="header-portlet">
      <h1> <b-icon icon="account-group" /> STAFF LIST</h1>
    </div>
    <b-field>
      <b-input
        v-model="form.search"
        placeholder="Search Staff"
        expanded
        @input="$emit('search', form.search)"
      />
    </b-field>
    <p v-if="staff.data.length === 0" class="text-center pt-5 pr-5 pl-5 pb-5">No data available.</p>
    <b-table
      v-else
      :data="staff.data"
      bordered
      striped
      hoverable
    >
      <template slot-scope="props">
        <b-table-column
          field="username"
          label="Staff"
        >
          <router-link
            :to="{ name: 'staff_details', params: { code: props.row.id } }"
            class="staff-link"
          >
            {{ props.row.user ? props.row.user.username : props.row.username }}
          </router-link>
        </b-table-column>
        <b-table-column
          field="created_at"
          label="Date Added"
          width="700"
        >
          {{ props.row.created_at | relativeTime }}
        </b-table-column>
        <b-table-column
          field="actions"
          label="Actions"
        >
          <b-button
            type="is-success"
            @click="openEditModal(props.row)"
          >
            Edit
          </b-button>
          <b-button
            type="is-danger"
            @click="archive(props.row.id)"
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
        :disabled="current === staff.last_page"
        @click="$emit('next')"
      >
        Next
      </b-button>
    </div>
    <EditStaffModal
      v-if="openEdit"
      :staff="staffToEdit"
      :open="openEdit"
      @close="openEdit = false"
      @update="update"
    />
    <DeleteStaffModal
      :open="openDelete"
      :modal-username="modalUsername"
      @archive="archive"
      @close="openDelete = false"
    />
  </section>
</template>
<script>
import { mapGetters } from 'vuex'
import { relativeTime } from '@/filters/date'

export default {
  components: {
    EditStaffModal: () => import('@/components/staff/EditStaffModal'),
    DeleteStaffModal: () => import('@/components/staff/DeleteStaffModal')
  },
  filters: {
    relativeTime
  },
  props: {
    staff: {
      type: Object,
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
      openEdit: false,
      openDelete: false,
      userToArchive: '',
      modalUsername: ''
    }
  },
  computed: {

  },
  methods: {
    openEditModal(staff) {
      this.openEdit = true
      this.staffToEdit = staff
    },
    archive(id) {
      this.$emit('archive', id)
      this.openDelete = false
    },
    update(payload) {
      this.openEdit = false
      this.$emit('update', payload)
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/staff/list.scss";
</style>
