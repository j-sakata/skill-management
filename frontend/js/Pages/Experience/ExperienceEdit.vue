<template>
  <v-card flat>
    <div v-if="editMode==='jobCareer'">
      <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
        <span>職務経歴変更</span>
      </v-card-title>
      <!-- 基本情報 -->
      <v-card-text class="pa-3 pt-5" v-if="editType == 0">
        <v-row dense>
          <v-col class="pb-0 ma-0">
            <v-text-field
              v-model="form.experience_content.project_name"
              label="プロジェクト名"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.project_name')"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-text-field
              v-model="form.experience_content.industry"
              label="業界"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.industry')"
            ></v-text-field>
          </v-col>
          <v-col cols="6" class="pb-0 ma-0">
            <v-text-field
              v-model="form.company_name"
              label="所属会社"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('company_name')"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col>
            <v-menu
              ref="menu"
              v-model="datepicker.started_at"
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="form.experience_content.started_at"
                  label="開始日"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  :error-messages="errorField('experience_content.started_at')"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="form.experience_content.started_at"
                :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                min="1950-01-01"
                no-title
                @change="saveDatepicker"
              ></v-date-picker>
            </v-menu>
          </v-col>
          <v-col>
            <v-menu
              ref="menu"
              v-model="datepicker.ended_at"
              :close-on-content-click="false"
              transition="scale-transition"
              offset-y
              min-width="auto"
            >
              <template v-slot:activator="{ on, attrs }">
                <v-text-field
                  v-model="form.experience_content.ended_at"
                  label="終了日"
                  prepend-icon="mdi-calendar"
                  readonly
                  v-bind="attrs"
                  v-on="on"
                  clearable
                  :error-messages="errorField('experience_content.ended_at')"
                ></v-text-field>
              </template>
              <v-date-picker
                v-model="form.experience_content.ended_at"
                :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
                min="1950-01-01"
                no-title
                @change="saveDatepicker"
              ></v-date-picker>
            </v-menu>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-text-field
              v-model.number="form.experience_content.member_count"
              label="規模"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.member_count')"
            ></v-text-field>
          </v-col>
          <v-col cols="6" class="pb-0 ma-0">
            <v-text-field
              v-model="form.experience_content.position"
              label="役職"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.position')"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-select
              v-model.number="form.experience_content.contract_type"
              :items="optionsContractType"
              label="契約形態"
              hide-details="auto"
              dense
              persistent-placeholder
              :error-messages="errorField('experience_content.contract_type')"
            />
          </v-col>
          <v-col cols="6" class="pb-0 ma-0">
            <v-text-field
              v-model="form.experience_content.company_name"
              label="（派遣先）企業名"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.company_name')"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>
      <!-- 活動内容 -->
      <v-card-text class="pa-3 pt-5" v-if="editType == 1">
        <v-row dense>
          <v-col>
            <v-textarea
              v-model="form.experience_content.project_summary"
              label="プロジェクト概要"
              counter="200"
              maxlength="200"
              color="teal"
              hide-details="auto"
              rows="2"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.project_summary')"
            ></v-textarea>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col class="pb-0 ma-0">
            <v-select
              v-model="form.experience_content.experience_phase"
              :items="optionsPhaseType()"
              :menu-props="{ maxHeight: '250' }"
              label="担当フェーズ"
              multiple
              dense
              persistent-hint
              :error-messages="errorField('experience_content.experience_phase')"
            ></v-select>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col>
            <v-textarea
              v-model="form.experience_content.description"
              label="業務内容"
              counter="200"
              maxlength="200"
              color="teal"
              hide-details="auto"
              rows="2"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.description')"
            ></v-textarea>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col>
            <v-textarea
              v-model="form.experience_content.achievement"
              label="実績・取り組み"
              counter="200"
              maxlength="200"
              color="teal"
              hide-details="auto"
              rows="2"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('experience_content.achievement')"
            ></v-textarea>
          </v-col>
        </v-row>
      </v-card-text>
      <!-- 開発環境 -->
      <v-card-text class="pa-3 pt-5" v-if="editType == 2">
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-select
              v-model="form.skill_api"
              :items="skillSelect(1)"
              :menu-props="{ maxHeight: '250' }"
              label="言語/API"
              multiple
              dense
              persistent-hint
            ></v-select>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-select
              v-model="form.skill_fw"
              :items="skillSelect(2)"
              :menu-props="{ maxHeight: '250' }"
              label="フレームワーク、DB等"
              multiple
              dense
              persistent-hint
            ></v-select>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-select
              v-model="form.skill_os"
              :items="skillSelect(3)"
              :menu-props="{ maxHeight: '250' }"
              label="OS、クラウド等"
              multiple
              dense
              persistent-hint
            ></v-select>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-select
              v-model="form.skill_nw"
              :items="skillSelect(4)"
              :menu-props="{ maxHeight: '250' }"
              label="ルータ、NW技術等"
              multiple
              dense
              persistent-hint
            ></v-select>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="6" class="pb-0 ma-0">
            <v-select
              v-model="form.skill_pj"
              :items="skillSelect(5)"
              :menu-props="{ maxHeight: '250' }"
              label="プロジェクト支援"
              multiple
              dense
              persistent-hint
            ></v-select>
          </v-col>
        </v-row>
      </v-card-text>
    </div>
    <div v-else-if="editMode==='jodSummary'">
      <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
        <span>職務要約編集</span>
      </v-card-title>
      <v-card-text class="pa-3 pt-5">
        <v-row dense>
          <v-col cols="9" class="pb-0 ma-0">
            <v-text-field
              v-model="form.title"
              label="タイトル"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('title')"
            ></v-text-field>
          </v-col>
          <v-col cols="3" class="pb-0 ma-0">
            <v-text-field
              v-model="form.title"
              label="タイトル"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('status')"
            ></v-text-field>
          </v-col>
        </v-row>
        <v-row dense>
          <v-col cols="9" class="pb-0 ma-0">
            <v-text-field
              v-model="form.summary"
              label="職務要約"
              counter="30"
              maxlength="30"
              hide-details="auto"
              dense
              outlined
              persistent-placeholder
              :error-messages="errorField('title')"
            ></v-text-field>
          </v-col>
        </v-row>
      </v-card-text>
    </div>
    <div v-else-if="editMode==='jobKnowledge'">
      <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
        <span>活かせる経験・知識編集</span>
      </v-card-title>
      <v-card-text class="pa-3 pt-5">
        活かせる経験・知識/TBD
      </v-card-text>
    </div>
    <div v-else-if="editMode==='character'">
      <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
        <span>自己PR編集</span>
      </v-card-title>
      <v-card-text class="pa-3 pt-5">
        自己PR/TBD
      </v-card-text>
    </div>
    <v-divider></v-divider>
    <v-card-actions>
      <v-row dense>
        <v-col cols="4">
          <v-btn
            color="indigo lighten-1"
            block
            depressed
            outlined
            small
            @click="hide()"
          >
            キャンセル
          </v-btn>
        </v-col>
        <v-col>
          <v-btn
            class="white--text"
            color="indigo lighten-1"
            block
            depressed
            small
            :loading="updating"
            @click="update()"
          >
            変更
          </v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import { ContractType, PhaseType } from "@/enums";
