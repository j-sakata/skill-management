<style>
.v-expansion-panel-content{
	max-height:310px;
}
</style>
<template>
  <v-container fluid>
    <v-card class="ma-2" outlined v-if="selected" max-height="580">
			<v-card-text v-if="detailType === 'jobCareer'">
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
								<v-col>
									<div class="l-text-sm-2">所属会社</div>
									<div>{{ selected.company_name }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">期間</div>
									<div v-if="selected.experience_content.ended_at">{{ selected.experience_content.started_at }} ～ {{ selected.experience_content.ended_at }}</div>
									<div v-else>{{ selected.experience_content.started_at }} ～ 現在</div>
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
									<div>{{ selected.experience_content.contract_type | contractType }}</div>
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
									<div>{{ getPhaseName(selected.experience_phase) }}</div>
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
									<div class="l-text-sm-2">言語/API</div>
									<div>{{ getSkillName(1) }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">フレームワーク、DB等</div>
									<div>{{ getSkillName(2) }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">OS、クラウド等</div>
									<div>{{ getSkillName(3) }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">ルータ、NW技術等</div>
									<div>{{ getSkillName(4) }}</div>
								</v-col>
							</v-row>
							<v-row dense>
								<v-col>
									<div class="l-text-sm-2">プロジェクト支援</div>
									<div>{{ getSkillName(5) }}</div>
								</v-col>
							</v-row>
						</v-expansion-panel-content>
					</v-expansion-panel>
				</v-expansion-panels>
			</v-card-text>
			<v-card-text v-if="detailType === 'jodSummary'">
				<v-row dense>
					<v-col cols="9">
						<div class="l-text-sm-2">タイトル</div>
						<div>{{ selected.title }}</div>
					</v-col>
					<v-col cols="3">
						<div class="l-text-sm-2">状態</div>
						<div>{{ selected.status | statusType }}</div>
					</v-col>
				</v-row>
				<v-row>
					<v-col>
						<div class="l-text-sm-2">本文</div>
						<div>{{ selected.summary }}</div>
					</v-col>
				</v-row>
			</v-card-text>
			<v-card-text v-if="detailType === 'jobKnowledge'">
				活かせる経験・知識/TBD
			</v-card-text>
			<v-card-text v-if="detailType === 'character'">
				自己PR/TBD
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
import { PhaseType } from "@/enums";
export default {
  name: 'experience-detail',
  mixins: [ ViewBasic ],
  props:{
    selected: { type: [Array, Object], default: [] },
	skillMaster: { type: [Array, Object], default: [] },
	detailType: { type: String }
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
			if(this.detailType !== "jobCareer") {
				switch (this.detailType) {
					case "jodSummary":
						item = 3
						break
					case "jobKnowledge":
						item = 4
						break
					case "character":
						item = 5
						break
				}
			}
			this.$emit("edit", item);
		},
		skillIdList() {
			return this.selected.technical_skill.map(e => e.skill_id)
		},
		technicalSkill(category) {
			const skillIdList = this.skillIdList()
			return this.skillMaster.filter(e => e.skill_category == category && skillIdList.includes(e.id))
		},
		getSkillName(category) {
			const list = this.technicalSkill(category);
			return list.map(e => e.skill_name).join('、')
		},
		getPhaseName(phase_list) {
			const list = phase_list.map(e => e.phase_id);
			return Object.entries(PhaseType).filter(e => list.includes(e[0])).map(n => n[1]).join('、');
		}
  }
}
</script>