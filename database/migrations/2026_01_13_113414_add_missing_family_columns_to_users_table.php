<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFamilyColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('father', 191)->nullable()->after('family_status');
            $table->string('mother', 191)->nullable()->after('father');
            $table->integer('brother_no')->nullable()->after('mother');
            $table->string('brother_married', 100)->nullable()->after('brother_no');
            $table->integer('sister_no')->nullable()->after('brother_married');
            $table->string('sibling_position', 50)->nullable()->after('sister_no');
            $table->string('family_income', 50)->nullable()->after('sibling_position');
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
            $table->dropColumn(['father', 'mother', 'brother_no', 'brother_married', 'sister_no', 'sibling_position', 'family_income']);
        });
    }
}
