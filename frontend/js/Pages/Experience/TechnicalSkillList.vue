<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
      <span>テクニカルスキル詳細</span>
    </v-card-title>
    <v-card-text class="pa-3 pt-5">
      TBD
    </v-card-text>
    <v-divider></v-divider>
    <v-card-actions>
      <v-row dense>
        <v-spacer></v-spacer>
        <v-col cols="4">
          <v-btn
            color="indigo lighten-1"
            block
            depressed
            outlined
            small
            @click="hide()"
          >
            閉じる
          </v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
export default {
  name: 'technical-skill-list',
  mixins: [ ViewBasic ],
  props:{
    technicalSkill: { type: Array, default: [] }
  },
  data() {
    return {
    }
  },
  methods: {
    hide() {
      this.$emit("hide")
    },
  }
}
</script>