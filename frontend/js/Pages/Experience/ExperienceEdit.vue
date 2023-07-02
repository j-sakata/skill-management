<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 blue-grey lighten-1 white--text">
      <span>職務経歴変更</span>
    </v-card-title>
    <!-- 基本情報 -->
    <v-card-text class="pa-3 pt-5" v-if="editType == 0">
      <v-row dense>
        <v-col class="pb-0 ma-0">
          <v-text-field
            v-model="form.project_name"
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
            v-model.number="form.member_count"
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
            v-model="form.position"
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
            v-model.number="form.contract_type"
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
            v-model="form.company_name"
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
          <v-text-field
            v-model="editType"
            label="資格名"
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
    <v-divider></v-divider>
    <v-card-actions>
      <v-row dense>
        <v-col cols="4">
          <v-btn
            color="blue-grey lighten-1"
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
            color="blue-grey lighten-1"
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
    selected: { type: Object, default: {} }
  },
  data() {
    return {
      form: this.initItem(),
    }
  },
  watch: {
    active(v) {
      if(v) {
        this.form = this.initItem()
      }
    }
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
          project_name: this.selected.experience_content.project_name,
          industry: this.selected.experience_content.industry,
          started_at: this.selected.experience_content.started_at,
          ended_at: this.selected.experience_content.ended_at,
          member_count: this.selected.experience_content.member_count,
          position: this.selected.experience_content.position,
          contract_type: this.selected.experience_content.contract_type,
          company_name: this.selected.experience_content.company_name,
        });
      } else if(this.editType === 1) {
        return this.$inertia.form({
          project_summary: this.selected.experience_content.project_summary,
          phase: this.selected.experience_content.phase,
          description: this.selected.experience_content.description,
          achievement: this.selected.experience_content.achievement,
        });
      } else {
        return this.$inertia.form({
          skill_id: this.selected.technical_skill.skill_id,
        });
      }
      
    },
    hide() {
      this.$emit("hide")
    },
  }
}
</script>