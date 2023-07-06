<template>
  <v-card flat>
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
            :error-messages="errorField('')"
          ></v-text-field>
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
            :error-messages="errorField('')"
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
            :error-messages="errorField('')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col cols="6" class="pb-0 ma-0">
          <v-text-field
            v-model.number="form.experience_content.contract_type"
            label="契約形態"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('')"
          ></v-text-field>
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
            :error-messages="errorField('')"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-card-text>
    <!-- 活動内容 -->
    <v-card-text class="pa-3 pt-5" v-if="editType == 1">
      <v-row dense>
        <v-col>
          <v-textarea
            v-model="form.project_summary"
            label="プロジェクト概要"
            counter="200"
            maxlength="200"
            color="teal"
            hide-details="auto"
            rows="2"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('project_summary')"
          ></v-textarea>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-textarea
            v-model="form.phase"
            label="担当フェーズ"
            counter="200"
            maxlength="200"
            color="teal"
            hide-details="auto"
            rows="2"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('phase')"
          ></v-textarea>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-textarea
            v-model="form.description"
            label="業務内容"
            counter="200"
            maxlength="200"
            color="teal"
            hide-details="auto"
            rows="2"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('description')"
          ></v-textarea>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-textarea
            v-model="form.achievement"
            label="実績・取り組み"
            counter="200"
            maxlength="200"
            color="teal"
            hide-details="auto"
            rows="2"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('achievement')"
          ></v-textarea>
        </v-col>
      </v-row>
    </v-card-text>
    <!-- 環境開発 -->
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
            label="フレームワーク"
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
export default {
  name: 'experience-edit',
  mixins: [ ViewBasic ],
  props:{
    editType: { type: Number },
    active: { type: Boolean },
    selected: { type: Object, default: {} },
    skill_master: { type: Object, default: {} },
  },
  data() {
    return {
      form: [],
    }
  },
  watch: {
    active(v) {
      if(v) {
        this.form = this.initItem();
      }
    },
  },
  computed: {
    errorField() {
      return field => { return this.messages.columns?.[field]; }
    },
  },
  methods: {
    initItem() {
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
          id: this.selected.experience_content.id,
          project_summary: this.selected.experience_content.project_summary,
          phase: this.selected.experience_content.phase,
          description: this.selected.experience_content.description,
          achievement: this.selected.experience_content.achievement,
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
      const list = this.skill_master.filter(e => e.category === n).map(e => e.id)
      return this.selected.technical_skill.filter(e => list.includes(e.skill_id)).map(e => e.skill_id)
    },
    skillSelect(n) {
      const result = []
      this.skill_master.filter(e => e.category === n).map(e => result.push({text: e.name, value: e.id}))
      return result
    }
  }
}
</script>