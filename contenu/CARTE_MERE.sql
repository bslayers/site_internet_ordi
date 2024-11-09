DROP TABLE IF EXISTS `CARTE_MERE`;
CREATE TABLE CARTE_MERE ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL, marque VARCHAR(100) NOT NULL, chipset VARCHAR(50) NOT NULL, frequence_memoire_max VARCHAR(30) NOT NULL, wifi VARCHAR(10) NOT NULL, 
nb_slot_ram INT NOT NULL, led VARCHAR(10) NOT NULL, format VARCHAR(20) NOT NULL, prix FLOAT(10,2) NOT NULL);

INSERT INTO `CARTE_MERE` (`id`, `nom`, `marque`, `chipset`, `frequence_memoire_max`, `wifi`, `nb_slot_ram`,`led`,`format`, `prix`) VALUES
('1', 'Z790 AORUS ELITE AX', 'Gigabyte ', 'Z790', 'DDR5 7600MHz', 'oui', '4','oui' ,'ATX','369.95'),
('2', 'ROG MAXIMUS Z890', 'Asus', 'Z890', 'DDR5 7500MHz', 'non', '4','oui' ,'ATX','499.95'),
('3', 'MSI MPG Z690 FORCE WIFI', 'MSI', 'Z690', 'DDR5 7200MHz', 'oui', '4','oui' ,'ATX','419.99'),
('4', 'Gigabyte Z690M AORUS PRO AX', 'Gigabyte ', 'Z690', 'DDR5 6800MHz', 'oui', '4','oui' ,'Micro-ATX','269.95'),
('5', 'ASRock Z690 Taichi', 'ASRock', 'Z690', 'DDR5 7600MHz', 'oui', '4','oui' ,'ATX','329.99'),
('6', 'EVGA Z790 DARK', 'EVGA', 'Z790', 'DDR5 7200MHz', 'non', '4','non' ,'ATX','699.99'),
('7', 'ASUS PRIME Z590-P', 'Asus', 'Z590', 'DDR4 5400MHz', 'non', '4','non' ,'ATX','199.99'),
('8', 'Gigabyte X570 AORUS XTREME', 'Gigabyte ', 'X570', 'DDR4 5400MHz', 'non', '4','oui' ,'ATX','699.95'),
('9', 'ASRock B550 Taichi', 'ASRock', 'B550', 'DDR4 5400MHz', 'oui', '4','oui' ,'ATX','329.99'),
('10', 'MSI MPG B450I GAMING PLUS AC', 'MSI', 'B450', 'DDR4 3466MHz', 'oui', '2','non' ,'Mini-ITX','139.99');
