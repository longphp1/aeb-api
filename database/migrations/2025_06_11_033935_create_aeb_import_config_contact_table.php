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
        Schema::create('aeb_import_config_contact', function (Blueprint $table) {
            $table->id();
            $table->string('initials')->nullable()->index('idx_initials')->comment('初始化字母');
            $table->string('first_name')->nullable()->comment('姓名');
            $table->string('last_name')->nullable()->comment('姓');
            $table->string('name')->nullable()->comment('姓名');
            $table->string('phone')->nullable()->comment('电话');
            $table->string('fax')->nullable()->comment('传真');
            $table->string('email')->nullable()->comment('邮箱');
            $table->string('company_name')->nullable()->comment('公司名称');
            $table->string('title')->nullable()->comment('职位');
            $table->string('signing_authority')->nullable()->comment('签署');
            $table->string('type')->nullable()->comment('类型0contact,1application');
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
        Schema::dropIfExists('aeb_import_config_contact');
    }
};
