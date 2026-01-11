<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('notifications')) {
            Schema::create('notifications', function (Blueprint $table) {
                $table->id();
                $table->text('message')->nullable();
                $table->string('ip', 64)->nullable();
                $table->unsignedBigInteger('customer_id')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('customer_phone')->nullable();
                $table->unsignedTinyInteger('is_read')->default(0);
                $table->timestamps();
            });
            return;
        }

        if (!Schema::hasColumn('notifications', 'is_read')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->unsignedTinyInteger('is_read')->default(0)->after('customer_phone');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('notifications') && Schema::hasColumn('notifications', 'is_read')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropColumn('is_read');
            });
        }
    }
};
