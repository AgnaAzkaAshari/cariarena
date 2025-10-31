<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->enum('role', ['user', 'admin', 'vendor'])->default('user')->after('phone');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('role');
            $table->text('address')->nullable()->after('status');
            $table->text('bio')->nullable()->after('address');
            $table->timestamp('last_login')->nullable()->after('bio');
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'role', 'status', 'address', 'bio', 'last_login']);
            $table->dropSoftDeletes();
        });
    }
}