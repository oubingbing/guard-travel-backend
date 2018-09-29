<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/28 0028
 * Time: 15:54
 */

namespace App\Http\Service;


use App\Models\Note;
use App\Models\NoteCategory as Model;
use App\Models\NoteCategory;

class NoteCategoryService
{
    /**
     * 保存日记簿
     *
     * @author yezi
     * @param $userId
     * @param $name
     * @param $type
     * @return mixed
     */
    public function create($userId,$name,$type)
    {
        $result = Model::create([
            Model::FIELD_ID_WEB_USER=>$userId,
            Model::FIELD_NAME=>$name,
            Model::FIELD_TYPE=>$type
        ]);

        return $result;
    }

    /**
     * 检测名字是否重复
     *
     * @author yezi
     * @param $userId
     * @param $name
     * @return bool
     */
    public function checkRepeat($userId,$name)
    {
        $result = $this->findByUserAndName($userId,$name);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 根据用户和笔记簿的名字查询
     *
     * @author yezi
     * @param $userId
     * @param $name
     * @return \Illuminate\Database\Eloquent\Model|null|object|static
     */
    public function findByUserAndName($userId,$name)
    {
        $result = Model::query()->where(Model::FIELD_ID_WEB_USER,$userId)->where(Model::FIELD_NAME,$name)->first();
        return $result;
    }

    /**
     * 获取笔记簿
     *
     * @author yezi
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getNoteCategories($userId)
    {
        $result = Model::query()
            ->with([Model::REL_NOTE=>function($query){
                $query->select([
                    Note::FIELD_ID,
                    Note::FIELD_ID_CATEGORY,
                    Note::FIELD_TITLE,
                    Note::FIELD_TYPE
                ]);
            }])
            ->where(Model::FIELD_ID_WEB_USER,$userId)
            ->select([
                Model::FIELD_ID,
                Model::FIELD_NAME,
                Model::FIELD_TYPE
            ])
            ->orderBy(Model::FIELD_CREATED_AT,'ASC')
            ->get();

        return $result;
    }

    public function formatSingle($item)
    {
        if(!isset($item[Model::REL_NOTE])){
            $noteService = app(NoteService::class);
            $item->{Model::REL_NOTE}->map(function ($note)use($noteService){
                return $noteService->formatSingle($note);
            });
        }

        return $item;
    }

}