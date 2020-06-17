<template>
  <div class="system">
    <Header />
    <section>
      <div class="container-fluid main-container">
        <div class="column is-full page-content">
          <div class="column portlet">
            <section>
              <h1 class="float-left">
                <b-icon icon="settings" />
                SYSTEM CONFIGURATIONS
              </h1>
              <div class="tabs float-right">
                <ul>
                  <li
                    :class="isActive('TestAnnouncements')"
                    @click="activeTab = 'TestAnnouncements'"
                  >
                    <a>Test Announcements</a>
                  </li>
                  <li
                    :class="isActive('PatientTypes')"
                    @click="activeTab = 'PatientTypes'"
                  >
                    <a>Patient Types</a>
                  </li>
                  <li 
                    :class="isActive('Dispatchers')"
                    @click="activeTab = 'Dispatchers'"
                  >
                    <a>Dispatchers</a>
                  </li>
                  <li
                    :class="isActive('Sources')"
                    @click="activeTab = 'Sources'"
                  >
                    <a>Sources</a>
                  </li>
                  <li
                    :class="isActive('IPWhitelist')"
                    @click="activeTab = 'IPWhitelist'"
                  >
                    <a>IP Whitelist</a>
                  </li>
                  <li 
                    :class="isActive('GlobalPrefix')"
                    @click="activeTab = 'GlobalPrefix'"
                  >
                    <a>Global Prefix</a>
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
import TestAnnouncements from '@/components/system/TestAnnouncements'
import PatientTypes from '@/components/system/PatientTypes'
import Dispatchers from '@/components/system/Dispatchers'
import Sources from '@/components/system/Sources'
import GlobalPrefix from '@/components/system/GlobalPrefix'
import IPWhitelist from '@/components/system/IPWhitelist'

const axios = require('axios');

export default {
  components: {
    Header,
    TestAnnouncements,
    PatientTypes,
    Dispatchers,
    Sources,
    GlobalPrefix,
    IPWhitelist
  },
  data() {
    return {
      activeTab: 'TestAnnouncements'
    }
  },
  computed: {

  },

  mounted()
  {

  },

  methods: {
    isActive(currentComponent) {
      if (this.activeTab === currentComponent) {
        return 'system-active'
      }
    }
  }
}
</script>
<style lang="scss" scoped>
  @import "../../sass/pages/system.scss";
</style>
