<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 indigo lighten-1 white--text">
      <span>技術要素編集</span>
    </v-card-title>
    <v-card-text class="pa-3 pt-5">
      <v-row dense>
        <v-col cols="8" class="pb-0 ma-0">
          <v-text-field
            v-model="form.skill_name"
            label="資格名"
            counter="30"
            maxlength="30"
            hide-details="auto"
            dense
            outlined
            persistent-placeholder
            :error-messages="errorField('skill_name')"
          ></v-text-field>
        </v-col>
        <v-col cols="" class="pb-0 ma-0">
          <v-select
            v-model.number="form.skill_status"
            :items="optionsStatusType"
            label="状態"
            hide-details="auto"
            dense
            persistent-placeholder
            :error-messages="errorField('skill_status')"
          />
        </v-col>
      </v-row>
			<v-row dense>
				<v-col cols="6" class="pb-0 ma-0">
          <v-select
            v-model.number="form.skill_category"
            :items="optionsSkillCategoryType"
            label="カテゴリー"
            hide-details="auto"
            dense
            persistent-placeholder
            :error-messages="errorField('skill_category')"
          />
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
            編集
          </v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import { SkillCategoryType, StatusType } from "@/enums";
export default {
  name: 'edit-skill',
  mixins: [ ViewBasic ],
  props:{
    active: { type: Boolean, default: false },
    item: { type: Object, default: {} }
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
        this.clearMessage();
      }
    }
  },
  computed: {
    errorField() {
      return field => { return this.messages.columns?.[field]; }
    },
		optionsSkillCategoryType() {
      return Object.entries(SkillCategoryType).map(([index, text]) => {
        const value = Number(index)
        return { text, value }
      });
    },
    optionsStatusType() {
      return Object.entries(StatusType).map(([index, text]) => {
        const value = Number(index)
        return { text, value }
      });
    },
  },
  methods: {
    initItem() {
      return this.$inertia.form({
        id: this.item.id,
        skill_name: this.item.skill_name,
        skill_status: this.item.skill_status,
        skill_category: this.item.skill_category,
      });
    },
    create() {
      this.form.post("/admin/system/skill/update", {
        onSuccess: page => {
          if (page.props.error) {
            this.messageError("入力情報を確認してください。", page.props.error);
          } else {
            this.message("編集が完了しました。");
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
  }
}
</script>