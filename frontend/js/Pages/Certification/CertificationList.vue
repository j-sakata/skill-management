<template>
  <v-container fluid>
    <v-dialog v-model="modal.register" eager min-height="700px" width="900px" persistent scrollable>
      <certification-register
        :active="modal.register"
        :user_id="user_id"
        @hide="modal.register = false; updateItem()"
        @send="receive($event)"
      ></certification-register>
    </v-dialog>
    <v-dialog v-model="modal.edit" eager min-height="700px" width="900px" persistent scrollable>
      <certification-edit
        :active="modal.edit"
        :selected="selected"
        @hide="modal.edit = false; updateItem()"
        @send="receive($event)"
      ></certification-edit>
    </v-dialog>
    <v-dialog v-model="modal.add" eager min-height="700px" width="900px" persistent scrollable>
      <add-certification-acquisition
        :active="modal.add"
        :selected="selected"
        @hide="modal.add = false; updateItem()"
        @send="receive($event)"
      ></add-certification-acquisition>
    </v-dialog>
    <v-dialog v-model="modal.change" eager min-height="700px" width="900px" persistent scrollable>
      <edit-certification-acquisition
        :active="modal.change"
        :item="item"
        @hide="modal.change = false; updateItem()"
        @send="receive($event)"
      ></edit-certification-acquisition>
    </v-dialog>
    <v-row no-gutters>
      <v-col cols="6">
        <v-row no-gutters class="pa-4 pb-0">
          <v-col cols="9">
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
          <v-spacer></v-spacer>
          <v-col cols="2">
            <v-btn dense block @click="search">検索</v-btn>
          </v-col>
        </v-row>
      </v-col>
      <v-col cols="6">
        <v-row no-gutters class="pa-4 pb-0">
          <v-spacer></v-spacer>
          <v-col cols="2">
            <v-btn dense block @click="modal.register = true">新規作成</v-btn>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col cols="6" class="pa-5">
        <v-data-table
          :headers="headers"
          :items="cloneCertifications"
          class="elevation-1"
          dense
        >
          <template v-slot:body="{ items }">
            <tbody>
              <tr v-for="item in items" :key="item.certification_name" @click="select(item)">
                <td>{{ item.certification_name }}</td>
                <td>{{ item.certification_category | certificationCategoryType }}</td>
                <td>{{ item.certification_sub_category | certificationSubCategoryType }}</td>
              </tr>
            </tbody>
          </template>
        </v-data-table>
      </v-col>
      <v-col cols="6">
        <certification-detail
          :selected="selected"
          @edit="modal.edit = true"
          @add="modal.add = true"
          @change="change"
        ></certification-detail>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
import CertificationDetail from "@/Pages/Certification/CertificationDetail.vue";
import CertificationRegister from "@/Pages/Certification/CertificationRegister.vue";
import CertificationEdit from "@/Pages/Certification/CertificationEdit.vue";
import AddCertificationAcquisition from "@/Pages/Certification/AddCertificationAcquisition.vue";
import EditCertificationAcquisition from "@/Pages/Certification/EditCertificationAcquisition.vue";
import { clone } from "lodash";
export default {
  name: 'certification-list',
  layout: Layout,
  mixins: [ ViewBasic ],
  components: { CertificationDetail, CertificationRegister, CertificationEdit, AddCertificationAcquisition, EditCertificationAcquisition },
  props:{
    certifications: { type: [Array, Object], default: [] },
    user_id: { type: String }
  },
  data() {
    return {
      keyword: null,
      selected: [],
      modal: {
        register: false,
        edit: false,
        add: false,
        change: false
      },
      cloneCertifications: [],
      item: {},
      headers: [
        {text: "資格名", value: "certification_name"},
        {text: "区分1", value: "certification_category"},
        {text: "区分2", value: "certification_sub_category"},
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
      this.cloneCertifications = clone(this.certifications);
      this.selected = this.cloneCertifications[0]
    },
    search() {
    },
    select(item) {
      this.selected = item
    },
    change(item) {
      this.item = item
      this.modal.change = true
    },
    updateItem() {
      this.selected = this.cloneCertifications.find(e => e.id === this.selected.id)
    }
  }
}
</script>