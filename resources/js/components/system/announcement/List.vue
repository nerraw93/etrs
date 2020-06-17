<template>
  <div class="announcements-list">
    <b-table
      :data="announcements && announcements.data"
      bordered
      striped
      hoverable
    >
      <template slot-scope="props">
        <b-table-column
          field="id"
          label="#"
          width="300"
        >
          {{ props.row.id }}
        </b-table-column>
        <b-table-column
          field="topic"
          label="Topic"
        >
          {{ props.row.data.topic }}
        </b-table-column>
        <b-table-column
          field="content"
          label="Content"
        >
          {{ props.row.data.content }}
        </b-table-column>
        <b-table-column
          field="startDate"
          label="Available From"
        >
          {{ props.row.data.start_date | stringDateFormat }}
        </b-table-column>
        <b-table-column
          field="endDate"
          label="Available To"
        >
          {{ props.row.data.end_date | stringDateFormat }}
        </b-table-column>
        <b-table-column
          field="actions"
          label="Actions"
          width="100"
        >

          <b-button size="is-small"
            type="app-primary"
            @click="openEditModal(props.row)"
          >
      			<b-icon icon="pencil" size="12" class="edit" />
          </b-button>
          <b-button size="is-small"
            type="app-danger"
            @click="openDeleteModal(props.row)">
               <b-icon icon="close" size="12" class="remove" />
          </b-button>
        </b-table-column>
      </template>
      <template slot="empty">
          <section class="section">
              <div class="content has-text-grey has-text-centered">
                  <p>
                      <b-icon
                          icon="emoticon-sad"
                          size="is-large">
                      </b-icon>
                  </p>
                  <p>Nothing here.</p>
              </div>
          </section>
      </template>
    </b-table>
    <div class="pagination-controls mt-2">
      <b-button
        type="is-danger"
        :disabled="getCurrentPage === 1"
        @click="$emit('prev')"
      >
        Previous
      </b-button>
      <b-button
        type="is-danger"
        :disabled="getCurrentPage === getLasPage"
        @click="$emit('next')"
      >
        Next
      </b-button>
      <UpdateAnnouncementModal :open="openEditAnnouncementModal"
        :announcement="announcementEdit"
        @close="openEditAnnouncementModal = false" />

        <confirmationmodal :data="deleteAnnouncement.modal"
            :open="deleteAnnouncement.modal.open"
            type="delete"
            @submit="deleteAnnouncementSubmit"
            @close="deleteAnnouncement.modal.open = false" />
    </div>
  </div>
</template>

<script>
import { stringDateFormat } from '@/filters/date'
import UpdateAnnouncementModal from '@/components/system/announcement/modal/UpdateAnnouncementModal.vue'
import confirmationmodal from '@/components/global/ConfirmationModal';
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification';
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    mixins: [
      ErrorBagMixin
    ],
    components: {
        UpdateAnnouncementModal,
        confirmationmodal
    },
    filters: {
        stringDateFormat
    },
    props: {
        announcements: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            open: false,
            announcementEdit: {},
            openEditAnnouncementModal: false,
            deleteAnnouncement: {
                id: '',
                modal: {
                    open: false,
                    title: 'Delete',
                    icon: 'archive',
                    message: `Are you sure you want to delete this announcement?`,
                }
            },
        }
    },
    computed: {
        getCurrentPage() {
            return this.announcements && this.announcements.current_page
        },
        getLasPage() {
            return this.announcements && this.announcements.last_page
        }
    },
    methods: {

        /**
         * Open edit modal
         * @param  {object} announcement
         * @return {void}
         */
        openEditModal(announcement)
        {
            this.openEditAnnouncementModal = true;
            this.announcementEdit = announcement;
        },

        /**
         * Open delete modal
         * @param  {object} announcement
         * @return {void}
         */
        openDeleteModal(announcement)
        {
            this.deleteAnnouncement.modal.open = true;
            this.deleteAnnouncement.id = announcement.data.batch_id;
        },

        /**
         * Delete announcement
         * @return {void}
         */
        deleteAnnouncementSubmit()
        {
            this.$store.dispatch('announcements/delete', this.deleteAnnouncement.id)
                .then((data) => {
                    this.successToast(data.message)
                    this.$store.dispatch('announcements/fetch', {page: 1, count: 5});
                    this.deleteAnnouncement.modal.open = false;

                })
                .catch((error) => {
                    this.deleteAnnouncement.modal.open = false;
                    this.catchError(error)
                });
        },
    }
}
</script>

<style lang="scss" scoped>
  .announcements-list {
    .edit {
      color: #32c5d2;
      cursor: pointer;
      > i:before {
       font-size: 12px;
      }
    }
    .remove {
      color: #e7505a;
      cursor: pointer;
    }
  }
</style>
