-- ---------------------------------------------------------------------------
-- Eko Response - schema upgrade for EXISTING databases
--
-- Only needed if you already imported an older "Eko Response.sql" and want to
-- keep your data. A fresh import of the current "Eko Response.sql" already
-- includes everything below.
--
--   mysql -u root -p response < upgrade.sql
-- ---------------------------------------------------------------------------

USE response;

-- 1) Geolocation columns for pin-pointing where an emergency happened.
--    If you see "Duplicate column name", they are already present — ignore it.
ALTER TABLE `emergency_alert_table`
    ADD COLUMN `latitude`  decimal(10,7) DEFAULT NULL,
    ADD COLUMN `longitude` decimal(10,7) DEFAULT NULL;

-- 2) Additional emergency categories. INSERT IGNORE skips any that already exist.
INSERT IGNORE INTO `category` (`category_id`, `category_name`) VALUES
(7,  'Flood'),
(8,  'Building Collapse'),
(9,  'Road Accident'),
(10, 'Gas Leak / Explosion'),
(11, 'Kidnapping'),
(12, 'Domestic Violence'),
(13, 'Electrocution'),
(14, 'Drowning'),
(15, 'Civil Unrest / Riot');
