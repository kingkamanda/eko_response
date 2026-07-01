-- ---------------------------------------------------------------------------
-- Eko Response - multi-state coverage seed (optional)
--
-- Adds responsible agencies for several states and a handful of real response
-- units in Abuja (FCT) so emergencies reported outside Lagos are covered too.
-- Admins can onboard more from Admin -> Agencies.
--
--   mysql -u root -p response < seed_coverage.sql
--
-- State ids used: 37 FCT/Abuja, 32 Rivers, 19 Kano, 30 Oyo, 27 Ogun
-- Abuja LGA ids: 777 Abaji, 778 Bwari, 779 Gwagwalada, 780 Kuje, 781 Kwali, 782 Municipal
-- ---------------------------------------------------------------------------

USE response;

-- State-level responsible agencies (contact fallback for any report).
INSERT INTO `agency` (`agency_name`, `agency_type`, `agency_phone`, `state_id`) VALUES
('FCT Police Command',                 'police',  '08061581938', 37),
('FCT Fire Service',                   'fire',    '09024581875', 37),
('FCT Emergency Ambulance Service',    'medical', '112',         37),
('Rivers State Police Command',        'police',  '08032003514', 32),
('Rivers State Fire Service',          'fire',    '08033126004', 32),
('Kano State Fire Service',            'fire',    '08099921935', 19),
('Oyo State Emergency Ambulance',      'medical', '112',         30),
('Ogun State Police Command',          'police',  '08081770416', 27);

-- Real response units in Abuja (FCT) so unit lookups return results there.
INSERT INTO `medical_unit`
  (`medical_unit_name`, `store_unit_name`, `category_id`, `medical_unit_address`, `medical_unit_phone_number`, `medical_unit_type`, `medical_unit_location`) VALUES
('National Hospital Abuja', '', 1, 'Central Business District, Abuja', '094613380', 'Federal Hospital', 782),
('University of Abuja Teaching Hospital', '', 1, 'Gwagwalada, Abuja', '08099999999', 'Teaching Hospital', 779),
('Nizamiye Hospital', '', 1, 'Idu Industrial District, Abuja', '084633000', 'Private Hospital', 782);

INSERT INTO `fire_unit`
  (`fire_unit_name`, `store_unit_name`, `category_id`, `fire_unit_address`, `fire_unit_phone_number`, `fire_unit_type`, `fire_unit_location`) VALUES
('FCT Fire Service HQ', '', 2, 'Central Area, Abuja', '09024581875', 'Federal Fire Service', 782),
('Bwari Fire Station', '', 2, 'Bwari Area Council, Abuja', '08037019999', 'FCT Fire Service', 778);

INSERT INTO `police_unit`
  (`police_unit_name`, `store_unit_name`, `category_id`, `police_unit_address`, `police_unit_phone_number`, `police_unit_type`, `police_unit_location`) VALUES
('Central Police Station Abuja', '', 4, 'Garki, Abuja', '08061581938', 'Divisional HQ', 782),
('Gwagwalada Police Division', '', 4, 'Gwagwalada, Abuja', '08032003514', 'Divisional Station', 779);
