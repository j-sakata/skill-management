<template>
  <v-container fluid>
    <v-card class="ma-2" outlined v-if="selected">
			<v-card-text class="pb-1">
				<v-row dense>
					<v-col>
						<div class="l-text-sm-2">id</div>
						<div>{{selected.name}}</div>
					</v-col>
					<div fixed right>
						<v-menu left bottom>
							<template v-slot:activator="{ on, attrs }">
								<v-btn icon v-bind="attrs" v-on="on">
									<v-icon>mdi-dots-vertical</v-icon>
								</v-btn>
							</template>
							<v-list>
								<v-list-item dense @click="modalOpen">
									<v-list-item-title>取得資格変更</v-list-item-title>
								</v-list-item>
								<v-divider v-if="canDelete"></v-divider>
								<v-list-item dense @click="deleteItem" v-if="canDelete">
									<v-list-item-title>取得資格削除</v-list-item-title>
								</v-list-item>
							</v-list>
						</v-menu>
					</div>
				</v-row>
				<v-row dense>
					<v-col cols="3">
						<div class="l-text-sm-2">資格コード</div>
						<div>{{selected.name}}</div>
					</v-col>
					<v-col cols="3">
						<div class="l-text-sm-2">有効期限</div>
						<div>{{selected.category}}</div>
					</v-col>
				</v-row>
				<v-row dense>
					<v-col>
						<div class="l-text-sm-2">区分1</div>
						<div>{{selected.category}}</div>
					</v-col>
					<v-col>
						<div class="l-text-sm-2">区分2</div>
						<div>{{selected.sub_category}}</div>
					</v-col>
				</v-row>
				<v-row dense>
					<v-col>
						<div class="l-text-sm-2">備考</div>
						<div>{{selected.memo}}</div>
					</v-col>
				</v-row>
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
							@click="show"
						>
							ボタン
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
  name: 'certification-detail',
  layout: Layout,
  mixins: [ ViewBasic ],
  props:{
    selected: { type: Array, default: [] }
  },
  data() {
    return {
    }
  },
  methods: {
		modalOpen() {
			this.$emit("modalOpen");
	}
  }
}
</script>