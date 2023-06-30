<template>
  <v-container fluid>
    <v-card class="ma-2" outlined v-if="selected">
			<v-card-text class="pb-1">
				未実装
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="grey lighten-4 pa-1">
				<v-row dense>
					<v-col cols="3" offset="9">
						<v-btn
							color="indigo darken-2"
							dark
							block
							small
							@click="addDate()"
						>
							取得日追加
						</v-btn>
					</v-col>
				</v-row>
			</v-card-actions>
		</v-card>
  </v-container>
</template>

<script>
import ViewBasic from "@/Shared/view-basic";
import Layout from '@/Layout/Layout.vue';
export default {
  name: 'experience-detail',
  layout: Layout,
  mixins: [ ViewBasic ],
  props:{
    selected: { type: Object, default: {} }
  },
  data() {
    return {
		headers: [
			{text: "取得日", value: "acquisition_date"},
			{text: "スコア", value: "score"},
			{text: '', value: 'action', sortable: false}
		]
    }
  },
  computed: {
  },
  methods: {
		reverseDate(array) {
			return Array.prototype.reverse.call(array);
		},
		edit() {
			this.$emit("edit");
		},
		addDate() {
			this.$emit("add");
		},
		editItem (item) {
			this.$emit("change", item)
		},
		deleteItem (id) {
		},
  }
}
</script>