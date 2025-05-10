<?php



namespace App\Models;

use App\Models\Scope\CompanyScope;
use App\Models\Traits\HasCompanyId;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Model extends BaseModel
{
    use HasCompanyId;

    public $translatable = [];

    public $searchable = [];

    protected $guarded = [];

    /**
     * @param int $company_id
     * @param array $id
     * @return bool
     */
    public static function isAllBelongsTo(int $company_id, array $id): bool
    {
        return static::whereIn('id', $id)->where('company_id', $company_id)->count()
            === count(array_unique($id));
    }

    /**
     * @param array $ids
     * @return bool
     */
    public static function isValid(array $ids): bool
    {
        return static::whereIn('id', $ids)->count() === count(array_unique($ids));
    }

    /**
     * 获得国际化名字
     *
     * @return mixed
     */
    public function getINameAttribute()
    {
        $local = app('translator')->getLocale();

        if ($local !== 'zh_CN') {
            if ($this->en_name) {
                return $this->en_name;
            }
            return $this->name_en;
        }

        return $this->name_cn ?? $this->cn_name;
    }



    /**
     * @param Builder $query
     */
    public function scopeNoCompany(Builder $query)
    {
        $query->withoutGlobalScope(CompanyScope::class);
    }

    protected static function boot()
    {
        parent::boot();


        static::addGlobalScope(new CompanyScope());

        static::creating(function ($model) {
            /**
             * @params Model $model
             */
            if (in_array('company_id', Schema::getColumnListing($model->getTable()))) {
                if ($model->company_id === null) {
                    $model->company_id = self::getCompanyId();
                }
            }
        });
    }

    /**
     * 为数组 / JSON 序列化准备日期。
     *
     * @param \DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format($this->dateFormat ?: 'Y-m-d H:i:s');
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toBaseArray()
    {
        return array_merge($this->attributesToArrayBase(), $this->relationsToArray());
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArrayBase()
    {
        // If an attribute is a date, we will cast it to a string after converting it
        // to a DateTime / Carbon instance. This is so we will get some consistent
        // formatting while accessing attributes vs. arraying / JSONing a model.
        $attributes = $this->addDateAttributesToArray(
            $attributes = $this->getArrayableAttributes()
        );

        $attributes = $this->addMutatedAttributesToArray(
            $attributes, $mutatedAttributes = $this->getMutatedAttributes()
        );

        // Next we will handle any casts that have been setup for this model and cast
        // the values to their appropriate type. If the attribute has a mutator we
        // will not perform the cast on those attributes to avoid any confusion.
        $attributes = $this->addCastAttributesToArray(
            $attributes, $mutatedAttributes
        );

        // Here we will grab all of the appended, calculated attributes to this model
        // as these attributes are not really in the attributes array, but are run
        // when we need to array or JSON the model for convenience to the coder.
        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        return $attributes;
    }

    public function addAll(Array $data)
    {
        $rs = [];
        foreach (array_chunk($data, 800) as $t)
        {
            $rs[] = DB::table($this->getTable())->insert($t);
        }
        return $rs;
    }

}
