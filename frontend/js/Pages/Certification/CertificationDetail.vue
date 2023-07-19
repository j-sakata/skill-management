<template>
  <v-container fluid>
    <v-card class="ma-2" outlined v-if="selected">
			<v-card-text class="pb-1">
				<v-row dense>
					<v-col>
						<div class="l-text-sm-2">資格名</div>
						<div>{{selected.certification_name}}</div>
					</v-col>
					<!-- <v-col cols="2">
						<div class="l-text-sm-2">状態（有効/無効）</div>
						<div>{{selected.certification_memo}}</div>
					</v-col> -->
					<div fixed right>
						<v-menu left bottom>
							<template v-slot:activator="{ on, attrs }">
								<v-btn icon v-bind="attrs" v-on="on">
									<v-icon>mdi-dots-vertical</v-icon>
								</v-btn>
							</template>
							<v-list>
								<v-list-item dense @click="edit">
									<v-list-item-title>取得資格変更</v-list-item-title>
								</v-list-item>
								<!-- <v-divider v-if="canDelete"></v-divider> -->
								<!-- <v-list-item dense @click="deleteItem" v-if="canDelete">
									<v-list-item-title>取得資格削除</v-list-item-title>
								</v-list-item> -->
							</v-list>
						</v-menu>
					</div>
				</v-row>
				<v-row dense>
					<v-col cols="3">
						<div class="l-text-sm-2">資格コード</div>
						<div>{{selected.certification_code}}</div>
					</v-col>
					<v-col cols="3">
						<div class="l-text-sm-2">有効期限</div>
						<div v-if="selected.certification_expiration">{{ hasCertificationExpiration(selected.certification_expiration) }}</div>
						<div v-else>-</div>
					</v-col>
					<v-col cols="3">
						<div class="l-text-sm-2">区分1</div>
						<div>{{selected.certification_category | certificationCategoryType}}</div>
					</v-col>
					<v-col cols="3">
						<div class="l-text-sm-2">区分2</div>
						<div>{{selected.certification_sub_category | certificationSubCategoryType}}</div>
					</v-col>
				</v-row>
				<v-row dense>
					<v-col>
						<v-data-table
							:items-per-page="5"
							:headers="headers"
							:items="reverseDate(selected.acquisition)"
							dense
						>
							<template v-slot:body="{ items }">
								<tbody>
									<tr v-for="item in items" :key="item.acquisition_date" >
										<td>{{ item.acquisition_date }}</td>
										<td>{{ hasScore(item.score) }}</td>
										<td>
											<v-icon
												small
												class="mr-2"
												@click="editItem(item)"
											>
												mdi-pencil
											</v-icon>
											<v-icon
												small
												disabled
												@click="deleteItem(item)"
											>
												mdi-delete
											</v-icon>
										</td>
									</tr>
								</tbody>
							</template>
						</v-data-table>
					</v-col>
				</v-row>
				<v-row dense>
					<v-col>
						<div class="l-text-sm-2">備考</div>
						<div>{{selected.certification_memo}}</div>
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
export default {
  name: 'certification-detail',
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
		hasCertificationExpiration() {
			return year => { return year ? year + "年間" : "-" }
		},
		hasScore() {
			return score => { return score ? score : "-" }
		}
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