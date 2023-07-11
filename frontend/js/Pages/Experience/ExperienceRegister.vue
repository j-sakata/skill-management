<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
      <span>職務経歴新規登録</span>
    </v-card-title>
    <v-card-text class="pa-3 pt-5" v-if="registerType === 'jobCareer'">
      <v-row dense>
        <v-col cols="6" class="pb-0 ma-0">
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
        <v-col>
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
        <v-col>
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
        <v-col>
          <v-text-field
            v-model.number="form.experience_content.contract_type"
            label="契約形態"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('experience_content.contract_type')"
          ></v-text-field>
        </v-col>
        <v-col>
          <v-text-field
            v-model="form.experience_content.company_name"
            label="(派遣先)企業名"
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
    <v-card-text v-if="registerType === 'jodSummary'">
      職務要約/TBD
    </v-card-text>
    <v-card-text v-if="registerType === 'jobKnowledge'">
      活かせる経験・知識/TBD
    </v-card-text>
    <v-card-text v-if="registerType === 'character'">
      自己PR/TBD
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
            @click="create()"
          >
            作成
          </v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
export default {
  name: 'experience-register',
  mixins: [ ViewBasic ],
  props:{
    user_id: { type: String },
    registerType: { type: String },
    active: { type: Boolean },
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
      return this.$inertia.form({
        user_id: this.user_id,
        company_name: null,
        experience_content: {
          project_name: null,
          industry: null,
          started_at: null,
          ended_at: null,
          member_count: null,
          position: null,
          contract_type: 1,
          company_name: null,
        }
      });
    },
    hide() {
      this.$emit("hide")
    },
    saveDatepicker (date) {
      this.$refs.menu.save(date)
    },
    create() {
      this.form.post("/experience/create", {
        onSuccess: page => {
          if(page.props.error) {
            this.messageError("入力内容を確認してください。", page.props.error);
          } else {
            this.message("作成が完了しました。");
            this.hide();
          }
          onError: () => {
            this.actionFailure;
          }
        }
      })
    }
  }
}
</script>