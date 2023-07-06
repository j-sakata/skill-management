<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 blue-grey lighten-1 white--text">
      <span>取得資格変更</span>
    </v-card-title>
    <v-card-text class="pa-3 pt-5">
      <v-row dense>
        <v-col cols="8" class="pb-0 ma-0">
          <v-text-field
            v-model="form.name"
            label="資格名"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('community_name')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col cols="8" class="pb-0 ma-0">
          <v-text-field
            v-model="form.certification_number"
            label="資格コード"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('community_name')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense>
        <v-col cols="8" class="pb-0 ma-0">
          <v-text-field
            v-model="form.expiration"
            label="有効期限"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('community_name')"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row dense class="mb-5">
        <v-col cols="6" class="pb-0 ma-0">
          <v-select
            v-model="form.category"
            :items="optionsCertificationCategoryType"
            label="区分1"
            hide-details="auto"
            dense
            persistent-placeholder
            :error-messages="errorField('community_category')"
          />
        </v-col>
        <v-col cols="6" class="pb-0 ma-0">
          <v-select
            v-model="form.sub_category"
            :items="optionsCertificationSubCategoryType"
            label="区分2"
            hide-details="auto"
            dense
            persistent-placeholder
            :error-messages="errorField('community_category')"
          />
        </v-col>
      </v-row>
      <v-row dense>
        <v-col>
          <v-textarea
            v-model="form.memo"
            label="備考"
            counter="400"
            maxlength="400"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('community_summary')"
          ></v-textarea>
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
import { Ajax } from "@/Shared/plain";
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
      return Object.entries(CertificationCategoryType).map(([value, text]) => ({ text, value }));
    },
    optionsCertificationSubCategoryType() {
      return Object.entries(CertificationSubCategoryType).map(([value, text]) => ({ text, value }));
    },
  },
  methods: {
    initItem() {
      return this.$inertia.form({
        id: this.selected.id,
        name: this.selected.name,
        certification_number: this.selected.certification_number,
        expiration: this.selected.expiration,
        memo: this.selected.memo,
        category: this.selected.category,
        sub_category: this.selected.sub_category,
      });
    },
    checkCreate() {
      this.updating = true;
      Ajax.post("/community/create/check", this.form, error => {
        if (error) {
          this.updating = false;
          this.messageError("入力情報を確認してください。", error);
        } else {
          this.create();
        }
      }, this.actionFailure);
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