# boundio PHP Library
boundio PHP library は、PHPでboundioを利用する際に役に立つクラスを提供します。

### API

以下のAPIに対応しています。

* call
* status
* file/post

### 利用例

    // 認証情報設定
    Boundio::configure('userSerialId', '[ユーザーシリアルID]');
    Boundio::configure('appId', '[アプリケーションキー]');
    Boundio::configure('authKey', '[ユーザー認証キー]');

    // 電話発信
    Boundio::call('03-1234-5678', array('file(000001)', 'num(4), 'silent()', 'file(000002)'));
