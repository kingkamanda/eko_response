-- ---------------------------------------------------------------------------
-- Eko Response - optional demo seed data
--
-- Run this AFTER importing "Eko Response.sql" to get a ready-to-use demo
-- account plus a few sample emergencies in locations that already have
-- registered response units (so the hospital/fire/police result pages show
-- real responders).
--
--   mysql -u root -p response < seed_demo.sql
--
-- Demo login:  demo@ekoresponse.test  /  demo12345
-- ---------------------------------------------------------------------------

USE response;

-- Demo user (password hash is for "demo12345"). Safe to re-run: the old demo
-- user and its emergencies are cleared first.
DELETE e FROM emergency_alert_table e
    JOIN User u ON u.user_id = e.user_id
    WHERE u.user_email = 'demo@ekoresponse.test';
DELETE FROM User WHERE user_email = 'demo@ekoresponse.test';

INSERT INTO User
    (user_fullname, user_email, user_pwd, user_phone, user_gender,
     state_id, user_local_govtID, deactivate_status)
VALUES
    ('Demo User', 'demo@ekoresponse.test',
     '$2y$12$MkHw1LPGBZE4wthswpm7vuEp.kqk9cCZRLj.3U0JkbK1w3zxzjDI6',
     '08030000000', 'male', 24, 513, 'active');

SET @demo_id = (SELECT user_id FROM User WHERE user_email = 'demo@ekoresponse.test' LIMIT 1);

-- Sample emergencies for the demo user, spread across Lagos LGAs that have
-- response units. emergency_type: 1 Medical, 2 Fire, 4 Theft/Crime.
INSERT INTO emergency_alert_table
    (user_id, user_fullname, user_phone, user_location, emergency_type,
     alert_status, alert_time, alert_desc, lga_id)
VALUES
    (@demo_id, 'Demo User', '08030000000', 'Allen Avenue, Ikeja',      1, 'pending',  NOW(), 'Elderly relative collapsed, needs an ambulance.', 513),
    (@demo_id, 'Demo User', '08030000000', 'Lekki Phase 1, Eti-Osa',   2, 'enroute',  NOW(), 'Kitchen fire spreading to the next room.',        510),
    (@demo_id, 'Demo User', '08030000000', 'Wharf Road, Apapa',        4, 'resolved', NOW(), 'Phone snatched at a bus stop.',                   507);
