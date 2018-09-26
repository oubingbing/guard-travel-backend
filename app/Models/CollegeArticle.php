<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/20 0020
 * Time: 10:19
 */

namespace App\Models;


class CollegeArticle extends BaseModel
{
    const TABLE_NAME = 'college_articles';
    protected $table = self::TABLE_NAME;

    const FIELD_ID = 'id';

    const FIELD_ID_POSTER = 'poster_id';

    const FIELD_TITLE = 'title';

    const FIELD_COVER_IMAGE = 'cover_image';

    const FIELD_CONTENT = 'content';

    /** 文章类型，1=大学成长记，2=日记 */
    const FIELD_TYPE = 'type';

    const FIELD_STATUS = 'status';

    /** 大学成长记 **/
    const ENUM_COLLEGE_NOTE = 1;
    /** 日记 */
    const ENUM_NOTE = 2;

    protected $casts = [
        self::FIELD_COVER_IMAGE => 'array',
    ];

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_POSTER,
        self::FIELD_TITLE,
        self::FIELD_COVER_IMAGE,
        self::FIELD_CONTENT,
        self::FIELD_TYPE,
        self::FIELD_STATUS
    ];

}