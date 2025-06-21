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
        Schema::create('aeb_import_declarations_items', function (Blueprint $table) {
            $table->id();
            $table->integer('declaration_id')->nullable()->index('idx_declaration_id')->comment('进口申报id');
            $table->string('no')->nullable()->comment('编号');
            $table->string('commercial_reference')->nullable()->comment('商业参考编号');
            $table->string('material_id')->nullable()->comment('材料id');
            $table->string('quantity')->nullable()->comment('数量');
            $table->string('goods_description')->nullable()->comment('商品描述');
            $table->string('internal_remark')->nullable()->comment('备注');
            $table->string('commodity_code')->nullable()->comment('商品编码');
            $table->string('chemical_cus_code')->nullable()->comment('化学品海关编码');
            $table->string('statistical_quantity')->nullable()->comment('统计数量');
            $table->string('tariff_quantities')->nullable()->comment('关税数量');
            $table->string('taric')->nullable()->comment('添加码');
            $table->string('nat_add_codes')->nullable()->comment('国别附加码');
            $table->string('preference_request')->nullable()->comment('优先级请求');
            $table->string('quota_number')->nullable()->comment('配额编码');
            $table->string('evaluation_method')->nullable()->comment('评估方法');
            $table->string('ctry_of_origin')->nullable()->comment('原产国');
            $table->string('preferential_origin')->nullable()->comment('优惠原产地');
            $table->string('procedure')->nullable()->comment('流程');
            $table->string('nat_procedure')->nullable()->comment('国民流程');
            $table->string('net_price')->nullable()->comment('净价');
            $table->string('stat_value')->nullable()->comment('统计价值');
            $table->string('gross_weight')->nullable()->comment('毛重');
            $table->string('net_weight')->nullable()->comment('净重');
            $table->string('no_of_packages')->nullable()->comment('包裹数量');
            $table->text('packages')->nullable()->comment('包裹');
            $table->string('ctry_of_dispatch')->nullable()->comment('发货国');
            $table->string('ctry_of_destination')->nullable()->comment('目的国');
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
        Schema::dropIfExists('aeb_import_declarations_items');
    }
};
