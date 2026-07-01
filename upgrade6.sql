-- ---------------------------------------------------------------------------
-- Eko Response - Phase 5 upgrade: support live chat
--
-- Run on an EXISTING database (a fresh import of "Eko Response.sql" already
-- includes everything below):
--
--   mysql -u root -p response < upgrade6.sql
-- ---------------------------------------------------------------------------

USE response;

-- One row per chat message. A "conversation" is all messages for a user_id.
CREATE TABLE IF NOT EXISTS `support_message` (
  `message_id` int(11)       NOT NULL AUTO_INCREMENT,
  `user_id`    int(11)       NOT NULL,
  `sender`     varchar(20)   NOT NULL DEFAULT 'user',  -- 'user' | 'support'
  `staff_id`   int(11)       DEFAULT NULL,             -- support agent who replied
  `body`       varchar(1000) NOT NULL,
  `is_read`    tinyint(1)    NOT NULL DEFAULT 0,
  `created_at` timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `support_user_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
