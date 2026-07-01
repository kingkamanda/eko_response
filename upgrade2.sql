-- ---------------------------------------------------------------------------
-- Eko Response - Phase 1 upgrade: agencies + emergency-type governance
--
-- Run this on an EXISTING database (already imported from an older
-- "Eko Response.sql"). A fresh import of the current "Eko Response.sql"
-- already includes everything below.
--
--   mysql -u root -p response < upgrade2.sql
-- ---------------------------------------------------------------------------

USE response;

-- 1) Responsible agencies (the entity that handles an emergency type).
CREATE TABLE IF NOT EXISTS `agency` (
  `agency_id`   int(11)      NOT NULL AUTO_INCREMENT,
  `agency_name` varchar(150) NOT NULL,
  `agency_type` varchar(30)  NOT NULL DEFAULT 'other',  -- police | fire | medical | other
  `agency_phone` varchar(50) DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `agency` (`agency_id`, `agency_name`, `agency_type`, `agency_phone`) VALUES
(1, 'Nigeria Police Force',                 'police',  '112'),
(2, 'Lagos State Fire & Rescue Service',    'fire',    '112'),
(3, 'Lagos State Ambulance Service (LASAMBUS)', 'medical', '112'),
(4, 'Federal Road Safety Corps',            'other',   '122');

-- 2) Governance columns on the emergency-type catalogue.
--    If you see "Duplicate column name", they already exist — ignore it.
ALTER TABLE `category`
  ADD COLUMN `agency_id`       int(11)     DEFAULT NULL,
  ADD COLUMN `approval_status` varchar(20) NOT NULL DEFAULT 'approved',
  ADD COLUMN `requested_by`    int(11)     DEFAULT NULL;

-- 3) Map the existing emergency types to a responsible agency.
UPDATE `category` SET `agency_id` = 1 WHERE `category_id` IN (4, 11, 12, 15);     -- Theft/Crime, Kidnapping, Domestic Violence, Civil Unrest -> Police
UPDATE `category` SET `agency_id` = 2 WHERE `category_id` IN (2, 7, 8, 10);       -- Fire, Flood, Building Collapse, Gas Leak -> Fire
UPDATE `category` SET `agency_id` = 3 WHERE `category_id` IN (1, 3, 6, 9, 13, 14);-- Medical, Accident, Ambulance, Road Accident, Electrocution, Drowning -> Medical
