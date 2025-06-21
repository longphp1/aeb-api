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
        Schema::create('sys_country_code', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('国家名称');
            $table->string('code')->comment('国家代码');
            $table->string('emoji')->nullable()->comment('国家国旗');
            $table->tinyInteger('status')->default(1)->comment('状态0=禁用,1=启用');
            $table->integer('company_id')->default(0)->comment('所属公司');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sys_country_code');
    }
};
