<template>
  <v-container fluid>
    <v-row no-gutters>
      <v-col cols="9">
        未実装 demo
      </v-col>
      <v-spacer></v-spacer>
      <v-col cols="auto">
        <v-row dense>
          <v-col>
            <calendar
              :schedules="schedules"
              :holidays="holidays"
              :width="300"
              :height="330"
            ></calendar>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
export default {
  name: 'dashboard',
  layout: Layout,
  mixins: [ ViewBasic ],
  props:{
    user_id: { type: String },
    holidays: { type: Object, default: {} },
    schedules: { type: Object, default: {} }
  },
  data() {
    return {
    }
  },
  methods: {
  }
}
</script>