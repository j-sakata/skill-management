<template>
  <v-container fluid>
    <v-dialog v-model="modal.register" eager min-height="700px" width="900px" persistent scrollable>
      <experience-register
        :active="modal.register"
        :user_id="user_id"
        :registerType="mode.keyName"
        @hide="modal.register = false"
        @send="receive($event)"
      ></experience-register>
    </v-dialog>
    <v-dialog v-model="modal.edit" eager min-height="700px" width="900px" persistent scrollable>
      <experience-edit
        :active="modal.edit"
        :editType="editType"
        :selected="selected"
        :skill_master="skill_master"
        @hide="modal.edit = false; updateItem()"
        @send="receive($event)"
      ></experience-edit>
    </v-dialog>
    <v-dialog v-model="modal.skillList" eager min-height="700px" width="900px" persistent scrollable>
      <technical-skill-list
        :technicalSkill="technicalSkill"
        :skill_master="skill_master"
        @hide="modal.skillList = false"
        @send="receive($event)"
      ></technical-skill-list>
    </v-dialog>
    <v-row no-gutters>
      <v-col cols="6">
        <v-row no-gutters class="pa-4 pb-0">
          <v-col>
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
          <v-col cols="auto" class="ml-2">
            <v-btn dense @click="search">検索</v-btn>
          </v-col>
          <v-spacer></v-spacer>
          <v-col cols="auto">
            mode： {{ mode.valueName }}
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
              :items="experienceContentItems"
              class="elevation-1"
              @click:row="select"
              dense
              height=230
            >
            </v-data-table>
          </v-col>
        </v-row>
        <!-- 職務要約モード -->
        <v-row no-gutters v-if="mode.keyName == 'jodSummary'">
          <v-col class="pa-0 ma-0">
            <v-data-table
              :headers="experienceSummaryHeaders"
              :items="experience_summary"
              class="elevation-1"
              @click:row="select"
              dense
              height=230
            >
              <template v-slot:items="props">
                <td>{{ props.item.title }}</td>
                <td>{{ props.item.status }}</td>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
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
                  @click="modal.skillList = true"
                >
                  view more...
                </v-btn>
              </v-toolbar>
              <v-tabs vertical color="indigo lighten-1" class="overflow-y-auto" height="193">
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
                  ルータ、NW技術等
                </v-tab>
                <v-tab>
                  プロジェクト支援
                </v-tab>
                <v-tab-item v-for="n in 5" :key="n">
                  <v-card flat>
                    <v-card-text>
                      <v-data-table
                        :headers="technicalHeaders"
                        :items="technicalSkillItems(n)"
                        class="elevation-1"
                        dense
                        disable-sort
                        items-per-page=4
                        hide-default-footer
                      >
                        <template v-slot:items="props">
                          <td>{{ props.item.name }}</td>
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
          :skillMaster="skill_master"
          :detailType="mode.keyName"
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
import ExperienceRegister from "@/Pages/Experience/ExperienceRegister.vue";
import TechnicalSkillList from "@/Pages/Experience/TechnicalSkillList.vue";
export default {
  name: 'experience-list',
  layout: Layout,
  mixins: [ ViewBasic ],
  components: { ExperienceDetail, ExperienceEdit, ExperienceRegister, TechnicalSkillList },
  props:{
    experiences: { type: Object, default: {} },
    experience_summary: { type: Object, default: {} },
    skill_master: { type: Object, default: {} },
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
        skillList: false
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
      experienceSummaryHeaders: [
        {text: "タイトル", value: "title"},
        {text: "状態", value: "status"},
      ],
      technicalHeaders: [
        {text: "技術", value: "skill_name"},
      ]
    }
  },
  mounted() {
    this.init();
    this.setModeName()
  },
  computed: {
    experienceContentItems() {
      return this.experiences.map(e => e.experience_content)
    },
    technicalSkill() {
      return this.experiences.map(e => e.technical_skill)
    }
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
    setModeName() {
      var keyList = ["jobCareer", "jodSummary", "jobKnowledge", "character"]
      var valueList = ["職務経歴", "職務要約", "活かせる経験・知識", "自己PR"]

      this.mode.key = keyList.filter(e => e !== this.mode.keyName)
      this.mode.value = valueList.filter(e => e !== this.mode.valueName)
    },
    changeMode(number) {
      this.mode.keyName = this.mode.key[number]
      this.mode.valueName = this.mode.value[number]
      this.setModeName()
    },
    technicalSkillItems(n) {
      // ユーザーのテクニカルスキルを同階層の配列に格納する
      const result = []
      this.technicalSkill.forEach(e => {
        for (let j = 0; j < e.length ; j++) {
          result.push(e[j])
        }
      })
      return this.skill_master.filter(e => e.skill_category === n && result.map(s => s.skill_id).includes(e.id))
    },
    updateItem() {
      this.selected = this.experiences.find(e => e.id === this.selected.id)
    }
  }
}
</script>