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
        Schema::create('aeb_import_declarations_items_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('declaration_id')->nullable()->index('idx_declaration_id')->comment('进口申报id');
            $table->integer('item_id')->nullable()->index('idx_item_id')->comment('进口申报item id');
            $table->text('authorizations')->nullable()->comment('授权');
            $table->text('additional_information')->nullable()->comment('附加资料');
            $table->string('consignor')->nullable()->comment('发货人：company_id');
            $table->string('buyer')->nullable()->comment('买家：company_id');
            $table->string('seller')->nullable()->comment('卖家：company_id');
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
        Schema::dropIfExists('aeb_import_declarations_items_detail');
    }
};
