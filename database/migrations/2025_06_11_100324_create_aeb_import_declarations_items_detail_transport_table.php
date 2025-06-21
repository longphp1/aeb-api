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
        Schema::create('aeb_import_declarations_items_detail_transport', function (Blueprint $table) {
            $table->id();
            $table->integer('declarations_id')->nullable()->index('idx_declaration_id')->comment('declarations_id');
            $table->integer('item_id')->nullable()->index('idx_declaration_id')->comment('item_id');
            $table->integer('detail_id')->nullable()->index('idx_declaration_id')->comment('detail_id');
            $table->string('type')->nullable()->comment('类型');
            $table->string('reference')->nullable()->comment('参考');
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
        Schema::dropIfExists('aeb_import_declarations_items_detail_transport');
    }
};
