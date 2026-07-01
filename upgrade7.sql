-- ---------------------------------------------------------------------------
-- Eko Response - Phase 6 upgrade: multi-responder dispatch flags
--
--   mysql -u root -p response < upgrade7.sql
-- ---------------------------------------------------------------------------

USE response;

-- Follow-up facts that can pull in additional responders:
--   casualties -> add Medical/Ambulance;  weapon -> add Police (+ Medical).
ALTER TABLE `emergency_alert_table`
  ADD COLUMN `casualties` tinyint(1) NOT NULL DEFAULT 0,
  ADD COLUMN `weapon`     tinyint(1) NOT NULL DEFAULT 0;

-- Accidents are primarily a Road Safety (FRSC, agency 4) matter; casualties then
-- pull in Medical/Ambulance automatically at dispatch.
UPDATE `category` SET `agency_id` = 4 WHERE `category_id` IN (3, 9);
