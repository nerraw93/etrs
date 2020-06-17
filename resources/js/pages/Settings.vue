<template>
  <div class="setting">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column portlet">
            <section>
              <h1 class="float-left">
                <b-icon icon="server" />
                SETTINGS
              </h1>
              <div class="tabs float-right">
                <ul>
                  <li
                    :class="isActive('Details')"
                    @click="activeTab = 'Details'"
                  >
                    <a>Account Details</a>
                  </li>
                  <li
                    :class="isActive('Password')"
                    @click="activeTab = 'Password'"
                  >
                    <a>Password</a>
                  </li>
                  <li
                    :class="isActive('MyClinicians')" 
                    @click="activeTab = 'MyClinicians'"
                  >
                    <a>My Clinicians</a>
                  </li>
                </ul>
              </div>
              <div class="clearfix" />
              <component
                :is="activeTab"
              />
            </section>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import Header from '@/components/global/Header'
import Details from '@/components/settings/Details'
import Password from '@/components/settings/Password'
import MyClinicians from '@/components/settings/MyClinicians'

export default {
  components: {
    Header,
    Details,
    Password,
    MyClinicians
  },
  data() {
    return {
      activeTab: 'Details'
    }
  },
  computed: {

  },
  methods: {
    isActive(currentComponent) {
      if (this.activeTab === currentComponent) {
        return 'setting-active'
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../sass/pages/settings.scss";
</style>
