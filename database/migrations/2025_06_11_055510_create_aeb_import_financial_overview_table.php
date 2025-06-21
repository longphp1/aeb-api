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
        Schema::create('aeb_import_financial_overview', function (Blueprint $table) {
            $table->id();
            $table->integer('declaration_id')->nullable()->index('idx_declaration_id')->comment('进口申报id');
            $table->string('total_invoice')->nullable()->comment('总计发票');
            $table->string('total_invoice_currency')->nullable()->comment('总计发票币种');
            $table->string('nature_of_transact')->nullable()->comment('交易性质');
            $table->string('incoterm')->nullable()->comment('贸易术语');
            $table->string('place')->nullable()->comment('地点');
            $table->string('place_code')->nullable()->comment('地点代码');
            $table->string('incoterm_info')->nullable()->comment('贸易术语详细信息');
            $table->string('country')->nullable()->comment('国家');
            $table->string('calculate_values')->nullable()->comment('计算值');
            $table->string('inclusion_mode')->nullable()->comment('包含模式');
            $table->string('transport')->nullable()->comment('运输百分比');
            $table->string('transport_abs_value')->nullable()->comment('运输百分比使用绝对值');
            $table->string('transport_costs')->nullable()->comment('运输费用');
            $table->string('outside_eu')->nullable()->comment('欧盟百分比');
            $table->string('eu_to_nl')->nullable()->comment('欧盟到荷兰百分比');
            $table->string('inside_nl')->nullable()->comment('荷兰到境内');
            $table->string('insurance')->nullable()->comment('保险');
            $table->string('insurance_abs_value')->nullable()->comment('保险百分比使用绝对值');
            $table->string('insurance_costs')->nullable()->comment('保险费用');
            $table->string('gross_weight')->nullable()->comment('毛重kg');
            $table->string('gross_weight_unit')->nullable()->comment('毛重单位');
            $table->string('net_weight')->nullable()->comment('净重kg');
            $table->string('net_weight_unit')->nullable()->comment('净重单位');
            $table->string('no_of_packages')->nullable()->comment('包裹数量');
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
        Schema::dropIfExists('aeb_import_financial_overview');
    }
};
