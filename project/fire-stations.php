


<?php
`fire_unit`(`fire_unit_id`, `fire_unit_name`, `store_unit_name`, `category_id`, `fire_unit_address`, `fire_unit_phone_number`, `fire_unit_type`, `fire_unit_geolocation`);
  (1,"Alausa (HQ)","Governor Road, The Secretariat, Alausa, Ikeja","08033235891"),
  (2,'Ikeja Fire Station','',2,'Powa Market, 57 Mobolaji Bank Anthony Way, Ikeja','08032219746','State Fire Service',513),
  (3, 'Ilupeju Fire Station','',2,'Ikorodu Road, Anthony Bus Stop, Ilupeju.','08033235891','State Fire Service',518),
  (4, 'Isolo Fire Station','',2,'Oshodi/Apapa Exp. Way, Toyota Bus Stop, Isolo,','07011555524','State Fire Service',520),
  (5, 'Airport Road Federal Fire Station','',2,' Airport Rd, Lagos, Ikeja,','08032219746','Federal Fire Service',513),
  (6, 'Bolade Fire Station','',2,'Safety Arena, Bolade Bus Stop, Oshodi,','07011555542','State Fire Service',520),  
  (7, 'Badagry Fire Station','',2,'Topo-ASCON Road, Badagry','08033817515','State Fire Service',508),
  (8, 'Agege Fire Station','',2,'Abeokuta Express Way, Ilepo Bus Stop, Oke Odo','08185704012','State Fire Service',503),
  (9, 'Ikorodu Fire Station','',2,'Ikorodu/Shagamu Road, Odogunya, Ikorodu.','08032220495','State Fire Service',514),
  (10, 'Sari-Iganmu Fire Station','',2,'Bola Ahmed Tinubu Tanker Terminal, Sari Iganmu','08067026444','State Fire Service',522),
  (11, 'Ikotun Fire Station','',2,'Ikotun/Igando Council Secretariat, Ikotun','07063393240','State Fire Service',505),
  (12, 'Lekki Phase II Fire Station','',2,'Off Abraham Adesanya Estate, Ogombo-Ajah','07063393241','State Fire Service',510),
  (13, 'Ojo Fire Station','',2,'Ojo Council Secretariat, Olojo Drive, Ojo, Lagos.','07063393242','State Fire Service',519),
  (14, 'Abesan Fire Station','',2,'Abesan Housing Estate, Ipaja.','08135659817','State Fire Service',505),
  (15, 'Ejigbo Fire Station','',2,'Ejigbo Council Secretariat, Ikotun Egbe Road, NNPC Bus Stop, Ejigbo.','09055694396','State Fire Service',505),
  (16, 'Unilag Fire Service','',2,'University of Lagos, Akoka, Lagos','+234 7086196426','Federal Fire Service',517),
  (17, 'Federal Fire Service','',2,'27 Awolowo Rd Ikoyi,','09055694396','Federal Fire Service',510),
  (18, 'Federal Fire Service Festac Town','',2,'Festac Town.','09055694396','Federal Fire Service',506),
  (19, 'Federal Fire Service  Surulere','',2,'92 Clegg St, Ojuelegba.','08032003557','Federal Fire Service',522),
  (21, 'Federal Fire Service Ebute-Metta','',2,'Savage St, Ebute Metta, Lagos','08069051020','Federal Fire Service',517),
  (22, 'Federal Fire Service Apapa','',2,'Malu Road, Apapa, Lagos','','Federal Fire Service',507),
  (23, 'Lagos State Fire Service Ajao Estate','',2,'9 Canal View Layout, Ajao Estate, Lagos','','State Fire Service',520),
  (24, 'Unilag Fire Station High Rise Station','',2,'Eni-Njoku Rd, Lagos Mainland, Lagos.','07086196426','Federal Fire Service',517),
  (25, 'Lekki Fire Service','',2,'Laura Stephens Rd, Eti-Osa, Lekki, Lagos.','','State Fire Service',510),
  (26, 'Federal Fire Service Ikoyi','',2,'Ikoyi, 27 Awolowo Rd, Lagos','08166215398','Federal Fire Service',510),
  (27, 'Lagos State Fire Service Ebute-Elefun','',2,'Adeniji Adele Rd, Lagos Island, Lagos','09055694396','State Fire Service',516),
  (28, 'Lagos State Fire Service Ajegunle','',2,'220 Ojo Rd, Alaba, Lagos 102103, Lagos','08033235891','State Fire Service',519),
  (29, 'Lagos State Fire Service Onikan','',2,'Opposite City Mall, Onikan, Awolowo Rd, Lagos','08033235891','State Fire Service',516),
  
);
echo json_encode($fire_stations);
?>