export default {
  name: 'experience-edit',
  mixins: [ ViewBasic ],
  props:{
    editType: { type: Number },
    editMode: { type: String },
    active: { type: Boolean },
    selected: { type: [Array, Object], default: [] },
    skill_master: { type: [Array, Object], default: [] },
  },
  data() {
    return {
      form: [],
      datepicker: {
        started_at: false,
        ended_at: false
      }
    }
  },
  watch: {
    active(v) {
      if(v) {
        this.form = this.initItem();
        this.clearMessage();
      }
    },
  },
  computed: {
    optionsContractType() {
      return Object.entries(ContractType).map(([index, text]) => {
        const value = Number(index)
        return { text, value }
      });
    },
    errorField() {
      return field => { return this.messages.columns?.[field]; }
    },
  },
  methods: {
    initItem() {
      if (this.editMode === 'jobCareer') {
        if(this.editType === 0) {
          return this.$inertia.form({
            edit_type: this.editType,
            company_name: this.selected.company_name,
            experience_content: {
              id: this.selected.experience_content.id,
              experience_id: this.selected.experience_content.experience_id,
              project_name: this.selected.experience_content.project_name,
              industry: this.selected.experience_content.industry,
              started_at: this.selected.experience_content.started_at,
              ended_at: this.selected.experience_content.ended_at,
              member_count: this.selected.experience_content.member_count,
              position: this.selected.experience_content.position,
              contract_type: this.selected.experience_content.contract_type,
              company_name: this.selected.experience_content.company_name,
            }
          });
        } else if(this.editType === 1) {
          return this.$inertia.form({
            edit_type: this.editType,
            experience_content: {
              id: this.selected.experience_content.id,
              project_summary: this.selected.experience_content.project_summary,
              experience_phase: this.phaseItems(),
              description: this.selected.experience_content.description,
              achievement: this.selected.experience_content.achievement,
            }
          });
        } else {
          return this.$inertia.form({
            edit_type: this.editType,
            id: this.selected.id,
            skill_api: this.technicalSkillItems(1),
            skill_fw: this.technicalSkillItems(2),
            skill_os: this.technicalSkillItems(3),
            skill_nw: this.technicalSkillItems(4),
            skill_pj: this.technicalSkillItems(5),
          });
        }
      } else if (this.editMode === 'jodSummary') {
        return this.$inertia.form({
          title: this.selected.title,
          status: this.selected.status,
          summary: this.selected.summary
        })
      }
    },
    hide() {
      this.$emit("hide")
    },
    update() {
      this.form.post("/experience/update", {
        onSuccess: page => {
          if (page.props.error) {
            this.messageError("入力情報を確認してください。", page.props.error);
          } else {
            this.message("作成が完了しました。");
            this.hide();
          }
        },
        onError: () => {
          this.actionFailure;
        },
      })
    },
    technicalSkillItems(n) {
      const list = this.skill_master.filter(e => e.skill_category === n).map(e => e.id)
      return this.selected.technical_skill.filter(e => list.includes(e.skill_id)).map(e => e.skill_id)
    },
    phaseItems() {
      return this.selected.experience_phase.map(e => e.phase_id);
    },
    optionsPhaseType() {
      return Object.entries(PhaseType).map(([value, text]) =>({ text, value }));
    },
    saveDatepicker (date) {
      this.$refs.menu.save(date)
    },
    skillSelect(n) {
      const result = []
      this.skill_master.filter(e => e.skill_category === n).map(e => result.push({text: e.skill_name, value: e.id}))
      return result
    }
  }
}
</script>