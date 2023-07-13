<template>
  <v-container fluid>
    <v-dialog v-model="modal.register" eager min-height="700px" width="900px" persistent scrollable>
      <add-skill
        :active="modal.register"
        @hide="modal.register = false"
        @send="receive($event)"
      ></add-skill>
    </v-dialog>
    <v-dialog v-model="modal.edit" eager min-height="700px" width="900px" persistent scrollable>
      <edit-skill
        :active="modal.edit"
        :item="item"
        @hide="modal.edit = false"
        @send="receive($event)"
      ></edit-skill>
    </v-dialog>
    <v-row no-gutters>
      <v-col>
        スキルマスタ一覧
      </v-col>
      <v-spacer></v-spacer>
        <v-col cols="2">
          <v-btn dense block @click="modal.register = true">新規作成</v-btn>
        </v-col>
    </v-row>
    <v-row dense>
      <v-col v-for="n in 5" :key="n">
        <v-row no-gutters>
          <v-col class="subtitle-2">
            {{ n | skillCategoryType }}
          </v-col>
        </v-row>
        <v-row no-gutters>
          <v-col>
            <v-data-table
              dense
              :headers="headers"
              :items="technicalSkillItems(n)"
              class="elevation-1"
              hide-default-footer
            >
              <template v-slot:[`item.action`]="{ item }">
                <v-icon
                  small
                  class="mr-2"
                  @click="edit(item)"
                >
                  mdi-pencil
                </v-icon>
              </template>
            </v-data-table>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
import AddSkill from "@/Pages/System/AddSkill.vue";
import EditSkill from "@/Pages/System/EditSkill.vue";
export default {
  name: 'system-list',
  layout: Layout,
  mixins: [ ViewBasic ],
  components: { AddSkill, EditSkill },
  props:{
    skill_master: { type: Array, default: [] }
  },
  data() {
    return {
      modal: {
        register: false,
        edit: false
      },
      headers: [
        { text: '技術名', value: 'skill_name' },
        { text: '状態', value: 'skill_status' },
        { text: '', value: 'action', sortable: false }
      ],
      item: {},
    }
  },
  computed: {
    technicalSkillItems() {
      return n => { return this.skill_master.filter(e => e.skill_category === n) }
    },
  },
  methods: {
    edit(item) {
      this.item = item
      this.modal.edit = true
    },
  }
}
</script>