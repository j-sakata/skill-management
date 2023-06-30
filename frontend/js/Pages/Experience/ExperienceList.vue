<template>
  <v-container fluid>
    <v-row no-gutters>
      <v-col cols="6">
        <v-row no-gutters class="pa-4 pb-0">
          <v-col cols="9">
            <v-text-field
              v-model="keyword"
              label="キーワード"
              outlined
              persistent-placeholder
              clearable
              dense
              hide-details="auto"
            ></v-text-field>
          </v-col>
          <v-spacer></v-spacer>
          <v-col cols="2">
            <v-btn dense block @click="search">検索</v-btn>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="6">
        <v-row no-gutters class="pa-4 pb-0">
          <v-spacer></v-spacer>
          <v-col cols="2">
            <v-btn dense block @click="modal.register = true">新規作成</v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col cols="6" class="pa-5">
        <v-row no-gutters>
          <v-col class="pa-0 ma-0">
            <v-data-table
              :headers="experienceHeaders"
              :items="listItems"
              class="elevation-1"
              @click:row="select"
              dense
              height=230
            >
              <template v-slot:items="props">
                <td>{{ props.item.project_name }}</td>
                <td>{{ props.item.industry }}</td>
                <td>{{ props.item.company_name }}</td>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col cols="8" class="ma-0 pa-0">
            <v-card outlined class="mt-6" height="230">
              <v-toolbar
                flat
                color="indigo lighten-1"
                dark
                dense
                height="35"
              >
                <v-toolbar-title>テクニカルスキル</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                  color="indigo darken-2"
                  dark
                  x-small
                  @click="addDate()"
                >
                  view more...
                </v-btn>
              </v-toolbar>
              <v-tabs vertical dense color="indigo lighten-1">
                <v-tab>
                  言語
                </v-tab>
                <v-tab>
                  OS
                </v-tab>
                <v-tab>
                  DB
                </v-tab>

                <v-tab-item>
                  <v-card flat>
                    <v-card-text>
                      <v-data-table
                        :headers="technicalHeaders"
                        :items="technicalSkillItems"
                        class="elevation-1"
                        @click:row="select"
                        dense
                        items-per-page=4
                        hide-default-footer
                      >
                        <template v-slot:items="props">
                          <td>{{ props.item.skill_id }}</td>
                        </template>
                      </v-data-table>
                    </v-card-text>
                  </v-card>
                </v-tab-item>
                <v-tab-item>
                  <v-card flat>
                    <v-card-text>
                      <v-data-table
                        :headers="technicalHeaders"
                        :items="technicalSkillItems"
                        class="elevation-1"
                        @click:row="select"
                        dense
                        items-per-page=4
                        hide-default-footer
                      >
                        <template v-slot:items="props">
                          <td>{{ props.item.skill_id }}</td>
                        </template>
                      </v-data-table>
                    </v-card-text>
                  </v-card>
                </v-tab-item>
                <v-tab-item>
                  <v-card flat>
                    <v-card-text>
                      <v-data-table
                        :headers="technicalHeaders"
                        :items="technicalSkillItems"
                        class="elevation-1"
                        @click:row="select"
                        dense
                        items-per-page=4
                        hide-default-footer
                      >
                        <template v-slot:items="props">
                          <td>{{ props.item.skill_id }}</td>
                        </template>
                      </v-data-table>
                    </v-card-text>
                  </v-card>
                </v-tab-item>
              </v-tabs>
            </v-card>
          </v-col>
          <v-col cols="4" class="ma-0 pa-0">
            <v-card outlined class="mt-6" height="230">
              <v-toolbar
                flat
                color="indigo lighten-1"
                dark
                dense
                height="35"
              >
                <v-toolbar-title>その他</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-row dense>
                  <v-col>
                    <v-btn dense height="45" width="100" block @click="search">職務要約</v-btn>
                  </v-col>
                </v-row>
                <v-row dense class="my-1">
                  <v-col>
                    <v-btn dense height="45" width="100" block @click="search">活かせる経験・知識</v-btn>
                  </v-col>
                </v-row>
                <v-row dense>
                  <v-col>
                    <v-btn dense height="45" width="100" block @click="search">自己PR</v-btn>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="6">
        <experience-detail
          :selected="selected"
          @edit="modal.edit = true"
          @add="modal.add = true"
          @change="change"
        ></experience-detail>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
import ExperienceDetail from "@/Pages/Experience/ExperienceDetail.vue";
export default {
  name: 'experience-list',
  layout: Layout,
  mixins: [ ViewBasic ],
  components: { ExperienceDetail },
  props:{
    experiences: { type: Object, default: {} },
    user_id: { type: String }
  },
  data() {
    return {
      tab: 'option-1',
      keyword: null,
      selected: [],
      modal: {
        register: false,
        edit: false,
        add: false,
        change: false
      },
      experienceHeaders: [
        {text: "プロジェクト名", value: "project_name"},
        {text: "業界", value: "industry"},
        {text: "企業名", value: "company_name"},
      ],
      technicalHeaders: [
        {text: "技術", value: "skill_id"},
      ]
    }
  },
  mounted() {
    this.init();
  },
  computed: {
    listItems() {
      const experienceContent = this.experiences.map(e => {
        return e.experience_content
      })
      const result = []
      experienceContent.forEach(e => {
        for (let j = 0; j < e.length ; j++) {
          result.push(e[j])
        }
      })
      return result
    },
    technicalSkillItems() {
      const technicalSkill = this.experiences.map(e => {
        return e.technical_skill
      })
      const result = []
      technicalSkill.forEach(e => {
        for (let j = 0; j < e.length ; j++) {
          result.push(e[j])
        }
      })
      return result
    },
  },
  methods: {
    init() {
      this.selected = this.experiences[0]
    },
    select(item) {
      this.selected = item
    }
  }
}
</script>