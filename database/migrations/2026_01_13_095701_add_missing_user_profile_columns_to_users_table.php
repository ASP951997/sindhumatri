<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingUserProfileColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender', 20)->nullable()->after('phone');
            $table->date('date_of_birth')->nullable()->after('gender');
            $table->integer('age')->nullable()->after('date_of_birth');
            $table->integer('on_behalf')->nullable()->after('age');
            $table->integer('marital_status')->nullable()->after('on_behalf');
            $table->integer('no_of_children')->default(0)->after('marital_status');
            $table->string('aadhar', 191)->nullable()->after('no_of_children');
            $table->string('pan', 191)->nullable()->after('aadhar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'gender',
                'date_of_birth',
                'age',
                'on_behalf',
                'marital_status',
                'no_of_children',
                'aadhar',
                'pan'
            ]);
        });
    }
}
