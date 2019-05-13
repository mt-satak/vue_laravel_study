<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Photo extends Model
{
    /** プライマリキーの型 */
    protected $keyType = 'string';

    /** IDの桁数 */
    const ID_LENGTH = 12;

    /** JSONに"明示的に"含める属性 */
    protected $appends = [
        // ユーザー定義のアクセサはデフォルトではJSONに含まれないため(リレーションも)
        'url',
    ];

    /** JSONに含める属性($hiddenの逆) */
    protected $visible = [
        'id', 'owner', 'url', 'comments',
    ];

    // ↑↓は同義

//    /** 登録項目はJSONに含めない属性(それ以外は基本ルールに従う) */
//    protected $hidden = [
//        // 元からある属性はデフォルトでJSONに含まれるがいらないものは除外することができる
//        'user_id', 'filename', self::CREATED_AT, self::UPDATED_AT,
//    ];

    // 1ページあたりの項目数
    protected $perPage = 5;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (!array_get($this->attributes, 'id')) {
            $this->setId();
        }
    }

    /**
     * ランダムなID値をid属性に代入する
     *
     * @return void
     * @throws \Exception
     */
    private function setId()
    {
        $this->attributes['id'] = $this->getRandomId();
    }


    /**
     * ランダムなID値を生成する
     *
     * @return string
     * @throws \Exception
     */
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'), range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);
        $id = '';

        for ($i = 0; $i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }

    /**
     * アクセサ - url
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        // S3 上のファイルの公開URLを返却する
        return Storage::cloud()->url($this->attributes['filename']);
    }

    /**
     * リレーションシップ - usersテーブル
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    /**
     * リレーションシップ - commentsテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }
}
