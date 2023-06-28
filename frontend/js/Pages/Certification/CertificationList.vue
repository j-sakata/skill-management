<template>
  <v-container fluid>
    <v-dialog v-model="modal.register" eager min-height="700px" width="900px" persistent scrollable>
      <certification-register
        :active="modal.register"
        :user_id="user_id"
        @hide="modal.register = false"
        @send="receive($event)"
      ></certification-register>
    </v-dialog>
    <v-dialog v-model="modal.edit" eager min-height="700px" width="900px" persistent scrollable>
      <certification-edit
        :active="modal.edit"
        :selected="selected"
        @hide="modal.edit = false"
        @send="receive($event)"
      ></certification-edit>
    </v-dialog>
    <v-row no-gutters>
      <v-col cols="6">
        <v-row no-gutters>
          <v-col cols="10">
            <v-text-field
              v-model="keyword"
              label="キーワード"
              outlined
              persistent-placeholder
              clearable
              dense
              hide-details="auto"
            ></v-text-field>
          </v-col>
          <v-col cols="2">
            <v-btn dense block @click="search">検索</v-btn>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="6">
        <v-row no-gutters>
          <v-spacer></v-spacer>
          <v-col cols="2">
            <v-btn dense block @click="modal.register = true">新規作成</v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col cols="6">
        <v-data-table
          :headers="headers"
          :items="certifications"
          class="elevation-1"
          @click:row="select"
          dense
        >
          <template v-slot:items="props">
            <td>{{ props.item.name }}</td>
            <td>{{ props.item.category | certificationCategoryType }}</td>
            <td>{{ props.item.sub_category | certificationSubCategoryType }}</td>
            <td>{{ props.item.created_at }}</td>
          </template>
        </v-data-table>
      </v-col>
      <v-col cols="6">
        <certification-detail
          :selected="selected"
          @modalOpen="modal.edit = true"
        ></certification-detail>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
import { CertificationCategoryType, CertificationSubCategoryType } from "@/enums";
import CertificationDetail from "@/Pages/Certification/CertificationDetail.vue";
import CertificationRegister from "@/Pages/Certification/CertificationRegister.vue";
import CertificationEdit from "@/Pages/Certification/CertificationEdit.vue";
export default {
  name: 'certification-list',
  layout: Layout,
  mixins: [ ViewBasic ],
  components: { CertificationDetail, CertificationRegister, CertificationEdit },
  props:{
    certifications: { type: Array, default: [] },
    user_id: { type: String }
  },
  data() {
    return {
      keyword: null,
      selected: [],
      modal: {
        register: false,
        edit: false
      },
      headers: [
        {text: "資格名", value: "name"},
        {text: "区分1", value: "category"},
        {text: "区分2", value: "sub_category"},
        {text: "取得日（仮置き）", value: "created_at"}
      ]
    }
  },
  mounted() {
    this.init();
  },
  computed: {
  },
  methods: {
    init() {
      this.selected = this.certifications[0]
    },
    search() {
    },
    select(item) {
      this.selected = item
    }
  }
}
</script>