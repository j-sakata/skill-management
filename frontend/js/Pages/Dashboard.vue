<template>
  <v-container fluid>
    <v-row no-gutters>
      <v-col cols="9">
        未実装 demo
      </v-col>
      <v-col cols="3">
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
        <v-row dense>
          <v-col>
            <v-card　outlined flat height='250'>
              <v-toolbar
                flat
                color="indigo lighten-1"
                dark
                dense
                height="35"
              >
                <v-toolbar-title>Geminiに質問</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-row dense>
                  <v-col>
                    <v-text-field
                      v-model="gemini.keysentence"
                      label=""
                      outlined
                      persistent-placeholder
                      dense
                      hide-details="auto"
                    ></v-text-field>
                  </v-col>
                </v-row>
                <v-row dense>
                  <v-col>
                    <v-card flat outlined>
                      {{ gemini.answer }}
                    </v-card>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
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
    holidays: { type: Array, default: [] },
    schedules: { type: Array, default: [] }
  },
  data() {
    return {
      gemini: {
        keysentence: 'こんにちは',
        answer: null
      }
      
    }
  },
  mounted() {
    this.searchGemini()
  },
  methods: {
    searchGemini() {
      this.$inertia.post('/dashboard/gemini', this.gemini, {
        onSuccess: page => {
          this.gemini.answer = page.props.gemini_answer;
        },
        onError: () => {
          this.actionFailure;
        },
        preserveState: true,
      })
    }
  }
}
</script>