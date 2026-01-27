-- direct_sql_reset.sql - Run this directly in phpMyAdmin SQL tab

-- Step 1: Disable foreign key checks
SET FOREIGN_KEY_CHECKS = 0;

-- Step 2: Drop all tables (run these commands one by one if needed)
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS affection_for_details;
DROP TABLE IF EXISTS affection_fors;
DROP TABLE IF EXISTS blogs;
DROP TABLE IF EXISTS castes;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS complexions;
DROP TABLE IF EXISTS complexion_details;
DROP TABLE IF EXISTS communities;
DROP TABLE IF EXISTS community_value_details;
DROP TABLE IF EXISTS configures;
DROP TABLE IF EXISTS content_details;
DROP TABLE IF EXISTS content_media;
DROP TABLE IF EXISTS contents;
DROP TABLE IF EXISTS countries;
DROP TABLE IF EXISTS education_infos;
DROP TABLE IF EXISTS email_templates;
DROP TABLE IF EXISTS ethnicities;
DROP TABLE IF EXISTS ethnicity_details;
DROP TABLE IF EXISTS failed_jobs;
DROP TABLE IF EXISTS family_values;
DROP TABLE IF EXISTS family_value_details;
DROP TABLE IF EXISTS funds;
DROP TABLE IF EXISTS galleries;
DROP TABLE IF EXISTS hair_colors;
DROP TABLE IF EXISTS hair_color_details;
DROP TABLE IF EXISTS hobbies;
DROP TABLE IF EXISTS hobby_details;
DROP TABLE IF EXISTS horoscopes;
DROP TABLE IF EXISTS horoscope_details;
DROP TABLE IF EXISTS humors;
DROP TABLE IF EXISTS humor_details;
DROP TABLE IF EXISTS interests;
DROP TABLE IF EXISTS interest_details;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS languages;
DROP TABLE IF EXISTS language_details;
DROP TABLE IF EXISTS marital_statuses;
DROP TABLE IF EXISTS marital_status_details;
DROP TABLE IF EXISTS member_types;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS migrations;
DROP TABLE IF EXISTS mother_tongues;
DROP TABLE IF EXISTS notify_templates;
DROP TABLE IF EXISTS occupations;
DROP TABLE IF EXISTS on_behalfs;
DROP TABLE IF EXISTS on_behalf_details;
DROP TABLE IF EXISTS packages;
DROP TABLE IF EXISTS partner_educations;
DROP TABLE IF EXISTS payments;
DROP TABLE IF EXISTS physical_attributes;
DROP TABLE IF EXISTS plans;
DROP TABLE IF EXISTS political_views;
DROP TABLE IF EXISTS political_view_details;
DROP TABLE IF EXISTS professions;
DROP TABLE IF EXISTS profile_checks;
DROP TABLE IF EXISTS reference_users;
DROP TABLE IF EXISTS reference_user_details;
DROP TABLE IF EXISTS religions;
DROP TABLE IF EXISTS religious_services;
DROP TABLE IF EXISTS reports;
DROP TABLE IF EXISTS sms_templates;
DROP TABLE IF EXISTS states;
DROP TABLE IF EXISTS stories;
DROP TABLE IF EXISTS sub_castes;
DROP TABLE IF EXISTS subscribers;
DROP TABLE IF EXISTS successful_stories;
DROP TABLE IF EXISTS user_fund_logs;
DROP TABLE IF EXISTS user_multiple_photos;
DROP TABLE IF EXISTS user_photos;
DROP TABLE IF EXISTS user_transactions;
DROP TABLE IF EXISTS user_withdrawals;
DROP TABLE IF EXISTS wallet_histories;
DROP TABLE IF EXISTS whatsapps;

-- Step 3: Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Step 4: Verify (run this separately)
SELECT 'Database cleaned successfully!' as status;




