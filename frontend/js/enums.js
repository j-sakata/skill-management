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
  NATIONAL: "国家資格",
  PUBLIC: "公的資格",
  PRIVATE: "民間資格",
}

// 資格区分2
export const CertificationSubCategoryType = {
  IT: "情報",
  FINANCE: "金融",
  OTHER: "その他",
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