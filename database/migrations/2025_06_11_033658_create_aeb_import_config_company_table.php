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
        Schema::create('aeb_import_config_company', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable()->comment('公司名称');
            $table->string('company_code')->index('idx_company_code')->comment('公司代码');
            $table->string('role_type')->nullable()->comment('角色名称');
            $table->string('trader_id')->nullable()->comment('贸易商id');
            $table->string('vat_id')->nullable()->comment('增值税id');
            $table->string('ioss_vat')->nullable()->comment('增值税');
            $table->string('user_name')->nullable()->comment('用户名称');
            $table->string('street')->nullable()->comment('街道');
            $table->string('postal_code')->nullable()->comment('邮编');
            $table->string('city')->nullable()->comment('城市');
            $table->string('country')->nullable()->comment('国家');
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
        Schema::dropIfExists('aeb_import_config_company');
    }
};
