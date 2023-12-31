/*----------------------------------
 - plain.js -
 JS全般で利用されるグローバル処理定義
----------------------------------*/

import { Level } from "@/enums";
import Param from "@/variables";
import { Inertia as inertia } from '@inertiajs/inertia';
import dayjs from "dayjs";

// ## ログユーティリティ
// variables.jsでログ出力レベルを変更させる事が可能です。
export class Log {
  static debug(msg) {
    if (this.valid(Level.DEBUG)) this.console("[DEBUG] ", msg);
  }
  static info(msg) {
    if (this.valid(Level.INFO)) this.console("[INFO] ", msg);
  }
  static warn(msg) {
    if (this.valid(Level.WARN)) this.console("[WARN] ", msg);
  }
  static error(msg) {
    if (this.valid(Level.ERROR)) this.console("[ERROR] ", msg);
  }
  static valid(checkLevel) {
    return Param.System.logLevel <= checkLevel;
  }
  static console(prefix, obj) {
    // eslint-disable-next-line
    if (console) console.log(prefix, obj);
  }
}

// ## inertiaユーティリティ
export class Inertia {

  static get(
    url,
    success = this.handleSuccess,
    failure = this.handleFailure,
    state = true
  ) {
    inertia.form().get(url, {
      onSuccess: success,
      onError: failure,
      preserveState: state,
    })
  }

  static post(
    url,
    data = {},
    success = this.handleSuccess,
    failure = this.handleFailure,
    state = true,
  ) {
    inertia.form(data).post(url, {
      onSuccess: success,
      onError: failure,
      preserveState: state,
    })
  }

  // リクエスト成功時の標準処理を行います。
  static handleSuccess(data) {
    Log.info(data);
  }

  // リクエスト失敗時の処理を行います。
  static handleFailure(err) {
    // nothing.
  }
}


// ## 非同期API要求ユーティリティ
// リクエストは Form 戻り値はJSON形式を想定とします。
import axios from "axios";
axios.defaults.baseURL = Param.Api.root;
axios.defaults.headers.common["Expires"] = -1;
axios.defaults.headers.common["Cache-Control"] =
  "no-cache,no-store,must-revalidate,max-age=-1,private";
axios.defaults.withCredentials = true;
export class Ajax {
  // GET形式のPromiseを返します。
  static promiseGet(url, data = {}) {
    const params = new URLSearchParams();
    Object.keys(data).forEach(key => {
      if (data[key]) {
        params.append(key, data[key]);
      }
    });
    return axios.get(this.requestUrl(url), { params: params });
  }
  // GET形式でサーバ側へリクエスト処理をします。
  static get(
    url,
    data = {},
    success = this.handleSuccess,
    failure = this.handleFailure
  ) {
    this.promiseGet(url, data)
      .then(res => {
        if (success) success(res.data);
      })
      .catch(err => {
        this.handlePreFailure(err);
        if (failure) failure(err);
      });
  }
  // POST形式のPromiseを返します。
  static promisePost(url, data = {}) {
    return axios.post(this.requestUrl(url), data);
  }
  // POST形式でサーバ側へリクエスト処理をします。
  static post(
    url,
    data = {},
    success = this.handleSuccess,
    failure = this.handleFailure
  ) {
    this.promisePost(url, data)
      .then(res => {
        if (success) success(res.data);
      })
      .catch(err => {
        this.handlePreFailure(err);
        if (failure) failure(err);
      });
  }
  // POST - Form形式のPromiseを返します。
  static promisePostForm(url, data = {}) {
    const params = new URLSearchParams();
    Object.keys(data).forEach(key => params.append(key, data[key]));
    const config = {
      headers: { "Content-Type": "application/x-www-form-urlencoded" }
    };
    return axios.post(this.requestUrl(url), params, config);
  }
  // POST - FOrm形式でサーバ側へリクエスト処理をします。
  static postForm(
    url,
    data = {},
    success = this.handleSuccess,
    failure = this.handleFailure
  ) {
    this.promisePostForm(url, data)
      .then(res => {
        if (success) success(res.data);
      })
      .catch(err => {
        this.handlePreFailure(err);
        if (failure) failure(err);
      });
  }
  // アップロード形式のPromiseを返します。
  static promiseUpload(url, data = {}) {
    let form = new FormData();
    Object.keys(data).forEach(key => {
      if (data[key]) {
        form.append(key, data[key]);
      }
    });
    return axios.post(this.requestUrl(url), form);
  }
  // 指定したURLに対するアップロード処理をします。
  // 指定されたハッシュデータはFormDataへ紐付けられて送信されます。
  static upload(
    url,
    data = {},
    success = this.handleSuccess,
    failure = this.handleFailure
  ) {
    this.promiseUpload(url, data)
      .then(res => {
        if (success) success(res.data);
      })
      .catch(err => {
        this.handlePreFailure(err);
        if (failure) failure(err);
      });
  }
  // 接続先URLパスを整形します。
  static requestUrl(url) {
    // for nocache
    const time = Date.now().toString();
    if (url && 0 <= url.indexOf("?")) {
      url += "&" + time;
    } else {
      url += "?" + time;
    }
    return url;
  }
  // リクエスト成功時の標準処理を行います。
  static handleSuccess(data) {
    Log.info(data);
  }
  // リクエスト失敗時の事前処理を行います。
  static handlePreFailure(err) {
    const res = err.response;
    if (res && res.status) {
      Log.warn("[" + res.status + "] " + res.statusText);
      switch (res.status) {
        case 0:
          Log.error("接続先が見つかりませんでした");
          break;
        case 200:
          Log.error(
            "戻り値の解析に失敗しました。JSON形式で応答が返されているか確認してください"
          );
          break;
        case 400:
          Log.warn(res.data);
          break;
        case 401:
          Log.error("機能実行権限がありません");
          break;
        case 403:
          Log.error("機能実行権限がありません");
          break;
        default:
          Log.error(res.data);
      }
    } else {
      Log.error(err);
    }
  }
  // リクエスト失敗時の処理を行います。
  static handleFailure(err) {
    // nothing.
  }
}

