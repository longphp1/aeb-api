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
        Schema::create('aeb_import_financial_overview_value', function (Blueprint $table) {
            $table->id();
            $table->integer('declaration_id')->nullable()->index('idx_declaration_id')->comment('进口申报id');
            $table->integer('financial_id')->nullable()->index('idx_financial_id')->comment('financial id');
            $table->decimal('customs_value',10,2)->nullable()->comment('关税价格');
            $table->string('customs_value_currency',64)->nullable()->comment('关税价格币种');
            $table->decimal('statistical_value',10,2)->nullable()->comment('总价格');
            $table->string('statistical_value_currency',64)->nullable()->comment('总价格币种');
            $table->decimal('vat_value',10,2)->nullable()->comment('增值税价格');
            $table->string('vat_value_currency',64)->nullable()->comment('增值税币种');
            $table->decimal('customs_duties',10,2)->nullable()->comment('关税');
            $table->string('customs_duties_currency',64)->nullable()->comment('关税币种');
            $table->decimal('excise_duties',10,2)->nullable()->comment('消费税');
            $table->string('excise_duties_currency',64)->nullable()->comment('消费税币种');
            $table->decimal('vat',10,2)->nullable()->comment('增值税');
            $table->string('vat_currency',64)->nullable()->comment('增值税币种');

            $table->decimal('final_customs_value',10,2)->nullable()->comment('关税价格');
            $table->string('final_customs_value_currency',64)->nullable()->comment('关税价格币种');
            $table->decimal('final_vat_value',10,2)->nullable()->comment('增值税价格');
            $table->string('final_vat_value_currency',64)->nullable()->comment('增值税币种');
            $table->decimal('final_customs_duties',10,2)->nullable()->comment('关税价格');
            $table->string('final_customs_duties_currency',64)->nullable()->comment('关税价格币种');
            $table->decimal('final_excise_duties',10,2)->nullable()->comment('消费税');
            $table->string('final_excise_duties_currency',64)->nullable()->comment('消费税币种');
            $table->decimal('final_vat',10,2)->nullable()->comment('增值税');
            $table->string('final_vat_currency',64)->nullable()->comment('增值税币种');

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
        Schema::dropIfExists('aeb_import_financial_overview_value');
    }
};
