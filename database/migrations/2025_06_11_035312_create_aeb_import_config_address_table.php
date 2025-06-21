<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aeb_import_config_address', function (Blueprint $table) {
            $table->id();
            $table->string('street')->nullable()->comment('街道');
            $table->string('house_number')->nullable()->comment('房屋编号');
            $table->string('postal_code')->nullable()->comment('邮编');
            $table->string('city')->nullable()->comment('城市');
            $table->string('state')->nullable()->comment('州/省');
            $table->string('country')->nullable()->comment('国家');
            $table->string('phone')->nullable()->comment('电话');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('fax')->nullable()->comment('传真');
            $table->string('name')->nullable()->comment('名称');
            $table->string('type')->nullable()->comment('类型');
            $table->integer('company_id')->default(0)->comment('所属公司');
            $table->integer('created_by')->default(0)->comment('创建人');
            $table->softDeletes()->comment('软删除');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aeb_import_config_address');
    }
};