// ## UI側セッションユーティリティ
// WebStorage(SessionStrage)利用を前提としたセッション概念を提供します。
export class Session {
  // ログインさせます。引数に与えたハッシュはWebStrage(Local)に保存されます。
  static login(sessionHash) {
    this.logout();
    this.valueSet(Param.Session.key, sessionHash);
  }
  // ログイン中のセッション情報を取得します。key未指定時はログイン情報を返します。
  static value(key = null) {
    const v = sessionStorage.getItem(key ? key : Param.Session.key);
    return v ? JSON.parse(v) : null;
  }
  // セッション情報に値を設定します。リークしやすいため、安易な利用は避けてください。
  static valueSet(key, value) {
    sessionStorage.setItem(key, value ? JSON.stringify(value) : null);
  }
  // ログアウトさせます。個別にvalueSetした情報は忘れずにdeleteしてください。
  static logout() {
    this.remove();
  }
  // セッション情報の値を削除します。
  static remove(key = null) {
    sessionStorage.removeItem(key ? key : Param.Session.key);
  }
  // セッションを持っているか
  static hasSession() {
    return this.value();
  }
}

// ## フォーマットユーティリティ
export class Formatter {
  static format(type, value) {
    switch (type) {
      case "day":
        return value ? dayjs(value).format("YYYY/MM/DD") : ""
      case "amount":
        return (value || value === 0) ? value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,') : ""
      default:
        return value.toString()
    }
  }
  static zenkakuToHan(value) {
    return value.replace(/[Ａ-Ｚａ-ｚ０-９]/g, v => String.fromCharCode(v.charCodeAt(0) - 65248))
  }
}

// ## グローバルユーティリティ
export class Utils {
  // URLの引数を解析してハッシュを返します
  static parseQuery(url = null) {
    const target = url ? url : window.location.search
    if (!target) return {}
    const idx = target.indexOf('?')
    const query = idx === -1 ? target : target.substring(idx + 1)
    const values = query.split('&')
    let ret = {}
    Array.from(values).map((v) => v.split('=')).filter((pair) => pair && pair.length === 2)
      .forEach((pair) => ret[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]))
    return ret
  }
  // 引数に与えたハッシュオブジェクトでネストされたものを「.」付の一階層へ変換します。(引数は上書きしません)
  // {a: {b: {c: 'd'}}} -> {'a.b.c': 'd'}
  // see http://stackoverflow.com/questions/19098797/fastest-way-to-flatten-un-flatten-nested-json-objects
  static flatten(data) {
    let ret = {}
    const recurse = (v, prop) => {
      if (Object(v) !== v) {
        ret[prop] = v
      } else if (Array.isArray(v)) {
        Array.from(v).forEach((value, i) => recurse(value, `prop[${i}]`))
        if (v.length === 0) ret[prop] = []
      } else {
        var empty = true
        Object.keys(v).forEach((key) => {
          const value = v[key]
          empty = false
          recurse(value, prop ? `${prop}.${key}` : key)
        })
        if (empty && prop) ret[prop] = {}
      }
    }
    recurse(data, "")
    return ret
  }
  // 開始時間と終了時間を比較し、0.25単位で出力
  static calcTimeRange(start, end) {
    if (!start || !end) {
      return null
    }
    const fromToMili = this.realDay(end).getTime() - this.realDay(start).getTime()
    const fromToHour = fromToMili / 1000 / 60 / 60
    return fromToHour.toFixed(2) - (fromToHour % 0.25).toFixed(2)
  }
  // 営業日の時間を実際の日時へ変換
  static realDay(time) {
    let hour = parseInt(time.substr(0, 2))
    let realDate = new Date()
    if (hour > 24) {
      realDate.setDate(realDate.getDate() + 1)
      hour = hour -24
    }
    realDate.setHours(hour)
    realDate.setMinutes(time.substr(2, 4))
    // 秒とミリ秒により計算の誤差が出ないように0を設定する
    realDate.setSeconds(0)
    realDate.setMilliseconds(0)
    return realDate
  }
  // ISO形式の現在日付文字列(YYYY-MM-DD)を返します。
  static today() {
    return new Date().toISOString().slice(0,10)
  }
  // 値を数値に変換して返します
  static numberValue(v) {
    if (!v) return null
    const num = Number(Formatter.zenkakuToHan(v))
    return isNaN(num) ? null : num 
  }
}
