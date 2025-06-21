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
        Schema::create('aeb_import_declarations', function (Blueprint $table) {
            $table->id();
            $table->string('decl_type')->nullable()->comment('decl 类型');
            $table->string('declaration_type')->nullable()->comment('声明类型');
            $table->timestamp('declaration_date')->nullable()->comment('声明日期');
            $table->string('procedure_type')->nullable()->comment('程序类型');
            $table->timestamp('manual_acc_date')->nullable()->comment('手动记录日期');
            $table->string('commercial_reference')->nullable()->comment('商业参考号');
            $table->string('consignment_no')->nullable()->comment('装运编号');
            $table->string('container_no')->nullable()->comment('集装箱号');
            $table->string('internal_reference')->nullable()->comment('内部参考号');
            $table->string('lrn')->nullable()->index('idx_lrn')->comment('LRN');
            $table->string('mrn')->nullable()->index('idx_mrn')->comment('MRN');
            $table->string('deco')->nullable()->comment('装饰');
            $table->string('delivery_no')->nullable()->comment('交货单好');
            $table->string('invoice_no')->nullable()->comment('发票号');
            $table->string('mode_border')->nullable()->comment('边境模式');
            $table->string('number_of_items')->nullable()->comment('项目数量');
            $table->string('object_id')->nullable()->comment('对象id');
            $table->string('release')->nullable()->comment('发布');
            $table->string('transition_id')->nullable()->comment('Transition ID');
            $table->string('version')->nullable()->comment('Version');
            $table->string('office_of_import')->nullable()->comment('Office of import');
            $table->string('progress')->nullable()->comment('progress');
            $table->string('status')->nullable()->comment('status');
            $table->integer('declarant_id')->nullable()->comment('Declarant,关联companys表');
            $table->integer('importer_id')->nullable()->comment('Importer,关联companys表');
            $table->integer('consignee_id')->nullable()->comment('Consignee,关联companys表');
            $table->integer('consignor_id')->nullable()->comment('Consignor,关联companys表');
            $table->integer('representative_id')->nullable()->comment('Representative,关联companys表');
            $table->integer('payer_id')->nullable()->comment('Payer,关联companys表');
            $table->integer('guarantor_import_id')->nullable()->comment('Guarantor (Import),关联companys表');
            $table->integer('vat_payer_id')->nullable()->comment('VAT payer,关联companys表');
            $table->integer('buyer_id')->nullable()->comment('Buyer,关联companys表');
            $table->integer('seller_id')->nullable()->comment('Seller,关联companys表');
            $table->integer('receiving_point_id')->nullable()->comment('Receiving point,关联companys表');
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
        Schema::dropIfExists('aeb_import_declarations');
    }
};
