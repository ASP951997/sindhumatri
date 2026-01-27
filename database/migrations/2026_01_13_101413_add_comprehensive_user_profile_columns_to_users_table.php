<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddComprehensiveUserProfileColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Present Address
            $table->integer('present_country')->nullable()->after('pan');
            $table->integer('present_state')->nullable()->after('present_country');
            $table->integer('present_city')->nullable()->after('present_state');
            $table->text('present_address')->nullable()->after('present_city');

            // Permanent Address
            $table->integer('permanent_country')->nullable()->after('present_address');
            $table->integer('permanent_state')->nullable()->after('permanent_country');
            $table->integer('permanent_city')->nullable()->after('permanent_state');
            $table->text('permanent_address')->nullable()->after('permanent_city');

            // Physical Attributes
            $table->string('height', 20)->nullable()->after('permanent_address');
            $table->string('weight', 20)->nullable()->after('height');
            $table->integer('body_type')->nullable()->after('weight');
            $table->integer('complexion')->nullable()->after('body_type');
            $table->integer('hair_color')->nullable()->after('complexion');
            $table->integer('body_art')->nullable()->after('hair_color');
            $table->integer('ethnicity')->nullable()->after('body_art');

            // Education Info
            $table->integer('education_level')->nullable()->after('ethnicity');
            $table->string('education_field', 191)->nullable()->after('education_level');
            $table->string('college_name', 191)->nullable()->after('education_field');
            $table->integer('passing_year')->nullable()->after('college_name');

            // Career Info
            $table->integer('occupation')->nullable()->after('passing_year');
            $table->string('company_name', 191)->nullable()->after('occupation');
            $table->string('annual_income', 50)->nullable()->after('company_name');
            $table->integer('work_experience')->nullable()->after('annual_income');

            // Language
            $table->json('languages_known')->nullable()->after('work_experience');

            // Hobbies & Interest
            $table->json('hobbies')->nullable()->after('languages_known');
            $table->json('interests')->nullable()->after('hobbies');
            $table->json('music')->nullable()->after('interests');
            $table->json('books')->nullable()->after('music');
            $table->json('movies')->nullable()->after('books');
            $table->json('sports')->nullable()->after('movies');

            // Spiritual & Social Background
            $table->integer('religion')->nullable()->after('sports');
            $table->integer('caste')->nullable()->after('religion');
            $table->integer('sub_caste')->nullable()->after('caste');
            $table->integer('family_value')->nullable()->after('sub_caste');
            $table->integer('community_value')->nullable()->after('family_value');
            $table->integer('political_views')->nullable()->after('community_value');
            $table->integer('religious_service')->nullable()->after('political_views');

            // Lifestyle
            $table->string('diet', 50)->nullable()->after('religious_service');
            $table->string('smoke', 20)->nullable()->after('diet');
            $table->string('drink', 20)->nullable()->after('smoke');
            $table->string('living_situation', 100)->nullable()->after('drink');

            // Astronomic Information
            $table->time('birth_time')->nullable()->after('living_situation');
            $table->string('birth_place', 191)->nullable()->after('birth_time');
            $table->string('manglik', 20)->nullable()->after('birth_place');
            $table->text('horoscope')->nullable()->after('manglik');

            // Family Information
            $table->string('father_name', 191)->nullable()->after('horoscope');
            $table->string('father_occupation', 191)->nullable()->after('father_name');
            $table->string('mother_name', 191)->nullable()->after('father_occupation');
            $table->string('mother_occupation', 191)->nullable()->after('mother_name');
            $table->integer('brothers')->nullable()->after('mother_occupation');
            $table->integer('sisters')->nullable()->after('brothers');
            $table->string('family_type', 50)->nullable()->after('sisters');
            $table->string('family_status', 50)->nullable()->after('family_type');

            // Partner Expectation
            $table->integer('partner_age_min')->nullable()->after('family_status');
            $table->integer('partner_age_max')->nullable()->after('partner_age_min');
            $table->string('partner_height_min', 20)->nullable()->after('partner_age_max');
            $table->string('partner_height_max', 20)->nullable()->after('partner_height_min');
            $table->json('partner_education')->nullable()->after('partner_height_max');
            $table->json('partner_occupation')->nullable()->after('partner_education');
            $table->string('partner_income', 50)->nullable()->after('partner_occupation');
            $table->json('partner_religion')->nullable()->after('partner_income');
            $table->json('partner_caste')->nullable()->after('partner_religion');
            $table->json('partner_country')->nullable()->after('partner_caste');
            $table->json('partner_state')->nullable()->after('partner_country');
            $table->json('partner_city')->nullable()->after('partner_state');
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
            // Partner Expectation (drop in reverse order)
            $table->dropColumn([
                'partner_city',
                'partner_state',
                'partner_country',
                'partner_caste',
                'partner_religion',
                'partner_income',
                'partner_occupation',
                'partner_education',
                'partner_height_max',
                'partner_height_min',
                'partner_age_max',
                'partner_age_min',
                // Family Information
                'family_status',
                'family_type',
                'sisters',
                'brothers',
                'mother_occupation',
                'mother_name',
                'father_occupation',
                'father_name',
                // Astronomic Information
                'horoscope',
                'manglik',
                'birth_place',
                'birth_time',
                // Lifestyle
                'living_situation',
                'drink',
                'smoke',
                'diet',
                // Spiritual & Social Background
                'religious_service',
                'political_views',
                'community_value',
                'family_value',
                'sub_caste',
                'caste',
                'religion',
                // Hobbies & Interest
                'sports',
                'movies',
                'books',
                'music',
                'interests',
                'hobbies',
                // Language
                'languages_known',
                // Career Info
                'work_experience',
                'annual_income',
                'company_name',
                'occupation',
                // Education Info
                'passing_year',
                'college_name',
                'education_field',
                'education_level',
                // Physical Attributes
                'ethnicity',
                'body_art',
                'hair_color',
                'complexion',
                'body_type',
                'weight',
                'height',
                // Permanent Address
                'permanent_address',
                'permanent_city',
                'permanent_state',
                'permanent_country',
                // Present Address
                'present_address',
                'present_city',
                'present_state',
                'present_country'
            ]);
        });
    }
}
