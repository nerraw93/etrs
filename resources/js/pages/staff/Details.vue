<template>
  <div class="staff-details">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column is-full no-left-padding">
            <router-link to="/staff">
              <b-button
                type="is-danger"
                icon-left="keyboard-backspace"
              >
                Back
              </b-button>
            </router-link>
            <div class="column portlet mt-4">
              <section>
                <h1>STAFF INFORMATION</h1>
                <hr>
                <form @submit.prevent="submit">
                  <div class="column mb-5">
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="First Name"
                          expanded
                        >
                          <p>{{ staff.user.first_name }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Last Name"
                          expanded
                        >
                          <p>{{ staff.user.last_name }}</p>
                        </b-field>
                      </div>
                    </div>
                  </div>
                    <h1>
                      CONTACT INFORMATION
                    </h1>
                    <hr>
                    <div class="column">
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="Email"
                          expanded
                        >
                          <p>{{ staff.user.email }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Username"
                          expanded
                        >
                          <p>{{ staff.user.username }}</p>
                        </b-field>
                      </div>
                    </div>
                  </div>
                </form>
              </section>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import { mapActions } from 'vuex'
import Header from '@/components/global/Header'
import { NotificationProgrammatic as Notification } from 'buefy/dist/components/notification'

export default {
  components: {
    Header
  },
  data() {
    return {
      staff: {}
    }
  },
  computed: {
  },
  methods: {
    isActive(currentComponent) {
      if (this.activeTab === currentComponent) {
        return 'details-active'
      }
    },
    
    fetchDetails()
    {
      const payload = {
        id: this.$route.params.code
      }
      
      this.$store.dispatch('staff/details', {data: payload})
        .then((data) => {
          this.staff = data.staff;
        })
        .catch((err) => {
        });
    },
  },
  
  mounted()
  {
    this.fetchDetails();
  }
}
</script>
<style lang="scss" scoped>
  @import "../../../sass/pages/staff/details.scss";
</style>
