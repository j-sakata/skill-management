<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
      <span>取得資格変更</span>
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
        <v-col cols="6" class="pb-0 ma-0">
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
        <v-col cols="6" class="pb-0 ma-0">
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
            v-model.number="form.certification_category"
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
            v-model.number="form.certification_sub_category"
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
import { CertificationCategoryType, CertificationSubCategoryType } from "@/enums";
export default {
  name: 'certification-edit',
  mixins: [ ViewBasic ],
  props:{
    active: { type: Boolean, default: false },
    selected: { type: Array, default: [] }
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
      return Object.entries(CertificationCategoryType).map(([index, text]) => {
        const value = Number(index);
        return { text, value }
      });
    },
    optionsCertificationSubCategoryType() {
      return Object.entries(CertificationSubCategoryType).map(([index, text]) => {
        const value = Number(index);
        return { text, value }
      });
    },
  },
  methods: {
    initItem() {
      return this.$inertia.form({
        id: this.selected.id,
        certification_name: this.selected.certification_name,
        certification_code: this.selected.certification_code,
        certification_expiration: this.selected.certification_expiration,
        certification_memo: this.selected.certification_memo,
        certification_category: this.selected.certification_category,
        certification_sub_category: this.selected.certification_sub_category,
      });
    },
    update() {
      this.form.post("/certification/update", {
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