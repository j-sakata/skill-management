import { Level, ActionEvent } from '@/enums';
import * as Lib from '@/Shared/plain.js';
import Vue from 'vue';

/**
 * View コンポーネントのベーシックな Mixin。
 * 親パネルの他、ファイルアップロードや確認ダイアログ/単純表示等、シンプルな処理が必要なときなどに利用してください。
 * 本クラスを利用する際は初期化時に以下の設定が必要です。
 * ---
 * - 標準API
 * clear: グローバルエラー及び/コントロールエラーを初期化する
 * apiFailure: API実行時の標準例外ハンドリング
 * file: type=fileの値参照を返す。apiUploadのdata値へ設定する際に利用
 * files: type=fileの値参照一覧を返す。
 * flattenItem: 引数に与えたハッシュオブジェクトを結合文字列へ変換する
 * paramArray: 配列(オブジェクト)をフラットなパラメタ要素へ展開
 * renderWarning: 例外情報を画面へ反映する
 * renderColumnWarning: コントロール単位の画面例外反映
 */
export default {
  data() {
    return {
      updating: false,
      logined: false,
      user: { id: "unknown", name: "Anonymous", groups: [], authorities: [] },
      messages: {
        global: null,
        globalKey: null,
        level: Level.ERROR,
        columns: {},
      },
    };
  },
  props: {
    data: { type: [Object, Array] },
    error: { type: Object, default: null },
    reply: { type: String },
  },
  components: {
  },
  created() {
    this.clear();
    const current = Lib.Session.value();
    if (current) {
      this.user = current;
    }
    window.EventEmitter.$on(ActionEvent.Login, v => {
      this.user = v;
      this.logined = true;
    });
    window.EventEmitter.$on(ActionEvent.Logout, v => {
      this.user = null;
      this.logined = false;
      Lib.Session.logout();
      Lib.Log.debug("ログアウトしました");
    });
    window.EventEmitter.$on(ActionEvent.Messages, v => this.handleMessages(v));
  },
  methods: {
    componentName() {
      const name = this.$options.name;
      return name ? name : "";
    },
    // メッセージを通知します。
    message(globalMessage = null, columnMessages = {}, level = Level.INFO) {
      let messages = {
        global: globalMessage,
        componentKey: this.componentName(),
        columns: columnMessages,
        level: level
      };
      if (globalMessage) Lib.Log.debug(messages);
      window.EventEmitter.$emit(ActionEvent.Messages, messages);
    },
    // エラーメッセージを通知します。
    messageError(globalMessage, columnMessages = {}, level = Level.ERROR) {
      this.message(globalMessage, columnMessages, level);
    },
    // エラーメッセージを処理します。
    handleMessages(messages) {
      this.messages = {
        global: null,
        componentKey: this.componentName(),
        columns: {},
        level: Level.INFO
      }; // init
      this.$nextTick(() => this.messages = messages);
    },
    // グローバルエラー及び/コントロールエラーを初期化します
    clear() {
      this.clearMessage();
      this.clearFile();
    },
    clearMessage() {
      this.message();
    },
    // ファイルオブジェクトを取得します。apiUpload時のdataへ設定するアップロード値を取得する際に使用してください。
    file(query = 'input[type="file"]') {
      return this.files(query)[0];
    },
    files(query = 'input[type="file"]') {
      let inputs = this.$el.querySelectorAll(query);
      let ret = new Array(inputs.length);
      let i = 0;
      Array.from(inputs).forEach(input => {
        ret[i] = input.files[0];
        i++;
      });
      return ret.filter(v => v);
    },
    // ファイル配列(オブジェクト)をフラットなハッシュオブジェクトへ展開します
    // 直接オブジェクトへ上書きしたい際は第3引数にハッシュオブジェクトを渡してください。
    // {files: [FileObject, FileObject]} -> {'files[0]': FileObject, 'files[1]': FileObject}
    // ※ajax/SpringMVCでMultipartRequestが取得可能な状態にします。
    filesArray(keyName = "files", query = 'input[type="file"]', ret = {}) {
      let i = 0;
      Array.from(this.files(query)).forEach(file => {
        let k = `${keyName}[${i}]`;
        ret[k] = file;
        i++;
      });
      return ret;
    },
    clearFile(query = 'input[type="file"]') {
      if (!this.$el) {
        return;
      }
      Array.from(this.$el.querySelectorAll(query)).forEach(el => {
        el.value = '';
      });
    },
    // fnLoad でイメージを読み込みます(引数は { type: dataType, data: Base64str, src: imageSrc})
    // width には最大サイズ(px の数字)を指定してください。自動的にそのサイズへリサイズします。
    loadImage(file, width, fnLoad) {
      if (file) {
        const img = new Image();
        const reader = new FileReader();
        reader.onload = event => {
          img.onload = () => {
            const dataType = file.type;
            // for resize check;
            let data;
            let height = img.height;
            if (width < img.width) {
              height = img.height * (width / img.width);
              const canvas = document.createElement('canvas');
              canvas.height = height;
              canvas.width = width;
              canvas.getContext('2d').drawImage(img, 0, 0, width, height)
              const base64src = canvas.toDataURL(file.type);
              data = base64src.split(';base64,')[1];
            } else {
              data = event.target.result.split(';base64,')[1];
            }
            fnLoad({ type: dataType, data: data, src: this.imageSrc(dataType, data) })
          }
          img.src = event.target.result;
        }
        reader.readAsDataURL(file);
      } else {
        fnLoad({ type: null, data: null });
      }
    },
    imageSrc(dataType, data) {
      return "data:" + dataType + ";base64," + data;
    },
    // 引数に与えたハッシュオブジェクトでネストされたものを「.」付の一階層へ変換します。(引数は上書きしません)
    // {a: {b: {c: 'd'}}} -> {'a.b.c': 'd'}
    flattenItem(item) {
      return Lib.Utils.flatten(item);
    },
    // 配列(オブジェクト)をフラットなパラメタ要素へ展開します
    // 直接オブジェクトへ上書きしたい際は第3引数にハッシュオブジェクトを渡してください。
    // [{k: 'a'}, {k: 'b'}] -> {'params[0].k': 'a', 'params[1].k': 'b'}
    // ※ajax/SpringMVCでのネスト値不具合を解消します。
    // see http://stackoverflow.com/questions/5900840/post-nested-object-to-spring-mvc-controller-using-json
    paramArray(array, keyName = "params", ret = {}) {
      let i = 0;
      Array.from(array).forEach(param => {
        Object.keys(param).forEach(key => {
          let k = `${keyName}[${i}].${key}`;
          ret[k] = param[key];
        });
        i++;
      });
      return ret;
    },
    // 指定した要素IDへ移動します。
    scrollTo(id, smooth = false) {
      const target = document.getElementById(id);
      if (target) {
        target.scrollIntoView({ behavior: smooth ? "smooth" : "auto" });
      }
    },
    // api Action Support
    actionSuccess(v, successMessage = "処理が成功しました") {
      Lib.Log.debug("success");
      this.message(successMessage, [], Level.INFO);
    },
    actionFailure(error) {
      console.log(error)
      let message = null;
      let columns = [];
      let level = Level.ERROR;
      const status = error.response ? error.response.status : 404;
      switch (status) {
        case 200: {
          message = "要求処理は成功しましたが、戻り値の解析に失敗しました";
          break;
        }
        case 400: {
          const parsed = this.parseApiError(error);
          if (parsed.global) {
            Lib.Log.debug(parsed.global);
          }
          message = parsed.global
            ? parsed.global
            : "入力情報を確認してください";
          level = Level.WARN;
          columns = parsed.columns;
          break;
        }
        case 401: {
          message = "機能実行権限がありません";
          break;
        }
        case 404: {
          if (error.response && error.response.data && error.response.data.path === '/api/login') {
            // 有効期限切れ
            window.EventEmitter.$emit(ActionEvent.Logout);
            this.$router.push('/timeout');
            return;
          } else {
            message = "要求処理に失敗しました";
          }
          break;
        }
        default: {
          message = "要求処理に失敗しました";
        }
      }
      this.message(message, columns, level);
      this.updating = false;
    },
    parseApiError(error) {
      let errs = error.response.data;
      let parsed = { global: null, columns: {} };
      Object.keys(errs).forEach(err => {
        if (err) {
          parsed.columns[err] = errs[err];
        } else {
          parsed.global = errs[err];
        }
      });
      return parsed;
    },
    hasAuthority(authority) {
      if (this.user && this.user.authorities) {
        return this.user.authorities.includes(authority);
      } else {
        return false;
      }
    },
    // 強制的にWindowのリサイズイベントを発行します。ListGroup 利用時などに使用してください。
    emitWindowResize() {
      Vue.nextTick().then(() => {
        window.dispatchEvent(new Event('resize'));
      });
    },
    // items 内の選択要素 (selected) を forward (Number) 数だけ移動したものを返します。
    moveSelectedItem(items, selected, forward) {
      if (!selected) {
        return items.length != 0 ? items[0] : null;
      }
      const idx = items.indexOf(selected) + forward;
      if (0 <= idx && idx < items.length) {
        return items[idx];
      } else {
        return selected;
      }
    },
    classStatusBackground(status) {
      const data = {}
      if (!status) {
        return data
      }
      data['l-bg-' + status.toLowerCase()] = true
      return data;
    },
    classStatusBorder(status) {
      const data = {}
      if (!status) {
        return data
      }
      data['l-bc-' + status.toLowerCase()] = true
      return data;
    },
    classStatusBadge(status) {
      const data = { badge: true }
      if (!status) {
        return data
      }
      data['l-badge-' + status.toLowerCase()] = true
      return data;
    },
  }
};
