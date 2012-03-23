boundio PHP Library
====
boundio PHP library は、PHPでboundioを利用する際に役に立つクラスを提供します。

API
--------
以下のAPIに対応しています。

* call
* status
* file/post

利用方法
--------

    // 認証情報設定
    Boundio::configure('userSerialId', '[ユーザーシリアルID]');
    Boundio::configure('appId', '[アプリケーションキー]');
    Boundio::configure('authKey', '[ユーザー認証キー]');

    // 電話発信
    Boundio::call('03-1234-5678', array('file(000001)', 'num(4), 'silent()', 'file(000002)'));

Functions
--------

* **configure** (*string $key, string $val*)
* **call** (*string $tel_to, array $casts*)<br />
  指定された電話番号へ発信
* **status** (*string $id, string $start, string $end*)<br />
  指定されたIDまたは期間の履歴を取得します
* **file** (*string $text, string $filepath, string $filename*)<br />
  指定された文字を合成したり、ファイルをアップロードします。