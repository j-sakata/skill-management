<template>
  <v-container>
    <v-dialog v-model="dialog" persistent width="350px" transition="dialog-top-transition">
      <v-card dark>
        <v-card-title>
          <span class="subtitle-1">ユーザー認証</span>
        </v-card-title>
        <v-card-text class="pb-0 mt-2">
          <v-row no-gutters>
            <v-col>
              <v-text-field
                v-model="create_user_id"
                label="ID"
                persistent-placeholder
                dense
                outlined
                autofocus
              ></v-text-field>
            </v-col>
          </v-row>
          <v-row no-gutters>
            <v-col>
              <v-text-field
                v-model="password"
                label="パスワード"
                type="password"
                persistent-placeholder
                dense
                outlined
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions class="pt-0 pb-4">
          <v-spacer></v-spacer>
          <v-btn color="blue-grey lighten-1" outlined small depressed flat @click="cancel">キャンセル</v-btn>
          <v-btn class="white--text" color="blue-grey lighten-1" small depressed flat @click="confirm">確認する</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-row no-gutters v-if="authorization==true">
      <v-col cols="5" offset="3">
        <v-card class="ma-2" outlined>
          <v-card-title>ユーザー新規登録</v-card-title>
          <v-card-text>
            <v-text-field
              v-model="form.user_id"
              label="ID"
              counter="30"
              persistent-placeholder
              dense
              :error-messages="errorField('user_id')"
            ></v-text-field>
            <v-text-field
              v-model="form.password"
              label="メールアドレス"
              type="email"
              counter="255"
              persistent-placeholder
              dense
              :error-messages="errorField('email')"
            ></v-text-field>
            <v-text-field
              v-model="form.confirm_password"
              label="確認用パスワード"
              type="password"
              counter="255"
              persistent-placeholder
              dense
              :error-messages="errorField('password')"
            ></v-text-field>
            <v-select
              v-model="form.authority"
              :items="optionsCertificationCategoryType"
              label="権限"
              hide-details="auto"
              dense
              persistent-placeholder
              :error-messages="errorField('authority')"
            />
            <v-btn
              color="indigo darken-2"
              class="mt-2"
              dark
              block
              @click="register"
              :loading="form.processing"
              >
              新規登録
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
    <v-row no-gutters v-else>
      Authorization Required
    </v-row>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
export default {
  name: 'user-register',
  layout: Layout,
  mixins: [ ViewBasic ],
  props:{
  },
  data() {
    return {
      form: this.$inertia.form({
        user_id: "",
        email: "",
        authority: "General",
        password: "",
        confirm_password: "",
        create_user_id: this.create_user_id
      }),
      dialog: true,
      authorization: false,
      create_user_id: "",
      password: ""
    }
  },
  computed: {
    errorField() {
      return field => { return this.messages.columns?.[field]; }
    },
  },
  methods: {
    register() {

    },
    cancel() {
      this.dialog = false,
      this.authorization = false
    },
    confirm() {
      this.dialog = false,
      this.authorization = true
    }
  }
}
</script>