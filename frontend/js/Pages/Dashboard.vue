<template>
  <v-container fluid>
    <v-row no-gutters>
      <v-col cols="9">
        <calendar
          :schedules="schedules"
          :holidays="holidays"
        ></calendar>
      </v-col>
      <v-col cols="3">
        未実装 demo
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