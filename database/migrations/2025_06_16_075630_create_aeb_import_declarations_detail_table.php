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
        Schema::create('aeb_import_declarations_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('declarations_id')->nullable()->index('idx_declaration_id')->comment('declarations_id');
            $table->string('document_language')->nullable()->comment('语言');
            $table->string('warehouse_type')->nullable()->comment('仓库类型');
            $table->string('warehouse_id')->nullable()->comment('仓库编号');
            $table->string('supervising_office')->nullable()->comment('监督办公室');
            $table->string('method_of_payment')->nullable()->comment('支付方式');
            $table->string('vat_payment_mode')->nullable()->comment('增值税支付方式');
            $table->text('guarantees')->nullable()->comment('保证金');
            $table->text('additional_information')->nullable()->comment('附加信息');
            $table->text('transport_equipment')->nullable()->comment('运输设备');
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
        Schema::dropIfExists('aeb_import_declarations_detail');
    }
};
