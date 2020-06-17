<template>
  <div class="staff">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column is-full no-left-padding">
            <b-button
              v-if="!addMode"
              type="app-primary"
              icon-right="plus"
              @click="addMode = true"
            >
              Add Staff
            </b-button>
          </div>
          <AddStaff
            v-if="addMode"
            @hide="addMode = false"
            @success="fetch"
          />
          <div
            class="column portlet"
            :class="addMode ? 'mt-4' : null"
          >
            <List
              :staff="staff"
              :current="getCurrentPage"
              @archive="archive"
              @next="next()"
              @prev="prev()"
              @update="submitEdit"
              @search="search"
            />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { Dialog } from 'buefy/dist/components/dialog'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'
import debounce from 'lodash.debounce'
import Header from '@/components/global/Header'
import List from '@/components/staff/List'
import AddStaff from '@/components/staff/AddStaff'
import ErrorBagMixin from "@/mixins/ErrorBagMixin"

export default {
    mixins: [
        ErrorBagMixin
    ],
    components: {
        Header,
        List,
        AddStaff
    },
    data() {
        return {
            addMode: false,
            page: 1,
            searchPage: 1,
            fetchBySearch: false,
            searchVal: ''
        }
    },
    computed: {
        staff() {
            return this.$store.getters['staff/items'];
        },
        getCurrentPage() {
            if (this.fetchBySearch && this.searchVal) {
                return this.searchPage;
            } else {
                return this.page;
            }
        }
    },
    methods: {
        /**
        * Create new patient
        */
        add() {
            this.$store.dispatch('staff/store', {data: this.storeData})
            .then((data) => {
                this.successToast(data.message)

                this.fetch();
            })
            .catch((error) => {
                this.catchError(error)
            });
        },

        /**
        * Update patient
        *
        * @return {[type]} [description]
        */
        submitEdit(editData) {
            this.$store.dispatch('staff/update', {data: editData})
            .then((data) => {
                this.successToast(data.message)
                this.resetEditState();
                this.fetch();
            })
            .catch((error) => {
                this.catchError(error);
                this.resetEditState();
            });
        },

        archive(id) {
            Dialog.confirm({
                title: 'Deleting staff',
                message: 'Are you sure you want to <b>delete</b>? This action cannot be undone.',
                confirmText: 'Confirm',
                type: 'is-danger',
                hasIcon: true,
                onConfirm: () => this.delete(id)
            })
        },

        delete(id)
        {
            this.$store.dispatch('staff/delete', {data: id})
            .then((data) => {
                this.successToast(data.message);
                this.fetch();
            })
            .catch((error) => {
                this.catchError(error);
            })
        },

        /**
        * Fetch items
        *
        * @author goper
        * @return {void}
        */
        async fetch() {

            if (this.fetchBySearch && this.searchVal) {
                const payload = {
                    page: this.searchPage,
                    key: this.searchVal
                }

                await this.$store.dispatch('staff/search', {payload: payload})
                .then(({data}) => {
                })
                .catch((err) => {

                });
            } else {
                const payload = {
                    page: this.page
                }

                await this.$store.dispatch('staff/fetch', {payload: payload})
                .then(({data}) => {
                })
                .catch((err) => {

                });
            }
        },

        async next() {
            if (this.fetchBySearch) {
                this.searchPage++
            } else {
                this.page++
            }

            await this.fetch()
        },
        async prev() {
            if (this.fetchBySearch) {
                this.searchPage--
            } else {
                this.page--
            }

            await this.fetch()
        },

        search: debounce(async function(value) {
            if (value) {
                this.fetchBySearch = true
                this.searchVal = value
                await this.fetch()
            } else {
                this.fetchBySearch = false
                this.searchPage = 1
                this.searchVal = ''
                await this.fetch()
            }
        }, 500),

        /**
        * Editing state
        *
        * @param  {object} patient
        * @return {[type]}
        */
        editing(value)
        {
            this.isEdit = true;
            //this.editData = patient;
        },

        /**
        * Cancel editing state
        *
        * @return {[void]}
        */
        resetEditState()
        {
            this.isEdit = false;
            this.editData = {};
        },
    },

    /**
    * Mounted hook
    * @return {[void]}
    */
    mounted()
    {
        // Fetch patients
        this.fetch();
    },
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/pages/staff/index.scss";
</style>
