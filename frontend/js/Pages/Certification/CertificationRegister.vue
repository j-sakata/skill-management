<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
      <span>取得資格新規登録</span>
    </v-card-title>
    <v-card-text class="pa-3 pt-5">
      <v-row dense>
        <v-col cols="8" class="pb-0 ma-0">
          <v-text-field
            v-model="form.certification_name"
            label="資格名"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('certification_name')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col cols="8" class="pb-0 ma-0">
          <v-text-field
            v-model="form.certification_code"
            label="資格コード"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('certification_code')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col cols="8" class="pb-0 ma-0">
          <v-text-field
            v-model="form.certification_expiration"
            label="有効期限"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('certification_expiration')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense class="mb-5">
        <v-col cols="6" class="pb-0 ma-0">
          <v-select
            v-model="form.certification_category"
            :items="optionsCertificationCategoryType"
            label="区分1"
            hide-details="auto"
            dense
            persistent-placeholder
            :error-messages="errorField('certification_category')"
          />
        </v-col>
        <v-col cols="6" class="pb-0 ma-0">
          <v-select
            v-model="form.certification_sub_category"
            :items="optionsCertificationSubCategoryType"
            label="区分2"
            hide-details="auto"
            dense
            persistent-placeholder
            :error-messages="errorField('certification_sub_category')"
          />
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-menu
            ref="menu"
            v-model="datepicker.menu"
            :close-on-content-click="false"
            transition="scale-transition"
            offset-y
            min-width="auto"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="form.acquisition.acquisition_date"
                label="取得日"
                prepend-icon="mdi-calendar"
                readonly
                v-bind="attrs"
                v-on="on"
                :error-messages="errorField('acquisition.acquisition_date')"
              ></v-text-field>
            </template>
            <v-date-picker
              v-model="form.acquisition.acquisition_date"
              :max="(new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10)"
              min="1950-01-01"
              no-title
              @change="saveDatepicker"
            ></v-date-picker>
          </v-menu>
        </v-col>
        <v-col cols="2" class="pb-0 ma-0">
          <v-text-field
            v-model="form.acquisition.score"
            label="スコア"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('acquisition.score')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-textarea
            v-model="form.certification_memo"
            label="備考"
            counter="400"
            maxlength="400"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('certification_memo')"
          ></v-textarea>
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
import { CertificationCategoryType, CertificationSubCategoryType } from "@/enums";
export default {
  name: 'certification-register',
  mixins: [ ViewBasic ],
  props:{
    active: { type: Boolean, default: false },
    user_id: { type: String }
  },
  data() {
    return {
      form: [],
      datepicker: {
        menu: false
      }
    }
  },
  watch: {
    active(v) {
      if(v) {
        this.form = this.initItem();
      }
    }
  },
  computed: {
    errorField() {
      return field => { return this.messages.columns?.[field]; }
    },
    optionsCertificationCategoryType() {
      return Object.entries(CertificationCategoryType).map(([value, text]) => ({ text, value }));
    },
    optionsCertificationSubCategoryType() {
      return Object.entries(CertificationSubCategoryType).map(([value, text]) => ({ text, value }));
    },
  },
  methods: {
    initItem() {
      return this.$inertia.form({
        user_id: this.user_id,
        certification_name: null,
        certification_code: null,
        certification_expiration: null,
        certification_memo: null,
        certification_category: "NATIONAL",
        certification_sub_category: "IT",
        acquisition: {
          acquisition_date: null,
          score: null
        }
      });
    },
    create() {
      this.form.post("/certification/create", {
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
        preserveState: true,
      });
    },
    hide() {
      this.$emit("hide")
    },
    saveDatepicker (date) {
      this.$refs.menu.save(date)
    },
  }
}
</script>