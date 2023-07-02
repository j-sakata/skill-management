<style>
	.v-expansion-panel-content{
		max-height:310px;
	}
</style>
<template>
  <v-container fluid>
    <v-card class="ma-2" outlined v-if="selected" max-height="580">
			<v-card-text>
				<v-expansion-panels
					hover
					accordion
					v-model="panel"
				>
					<v-expansion-panel>
						<v-expansion-panel-header>
							基本情報
						</v-expansion-panel-header>
						<v-expansion-panel-content class="overflow-y-auto">
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">プロジェクト名</div>
									<div>{{ selected.experience_content.project_name }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">業界</div>
									<div>{{ selected.experience_content.industry }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">期間</div>
									<div>{{ selected.experience_content.started_at }} ～ {{ selected.experience_content.ended_at }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">規模</div>
									<div>全 {{ selected.experience_content.member_count }} 人</div>
								</v-col>
								<v-col>
									<div class="l-text-sm-2">役職</div>
									<div>{{ selected.experience_content.position }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col cols="6">
									<div class="l-text-sm-2">契約形態</div>
									<div>{{ selected.experience_content.contract_type }}</div>
								</v-col>
								<v-col cols="6">
									<div class="l-text-sm-2">（派遣先）企業名</div>
									<div>{{ selected.experience_content.company_name }}</div>
								</v-col>
							</v-row>
						</v-expansion-panel-content>
					</v-expansion-panel>
					<v-expansion-panel>
						<v-expansion-panel-header>
							活動内容
						</v-expansion-panel-header>
						<v-expansion-panel-content class="overflow-y-auto">
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">プロジェクト概要</div>
									<div>{{ selected.experience_content.project_summary }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">担当フェーズ</div>
									<div>{{ selected.experience_content.phase }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">業務内容</div>
									<div>{{ selected.experience_content.description }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">実績・取り組み</div>
									<div>{{ selected.experience_content.achievement }}</div>
								</v-col>
							</v-row>
						</v-expansion-panel-content>
					</v-expansion-panel>
					<v-expansion-panel>
						<v-expansion-panel-header>
							開発環境
						</v-expansion-panel-header>
						<v-expansion-panel-content class="overflow-y-auto">
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">言語</div>
									<div>{{ selected.technical_skill }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">OS</div>
									<div>{{ selected.technical_skill }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">DB</div>
									<div>{{ selected.technical_skill}}</div>
								</v-col>
							</v-row>
						</v-expansion-panel-content>
					</v-expansion-panel>
				</v-expansion-panels>
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
							:disabled="panel==null"
							@click="edit(panel)"
						>
							変更
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
  name: 'experience-detail',
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
			],
			panel: 0,
    }
  },
  computed: {
  },
  methods: {
		reverseDate(array) {
			return Array.prototype.reverse.call(array);
		},
		edit(item) {
			this.$emit("edit", item);
		},
		deleteItem (id) {
		},
  }
}
</script>