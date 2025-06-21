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
        Schema::create('aeb_import_declarations_items_calculation', function (Blueprint $table) {
            $table->id();
            $table->integer('declarations_id')->nullable()->index('idx_declaration_id')->comment('declarations_id');
            $table->integer('item_id')->nullable()->index('idx_declaration_id')->comment('item_id');
            $table->integer('detail_id')->nullable()->index('idx_declaration_id')->comment('detail_id');
            $table->string('adjustment_to')->nullable()->comment('类型');
            $table->string('adjustment_type')->nullable()->comment('参考');
            $table->string('description_of_other_charges')->nullable()->comment('费用描述');
            $table->string('other_charges_value')->nullable()->comment('费用');
            $table->string('other_charges_currency')->nullable()->comment('币种');
            $table->tinyInteger('manually_entered_only')->default(0)->comment('类型0：手动录入，1：自动计算');
            $table->tinyInteger('self_calculation')->default(0)->comment('类型0：手动录入，1：自动计算');
            $table->string('tax_type')->nullable()->comment('税种');
            $table->string('rate')->nullable()->comment('汇率');
            $table->string('amount')->nullable()->comment('金额');
            $table->string('currency')->nullable()->comment('币种');
            $table->string('payment_amount')->nullable()->comment('支付金额');
            $table->string('customs_value')->nullable()->comment('关税金额');
            $table->string('statistical_value')->nullable()->comment('统计金额');
            $table->string('vat_value')->nullable()->comment('增值税金额');
            $table->string('customs_duties')->nullable()->comment('关税');
            $table->string('excise_duties')->nullable()->comment('消费税');
            $table->string('vat')->nullable()->comment('增值税');
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
        Schema::dropIfExists('aeb_import_declarations_items_calculation');
    }
};
