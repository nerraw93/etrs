<template>
  <b-table
    :data="clients"
    bordered
    striped
    hoverable
  >
    <template slot-scope="props">
      <b-table-column
        field="client"
        label="Client"
        width="300"
      >
        {{ props.row.client }}
      </b-table-column>
      <b-table-column
        field="price"
        label="Price"
        width="300"
      >
        {{ 'P ' + props.row.price }}
      </b-table-column>
      <b-table-column
        label="Actions"
        width="300"
      >
        <b-button type="app-primary" @click="$emit('edit', props.row)">
          Edit
        </b-button>
        <b-button type="is-danger" @click="$emit('delete', props.row)">
          Archive
        </b-button>
      </b-table-column>
    </template>
  </b-table>
</template>
<script>
export default {
  props: {
    clients: {
      type: Array,
      required: true
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/components/services/clientList.scss";
</style>
