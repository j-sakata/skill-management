<template>
  <v-card flat>
    <v-card-title class="pa-1 pl-2 blue-grey lighten-1 white--text">
      <span>取得日追加登録</span>
    </v-card-title>
    <v-card-text class="pa-3 pt-5">
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
            :error-messages="errorField('community_name')"
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
            @click="create()"
          >
            追加
          </v-btn>
        </v-col>
      </v-row>
    </v-card-actions>
  </v-card>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
export default {
  name: 'add-certification-acquisition',
  mixins: [ ViewBasic ],
  props:{
    active: { type: Boolean, default: false },
    selected: { type: Object, default: {} }
  },
  data() {
    return {
      form: this.initItem(),
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
  },
  methods: {
    initItem() {
      return this.$inertia.form({
        id: this.selected.id,
        acquisition: {
          acquisition_date: null,
          score: null
        }
      });
    },
    create() {
      this.form.post("/certification/add", {
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