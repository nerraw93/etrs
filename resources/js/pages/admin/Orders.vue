<template>
  <div class="orders">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column">
            <section>
              <h1 class="float-left">
                <b-icon icon="stethoscope" />
                BATCH ORDERS
              </h1>
              <div class="tabs float-right">
                <b-field
                  class="show-field"
                  horizontal
                  label="Show:"
                >
                  <b-select
                    v-model="selectedPageCount"
                    class="control"
                    placeholder="Select results"
                    @input="filterPageCount(selectedPageCount)"
                  >
                    <option
                      v-for="option in pageCount"
                      :value="option.value"
                      :key="option.value"
                    >
                      {{ option.label }}
                    </option>
                  </b-select>
                </b-field>
                <b-field
                  horizontal
                  label="Filter:"
                >
                  <b-select
                    v-model="selectedStatus"
                    placeholder="Select a filter"
                    @input="filterStatus(selectedStatus)"
                  >
                    <option
                      v-for="option in statuses"
                      :value="option.value"
                      :key="option.value"
                    >
                      {{ option.label }}
                    </option>
                  </b-select>
                </b-field>
              </div>
              <div class="clearfix" />
              <div class="column portlet">
                  <component :is="activeTab"
                    :orders="orders"
                    :fetch-by-search="fetchBySearch"
                    :page="page"
                    @paginateChange="paginateChange"
                    @search="search"
                    @fetch="fetch" />
              </div>
            </section>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Header from '@/components/global/Header'
import BatchOrders from '@/components/orders/BatchOrders'
import debounce from 'lodash.debounce'

/**
 * Admin Batch orders
 * @type {Object}
 */
export default {
    components: {
        Header,
        BatchOrders
    },
    data() {
        return {
            activeTab: 'BatchOrders',
            searchVal: '',
            page: 1,
            searchpage: 1,
            fetchBySearch: false,
            selectedStatus: 1,
            statuses: [
                { "value": 1, "label": "Confirmed" },
                { "value": 2, "label": "Accomplished" },
            ],
            selectedPageCount: 10,
            pageCount: [
                { "value": 10, "label": "10 results" },
                { "value": 30, "label": "30 results" },
                { "value": 50, "label": "50 results" },
                { "value": 100, "label": "100 results" },
                { "value": "", "label": "All results" },
            ],
        }
    },
    computed: {
        orders()
        {
            return this.$store.getters['adminBatchOrders/items'];
        }
    },
    methods: {
        async fetch()
        {
            const payload = {
                page: this.fetchBySearch ? this.searchpage : this.page,
                count: this.selectedPageCount,
                status: this.selectedStatus,
                search: this.searchVal,
            }

            await this.$store.dispatch('adminBatchOrders/fetch', {payload: payload})
            .then(({data}) => {
            })
            .catch((err) => {
            });
        },

        paginateChange(page) {
            if (this.fetchBySearch) {
              this.searchpage = page
            } else {
              this.page = page
            }
            this.fetch()
        },

        filterStatus: debounce(async function(value) {
            this.page = 1
            this.selectedStatus = value
            await this.fetch()
        }, 500),

        filterPageCount: debounce(async function(value) {
            this.page = 1
            this.selectedPageCount = value
            await this.fetch()
        }, 500),

        search: debounce(async function(value) {
            if (value) {
              this.searchVal = value
              this.fetchBySearch = true
            } else {
              this.searchVal = ''
              this.fetchBySearch = false
              this.searchpage = 1
            }

            await this.fetch()
        }, 500),

    },
    mounted()
    {
        this.fetch();
    }
}
</script>
<style lang="scss" scoped>
  @import "@sass/pages/_orders.scss";
</style>
