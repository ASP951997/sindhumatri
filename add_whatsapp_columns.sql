-- SQL Script to Add WhatsApp Columns to configures Table
-- Run this script on your live database to fix the error

-- Add whatsapp_api_id column after id
ALTER TABLE `configures` 
ADD COLUMN `whatsapp_api_id` VARCHAR(255) NULL AFTER `id`;

-- Add whatsapp_device_name column after whatsapp_api_id
ALTER TABLE `configures` 
ADD COLUMN `whatsapp_device_name` VARCHAR(255) NULL AFTER `whatsapp_api_id`;

-- Verify the columns were added (optional - for checking)
-- SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE 
-- FROM INFORMATION_SCHEMA.COLUMNS 
-- WHERE TABLE_NAME = 'configures' 
-- AND COLUMN_NAME IN ('whatsapp_api_id', 'whatsapp_device_name');

