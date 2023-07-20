/*----------------------------------
 - constants.js -
 JS全般で利用される定数
----------------------------------*/

// ログレベル定数
export const Level = {
  DEBUG: 10,
  INFO: 20,
  WARN: 30,
  ERROR: 40,
}

// イベント定数
export const ActionEvent = {
  Login: "vue-event-login",
  Logout: "vue-event-logout",
  Messages: "vue-event-messages",
}

// 処理状態
export const ActionStatusType = {
  UNPROCESSED: "未処理",
  PROCESSING: "処理中",
  PROCESSED: "処理済",
  CANCELLED: "取消",
  ERROR: "エラー"
}

// プロジェクト定数
// 権限
export const AuthorityType = {
  Admin: "管理者",
  General: "一般",
}

// 資格区分1
export const CertificationCategoryType = {
  1: "国家資格",
  2: "公的資格",
  3: "民間資格",
}

// 資格区分2
export const CertificationSubCategoryType = {
  1: "情報",
  2: "金融",
  99: "その他",
}

// 技術要素区分
export const SkillCategoryType = {
  1: "言語/API",
  2: "フレームワーク",
  3: "OS、クラウド",
  4: "ルータ、NW技術等",
  5: "プロジェクト支援"
}

// 契約形態
export const ContractType = {
  1: "請負",
  2: "準委任(SES)",
  3: "派遣",
  4: "社内"
}

// 状態
export const StatusType = {
  0: "無効",
  1: "有効",
}

// フェーズ
export const PhaseType = {
  C: "情報システム経営コンサルティング",
  R: "要件定義",
  A: "調査分析",
  B: "プロジェクト計画",
  I: "基本設計",
  L: "論理設計",
  S: "構造設計",
  D: "詳細設計",
  P: "プログラム製造",
  T: "システムテスト",
  O: "運用保守支援",
  E: "環境整備",
  F: "ファイリング・ドキュメンテーション",
  K: "教育・研修",
  M: "プロジェクト管理",
  H: "その他業務支援",
}