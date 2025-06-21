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
        Schema::create('aeb_import_declarations_transport', function (Blueprint $table) {
            $table->id();
            $table->integer('declaration_id')->nullable()->index('idx_declaration_id')->comment('进口申报id');
            $table->string('nat_means_border')->nullable()->comment('国界含义');
            $table->string('mode_border')->nullable()->comment('边界模式');
            $table->string('mode_arrival')->nullable()->comment('到达模式');
            $table->string('means_type_arrival')->nullable()->comment('到达类型');
            $table->string('means_arrival_id')->nullable()->comment('到达id');
            $table->string('ctry_of_dispatch')->nullable()->comment('发货国家');
            $table->string('ctry_of_destination')->nullable()->comment('目的地国家');
            $table->string('office_of_entry')->nullable()->comment('进口口岸');
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
        Schema::dropIfExists('aeb_import_declarations_transport');
    }
};
