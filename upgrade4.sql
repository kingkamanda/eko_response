-- ---------------------------------------------------------------------------
-- Eko Response - Phase 3 upgrade: severity, richer timeline, feedback
--
-- Run on an EXISTING database (a fresh import of "Eko Response.sql" already
-- includes everything below):
--
--   mysql -u root -p response < upgrade4.sql
-- ---------------------------------------------------------------------------

USE response;

-- Keep severity separate from the workflow status so hot zones can rank by it.
-- (If you see "Duplicate column name", it already exists — ignore it.)
ALTER TABLE `emergency_alert_table`
  ADD COLUMN `severity` varchar(20) DEFAULT NULL;

-- Timeline updates can now come from a public reporter (user_id) and carry an
-- optional image.
ALTER TABLE `emergency_response`
  ADD COLUMN `user_id` int(11)     DEFAULT NULL,
  ADD COLUMN `image`   varchar(200) DEFAULT NULL;

-- Post-resolution feedback from reporters.
CREATE TABLE IF NOT EXISTS `feedback` (
  `feedback_id` int(11)      NOT NULL AUTO_INCREMENT,
  `user_id`     int(11)      NOT NULL,
  `alert_id`    int(11)      DEFAULT NULL,
  `rating`      tinyint(4)   DEFAULT NULL,
  `comment`     varchar(500) DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`feedback_id`),
  KEY `feedback_user_idx` (`user_id`),
  KEY `feedback_alert_idx` (`alert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
