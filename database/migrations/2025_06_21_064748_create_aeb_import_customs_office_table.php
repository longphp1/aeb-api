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
        Schema::create('aeb_import_customs_office', function (Blueprint $table) {
            $table->id();
            $table->string('code')->index('idx_code')->comment('code');
            $table->string('domestic_code')->index('idx_domestic_code')->nullable()->comment('国内代码');
            $table->string('name')->nullable()->comment('名称');
            $table->string('country')->nullable()->comment('国家');
            $table->string('to_country')->nullable()->comment('送达国家');
            $table->string('geo_info_code')->nullable()->comment('地理位置code');
            $table->string('data_source')->nullable()->comment('数据来源');
            $table->tinyInteger('from_data_service')->default(0)->comment('来自于数据服务');
            $table->timestamp('start_on')->nullable()->comment('开始时间');
            $table->timestamp('end_on')->nullable()->comment('结束时间');
            $table->tinyInteger('export_customs_office')->default(0)->comment('出口海关办公室');
            $table->tinyInteger('office_of_exit')->default(0)->comment('出境办公室');
            $table->tinyInteger('air_exit_office')->default(0)->comment('航空出口办公室');
            $table->tinyInteger('customs_office_of_entry')->default(0)->comment('入境海关办公室');
            $table->tinyInteger('border_customs_office')->default(0)->comment('边境海关办公室');
            $table->tinyInteger('supervising_customs_office')->default(0)->comment('监管海关办公室');
            $table->tinyInteger('transit_customs_office')->default(0)->comment('过境海关办公室');
            $table->tinyInteger('office_of_departure')->default(0)->comment('出发地办公室');
            $table->tinyInteger('office_of_destination')->default(0)->comment('目的地办公室');
            $table->tinyInteger('exit_office_inland')->default(0)->comment('内陆');
            $table->integer('office_address_id')->nullable()->comment('office地址id');
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
        Schema::dropIfExists('aeb_import_customs_office');
    }
};
