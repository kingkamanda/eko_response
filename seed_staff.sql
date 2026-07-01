-- ---------------------------------------------------------------------------
-- Eko Response - demo agency staff accounts
--
-- Run AFTER "Eko Response.sql" (or upgrade3.sql). Safe to re-run.
--
--   mysql -u root -p response < seed_staff.sql
--
-- Every account below uses the password:  staff12345
-- Agencies (from Eko Response.sql): 1 Police, 2 Fire, 3 Medical, 4 FRSC
-- ---------------------------------------------------------------------------

USE response;

DELETE FROM `staff` WHERE `email` LIKE '%@ekoresponse.test';

INSERT INTO `staff` (`fullname`, `email`, `password`, `role`, `agency_id`, `phone`) VALUES
-- Police
('Chidi Okafor',   'police.admin@ekoresponse.test',     '$2y$12$b75AvbQ4J9cdarjOPhpb.O2e40Czq/90mF.nARChVbtMFFDZQa2Iu', 'agency_admin', 1, '08030000001'),
('Ada Nwosu',      'police.employee@ekoresponse.test',  '$2y$12$b75AvbQ4J9cdarjOPhpb.O2e40Czq/90mF.nARChVbtMFFDZQa2Iu', 'employee',     1, '08030000002'),
('Musa Ibrahim',   'police.responder@ekoresponse.test', '$2y$12$b75AvbQ4J9cdarjOPhpb.O2e40Czq/90mF.nARChVbtMFFDZQa2Iu', 'responder',    1, '08030000003'),
-- Fire
('Bola Adeyemi',   'fire.admin@ekoresponse.test',       '$2y$12$b75AvbQ4J9cdarjOPhpb.O2e40Czq/90mF.nARChVbtMFFDZQa2Iu', 'agency_admin', 2, '08030000004'),
('Emeka Obi',      'fire.responder@ekoresponse.test',   '$2y$12$b75AvbQ4J9cdarjOPhpb.O2e40Czq/90mF.nARChVbtMFFDZQa2Iu', 'responder',    2, '08030000005'),
-- Medical / LASAMBUS
('Ngozi Eze',      'medical.admin@ekoresponse.test',    '$2y$12$b75AvbQ4J9cdarjOPhpb.O2e40Czq/90mF.nARChVbtMFFDZQa2Iu', 'agency_admin', 3, '08030000006'),
('Tunde Bakare',   'medical.responder@ekoresponse.test','$2y$12$b75AvbQ4J9cdarjOPhpb.O2e40Czq/90mF.nARChVbtMFFDZQa2Iu', 'responder',    3, '08030000007');
