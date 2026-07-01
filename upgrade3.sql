-- ---------------------------------------------------------------------------
-- Eko Response - Phase 2 upgrade: agency staff, assignment & response tracking
--
-- Run on an EXISTING database (a fresh import of "Eko Response.sql" already
-- includes everything below):
--
--   mysql -u root -p response < upgrade3.sql
--   mysql -u root -p response < seed_staff.sql   (optional demo staff accounts)
-- ---------------------------------------------------------------------------

USE response;

-- Unified staff accounts for the agency portal. One table, one login, routed by
-- role: agency_admin, employee, responder.
CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id`   int(11)      NOT NULL AUTO_INCREMENT,
  `fullname`   varchar(150) NOT NULL,
  `email`      varchar(150) NOT NULL,
  `password`   varchar(255) NOT NULL,
  `role`       varchar(30)  NOT NULL DEFAULT 'employee', -- agency_admin | employee | responder
  `agency_id`  int(11)      DEFAULT NULL,
  `phone`      varchar(50)  DEFAULT NULL,
  `status`     varchar(20)  NOT NULL DEFAULT 'active',
  `created_at` timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`staff_id`),
  UNIQUE KEY `staff_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Which responder is handling a given emergency.
ALTER TABLE `emergency_alert_table`
  ADD COLUMN `assigned_staff_id` int(11) DEFAULT NULL;

-- Tracking log: every status change / responder note on an emergency.
CREATE TABLE IF NOT EXISTS `emergency_response` (
  `response_id` int(11)      NOT NULL AUTO_INCREMENT,
  `alert_id`    int(11)      NOT NULL,
  `staff_id`    int(11)      DEFAULT NULL,
  `status`      varchar(50)  DEFAULT NULL,
  `note`        varchar(500) DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`response_id`),
  KEY `resp_alert_idx` (`alert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
