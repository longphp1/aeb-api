<?php

namespace App\Models\Aeb\Import;

use App\Models\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class ImportItemsDetailTransport extends Model
{
    protected $table = 'aeb_import_declarations_items_detail_transport';

    protected $guarded = [];

    use softDeletes;

}
