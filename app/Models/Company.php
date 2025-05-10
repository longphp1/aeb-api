<?php

namespace App\Models;

use App\Models\Traits\Basis;
use App\Models\Traits\HasValidateUnique;
use Illuminate\Support\Facades\Cache;

class Company extends Model
{
    use Basis,
        HasValidateUnique;

    public const CONTRACT_CACHE = 'Company:ContractEndData';

    protected $table = 'ae_companies';

    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'contract_end_at' => 'datetime',
    ];

    public static function boot()
    {
        static::bootTraits();
    }
}
