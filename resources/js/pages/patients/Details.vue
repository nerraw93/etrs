<template>
  <div class="patient-details">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column is-full no-left-padding">
            <router-link to="/patients">
              <b-button
                type="is-danger"
                icon-left="keyboard-backspace"
              >
                Back
              </b-button>
            </router-link>
            <div class="column portlet mt-4">
              <section v-if="Object.keys(patient).length > 0">
                <h1>PATIENT INFORMATION</h1>
                <hr>
                <form @submit.prevent="submit">
                  <div class="column mb-5">
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="First Name"
                          expanded
                        >
                          <p>{{ patient.first_name }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Middle Name"
                          expanded
                        >
                          <p>{{ patient.middle_name }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Last Name"
                          expanded
                        >
                          <p>{{ patient.last_name }}</p>
                        </b-field>
                      </div>
                    </div>
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="Gender"
                          expanded
                        >
                          <p>{{ patient.gender }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Birth Date"
                          expanded
                        >
                          <p>{{ patient.birth_date }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="HPD Patient ID"
                          expanded
                        >
                          <p>{{ patient.client_custom_id }}</p>
                        </b-field>
                      </div>
                    </div>
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="ID / Passport No."
                          expanded
                        >
                          <p>{{ patient.passport_number }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Blood Group"
                          expanded
                        >
                          <p>{{ patient.blood_type }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Rh"
                          expanded
                        >
                          <p>{{ patient.rh }}</p>
                        </b-field>
                      </div>
                    </div>
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="Citizen"
                          expanded
                        >
                          <p>{{ patient.citizen }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Mother's Maiden Name"
                          expanded
                        >
                          <p>{{ patient.mothers_maiden_name }}</p>
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
                          <p>{{ patient.email }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Address"
                          expanded
                        >
                          <p>{{ patient.address }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="City/Municipality"
                          expanded
                        >
                          <p>{{ patient.city }}</p>
                        </b-field>
                      </div>
                    </div>
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="Telephone No."
                          expanded
                        >
                          <p>{{ patient.telephone_number }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Fax No."
                          expanded  
                        >
                          <p>{{ patient.fax_number }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Mobile"
                          expanded
                        >
                          <p>{{ patient.mobile_number }}</p>
                        </b-field>
                      </div>
                    </div>
                    <div class="columns">
                      <div class="column is-one-third">
                        <b-field
                          label="HMO Provider"
                          expanded
                        >
                          <p>{{ patient.hmo_card }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="HPD Patient ID"
                          expanded
                        >
                          <p>{{ patient.hpo_patient_id }}</p>
                        </b-field>
                      </div>
                      <div class="column is-one-third">
                        <b-field
                          label="Registration Date"
                          expanded
                        >
                          <p>{{ patient.created_at }}</p>
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
      patient: {}
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
      
      this.$store.dispatch('patients/details', {data: payload})
        .then((data) => {
          this.patient = data.patient;
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
  @import "../../../sass/pages/patients/details.scss";
</style>
