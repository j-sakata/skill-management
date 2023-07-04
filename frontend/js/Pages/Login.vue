<style scoped>
</style>

<template>
  <v-container>
    <v-row no-gutters>
      <v-col cols="6" offset="3">
        <v-card class="ma-2" outlined>
          <v-card-title>ログイン</v-card-title>
          <v-card-text>
            <v-text-field
              v-model="form.user_id"
              label="ID"
              counter="30"
              persistent-placeholder
              @keydown.enter="login"
            ></v-text-field>
            <v-text-field
              v-model="form.password"
              label="パスワード"
              type="password"
              counter="255"
              persistent-placeholder
              @keydown.enter="login"
            ></v-text-field>
            <v-btn
              color="indigo darken-2"
              class="mt-2"
              dark
              block
              @click="login"
              :loading="form.processing"
              >
              ログイン
            </v-btn>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { Log, Ajax, Inertia, Session } from "@/Shared/plain";
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
import { ActionEvent } from "@/enums";
import { throttle } from "lodash";
export default {
  name: 'login',
  layout: Layout,
  mixins: [ ViewBasic ],
  data() {
    return {
      form: this.$inertia.form({
        user_id: "",
        password: "",
      }),
    }
  },
  methods: {
    login: throttle(function(e) {
      Log.debug(this.form.user_id);
      Ajax.get('/sanctum/csrf-cookie', {}, (v) => {
        this.form.post("/login/in", {
          onSuccess: page => {
            if(page.props.error) return null;
            if(page.props.reply) return this.messageError(page.props.reply);
            Session.login(page.props.data);
            window.EventEmitter.$emit(ActionEvent.Login, page.props.data);
            Log.debug("ログインに成功しました - ");
            this.forward(page.props.data);
          },
        });
      }, this.actionFailure);
    }, 1000),
    forward() {
      Inertia.get("/dashboard", this.actionSucsess, this.actionFailure);
    }
  }
}
</script>