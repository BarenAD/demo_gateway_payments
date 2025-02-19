<?php

namespace App\Models;

use App\Helpers\LangUtils;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property array $translateColumns
 * @property string $translateTable
 * @property string $translateClass
 * @property string $translateForeignColumn
 *
 * @method static withTranslate()
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
abstract class ModelTranslations extends Model
{
    protected array $translateColumns;
    protected string $translateTable;
    protected string $translateClass;
    protected string $translateForeignColumn;

    protected static function boot()
    {
        parent::boot();

        static::saved(function (self $model) {
            $model->updateTranslation($model->only($model->translateColumns));
        });
    }

    public function updateTranslation(array $params, int $langId = null)
    {
        $langId = empty($langId) ? LangUtils::getLocaleId() : $langId;
        $model = $this->translateClass::updateOrCreate(
            ['lang_id' => $langId, $this->translateForeignColumn => $this->id],
            array_merge(
                $params,
                [
                    'lang_id' => $langId,
                    $this->translateForeignColumn => $this->id,
                ]
            )
        );
        foreach ($this->translateColumns as $column) {
            $this->$column = $model->$column;
        }
        return $model;
    }
    public function addTranslation(array $params, int $langId = null)
    {
        $langId = empty($langId) ? LangUtils::getLocaleId() : $langId;
        $model = $this->translateClass::create(array_merge(
            $params,
            [
                'lang_id' => $langId,
                $this->translateForeignColumn => $this->id,
            ]
        ));
        foreach ($this->translateColumns as $column) {
            $this->$column = $model->$column;
        }
        return $model;
    }
    public function scopeWithTranslate(Builder $query)
    {
        $columns = [$this->table . '.*'];
        foreach ($this->translateColumns as $column) {
            $columns[] = DB::raw("COALESCE(needle_translation.$column, default_translation.$column, $this->table.$column) as $column");
        }
        return $query
            ->addSelect($columns)
            ->leftJoin("$this->translateTable as needle_translation", function ($join) {
                $join->on("$this->table.id", "needle_translation.$this->translateForeignColumn");
                $join->on("needle_translation.lang_id","=", DB::raw(LangUtils::getLocaleId()));
            })
            ->leftJoin("$this->translateTable as default_translation", function ($join) {
                $join->on("$this->table.id", "default_translation.$this->translateForeignColumn");
                $join->on("default_translation.lang_id","=", DB::raw(LangUtils::getFallbackLocaleId()));
            });
    }
}
