/*----------------------------------
 Vue.jsのカスタムフィルタ定義
 カスタムフィルタは変数を表示する際に値のフォーマッティングなどを可能にします。
 例: {{createDay | day}}
 参考:
 http://jp.vuejs.org/guide/custom-filter.html
 https://github.com/vuejs/vue/issues/2756
----------------------------------*/

import dayjs from "dayjs"
import {
  CertificationCategoryType,
  CertificationSubCategoryType
} from "@/enums";

// 日付を「/」区切りのフォーマットへ変換します。
export function day(v) {
  return v ? dayjs(v).format('YYYY/MM/DD') : '-'
}

// 日付を「年月日」形式のフォーマットへ変換します。
export function dayJp(v) {
  return v ? dayjs(v).format('YYYY年MM月DD日') : '-'
}

// 日時型を「yyyy/MM/dd hh:mm」形式へ変換します。引数にtrueを指定したときは秒も含めます。
export function date(v, s = 'true') {
  var fmt = 'YYYY/MM/DD HH:mm'
  if (s === 'true') fmt = `${fmt}:ss`
  return v ? dayjs(v).format(fmt) : '-'
}

// for enum
export function certificationCategoryType(type) {
  const lbl = CertificationCategoryType[type]
  return lbl ? lbl : "-"
}

export function certificationSubCategoryType(type) {
  const lbl = CertificationSubCategoryType[type]
  return lbl ? lbl : "-"
}
