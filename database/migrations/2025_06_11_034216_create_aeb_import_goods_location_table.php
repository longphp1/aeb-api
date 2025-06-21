<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aeb_import_goods_location', function (Blueprint $table) {
            $table->id();
            $table->integer('declaration_id')->index('idx_declaration_id')->comment('进口申报id');
            $table->string('type')->nullable()->comment('初始化字母');
            $table->string('qualifier')->nullable()->comment('合格者');
            $table->string('agreed_loc_code')->nullable()->comment('同意代码');
            $table->string('add_identifier')->nullable()->comment('添加标识符');
            $table->string('customs_office')->nullable()->comment('海关');
            $table->string('un_locode')->nullable()->comment('分本地人');
            $table->string('address_id')->nullable()->comment('地址config_address表id');
            $table->string('gnss')->nullable()->comment('全球导航卫星系统');
            $table->string('economic_operator_id')->nullable()->comment('经济运营商：config_company表id');
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
        Schema::dropIfExists('aeb_import_goods_location');
    }
};
