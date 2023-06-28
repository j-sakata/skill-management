<style lang="scss" scoped>
.l-profile {
  text-align: right;
  width: 180px;
  text-overflow: ellipsis;
}
</style>

<template>
  <v-app>
    <v-app-bar
      app
      color="indigo lighten-1"
      dark
      dense
      v-if="logined"
    >
      <v-toolbar-title>Skill mgmt.</v-toolbar-title>
      <v-tabs v-model="indexMenu" align-with-title >
        <v-tab>
          <inertia-link href="/dashboard" as="button">ダッシュボード</inertia-link>
        </v-tab>
        <v-tab>
          <inertia-link href="/certification" as="button">資格</inertia-link>
        </v-tab>
        <v-tab>
          <inertia-link href="/experience" as="button">業務経歴</inertia-link>
        </v-tab>
        <v-tab>
          <inertia-link href="/target" as="button">到達目標</inertia-link>
        </v-tab>
        <v-tab>
          <inertia-link href="/company" as="button">企業</inertia-link>
        </v-tab>
        <v-tab>
          <inertia-link href="/system" as="button">システム</inertia-link>
        </v-tab>
      </v-tabs>
      <v-spacer></v-spacer>
      <div class="l-profile">{{user.name}}</div>
      <v-menu left bottom>
        <template v-slot:activator="{ on, attrs }">
          <v-btn icon v-bind="attrs" v-on="on">
            <v-icon>mdi-dots-vertical</v-icon>
          </v-btn>
        </template>
        <v-list>
          <v-list-item dense @click="changePassword">
            <v-list-item-title>パスワード変更</v-list-item-title>
          </v-list-item>
          <v-divider></v-divider>
          <v-list-item dense @click="logout">
            <v-list-item-title>ログアウト</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
    </v-app-bar>
    <v-main>
      <slot/>
    </v-main>
    <v-snackbar
      v-model="modal.message"
      top
      right
      :color="colorMessage"
      :timeout=2000
      v-show="messages.global"
    >
      {{messages.global}}
    </v-snackbar>
    <v-footer
      fixed
      class="py-1"
      >
      <v-row no-gutters dense>
        <v-col class="caption text-center blue-grey--text">
          Copyright © All Rights Reserved.
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<script>
import { ActionEvent, Level } from "@/enums";
import { Ajax, Inertia } from "@/Shared/plain";
import ViewBasic from "@/Shared/view-basic";
export default {
  name: 'layout',
  mixins: [ ViewBasic ],
  data() {
    return {
      modal: {
        message: false
      },
      indexMenu: 0,
    }
  },
  created() {
    Ajax.get("/login/check", {}, check => {
      this.logined = check.logined;
    }, this.actionFalse)
  },
  computed: {
    colorMessage() {
      if (this.messages) {
        switch (this.messages.level) {
          case Level.INFO:
            return "green lighten-1";
          case Level.WARN:
            return "amber darken-2";
          case Level.ERROR:
            return "deep-orange darken-1";
          default:
            return "grey";
        }
      } else {
        return "grey";
      }
    },
  },
  methods: {
    handleMessages(messages) {
      if (messages.global) {
        this.messages = messages;
        this.modal.message = true;
      } else {
        this.messages.columns = messages.columns;
      }
    },
    logout() {
      Inertia.post("/login/out", {}, (v) => {
        window.EventEmitter.$emit(ActionEvent.Logout);
      }, this.actionFalse);
    },
    changePassword() {
      this.message("未実装", [], Level.INFO)
    },
  }
}
</script>
