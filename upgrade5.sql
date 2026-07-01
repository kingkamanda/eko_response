-- ---------------------------------------------------------------------------
-- Eko Response - Phase 4 upgrade: agency states, flags, richer incident detail
--
-- Run on an EXISTING database (a fresh import of "Eko Response.sql" already
-- includes everything below):
--
--   mysql -u root -p response < upgrade5.sql
-- ---------------------------------------------------------------------------

USE response;

-- Agencies now belong to a state.
ALTER TABLE `agency`
  ADD COLUMN `state_id` int(11) DEFAULT NULL;
UPDATE `agency` SET `state_id` = 24 WHERE `state_id` IS NULL;  -- 24 = Lagos

-- Richer incident data for insightful reporting, plus a report-created
-- timestamp (distinct from the user-picked incident time) and admin flags.
ALTER TABLE `emergency_alert_table`
  ADD COLUMN `created_at`      timestamp   NULL DEFAULT CURRENT_TIMESTAMP,
  ADD COLUMN `flagged`         tinyint(1)  NOT NULL DEFAULT 0,
  ADD COLUMN `flag_reason`     varchar(255) DEFAULT NULL,
  ADD COLUMN `landmark`        varchar(200) DEFAULT NULL,
  ADD COLUMN `route`           varchar(200) DEFAULT NULL,
  ADD COLUMN `people_involved` int(11)     DEFAULT NULL,
  ADD COLUMN `affected_gender` varchar(20) DEFAULT NULL,
  ADD COLUMN `offender_gender` varchar(20) DEFAULT NULL;
