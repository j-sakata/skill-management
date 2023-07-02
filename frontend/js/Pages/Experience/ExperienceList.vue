<template>
  <v-container fluid>
    <v-dialog v-model="modal.edit" eager min-height="700px" width="900px" persistent scrollable>
      <experience-edit
        :active="modal.edit"
        :editType="editType"
        :selected="selected"
        @hide="modal.edit = false"
        @send="receive($event)"
      ></experience-edit>
    </v-dialog>
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
        <!-- 職務経歴モード -->
        <v-row no-gutters v-if="mode.keyName == 'jobCareer'">
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
        <!-- 職務要約モード -->
        <v-row no-gutters v-if="mode.keyName == 'jodSummary'">職務要約</v-row>
        <!-- 活かせる経験・知識モード -->
        <v-row no-gutters v-if="mode.keyName == 'jobKnowledge'">活かせる経験・知識</v-row>
        <!-- 自己PRモード -->
        <v-row no-gutters v-if="mode.keyName == 'character'">自己PR</v-row>
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
                  @click="showTechnicalSkill()"
                >
                  view more...
                </v-btn>
              </v-toolbar>
              <v-tabs vertical dense color="indigo lighten-1" class="overflow-y-auto">
                <v-tab>
                  言語/API
                </v-tab>
                <v-tab>
                  フレームワーク
                </v-tab>
                <v-tab>
                  OS、クラウド等
                </v-tab>
                <v-tab>
                  プロジェクト支援
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
                <v-toolbar-title>モード切替</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <v-row dense>
                  <v-col>
                    <v-btn dense height="45" width="100" block @click=changeMode(0)>{{ mode.value[0] }}</v-btn>
                  </v-col>
                </v-row>
                <v-row dense class="my-1">
                  <v-col>
                    <v-btn dense height="45" width="100" block @click=changeMode(1)>{{ mode.value[1] }}</v-btn>
                  </v-col>
                </v-row>
                <v-row dense>
                  <v-col>
                    <v-btn dense height="45" width="100" block @click=changeMode(2)>{{ mode.value[2] }}</v-btn>
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
          @edit="edit"
        ></experience-detail>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
import ExperienceDetail from "@/Pages/Experience/ExperienceDetail.vue";
import ExperienceEdit from "@/Pages/Experience/ExperienceEdit.vue";
export default {
  name: 'experience-list',
  layout: Layout,
  mixins: [ ViewBasic ],
  components: { ExperienceDetail, ExperienceEdit },
  props:{
    experiences: { type: Object, default: {} },
    user_id: { type: String }
  },
  data() {
    return {
      tab: 'option-1',
      keyword: null,
      selected: [],
      editType: null,
      modal: {
        register: false,
        edit: false,
      },
      mode: {
        keyName: null,
        valueName: null,
        key: [],
        value: []
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
    this.setModeName()
  },
  computed: {
    listItems() {
      const experienceContent = this.experiences.map(e => {
        return e.experience_content
      })
      return experienceContent
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
      this.selected = this.experiences[0];
      this.mode.keyName = "jobCareer";
      this.mode.valueName = "職務経歴"
    },
    select(item) {
      const experience = this.experiences.find(e => {
        return e.id === item.experience_id
      })
      this.selected = experience
    },
    edit(item) {
      this.editType = item
      this.modal.edit = true
    },
    showTechnicalSkill(){

    },
    setModeName() {
      var keyList = ["jobCareer", "jodSummary", "jobKnowledge", "character"]
      var valueList = ["職務経歴", "職務要約", "活かせる経験・知識", "自己PR"]

      this.mode.key = keyList.filter(e => {
        return e !== this.mode.keyName
      })
      this.mode.value = valueList.filter(e => {
        return e !== this.mode.valueName
      })
    },
    changeMode(number) {
      this.mode.keyName = this.mode.key[number]
      this.mode.valueName = this.mode.value[number]
      this.setModeName()
    }
  }
}
</script>