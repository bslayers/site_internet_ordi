DROP TABLE IF EXISTS `ALIMENTATION`;
CREATE TABLE ALIMENTATION ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL, marque VARCHAR(100) NOT NULL, puissance INT NOT NULL, norme_80_plus VARCHAR(20) NOT NULL,modularites VARCHAR(30) NOT NULL, 
format VARCHAR(20) NOT NULL, prix FLOAT(10,2) NOT NULL);

INSERT INTO `ALIMENTATION` (`id`, `nom`, `marque`, `puissance`, `norme_80_plus`, `modularites`, `format`, `prix`) VALUES
('1', 'DarkPower 13', 'be quiet!', '1000', 'Titanium', 'modulaire', 'ATX', '299.95'),
('2', 'TX750M', 'Corsair', '750', 'Gold', 'modulaire', 'ATX', '129.99'),
('3', 'RM1000x', 'Corsair', '1000', 'Gold', 'modulaire', 'ATX', '199.99'),
('4', 'HX1200', 'Corsair', '1200', 'Platinum', 'modulaire', 'ATX', '299.99'),
('5', 'Seasonic Prime TX-850', 'Seasonic', '850', 'Titanium', 'modulaire', 'ATX', '279.99'),
('6', 'MasterWatt 750', 'Cooler Master', '750', 'Gold', 'modulaire', 'ATX', '99.99'),
('7', 'Thermaltake Toughpower GF1 750W', 'Thermaltake', '750', 'Gold', 'modulaire', 'ATX', '129.99'),
('8', 'RM850i', 'Corsair', '850', 'Platinum', 'modulaire', 'ATX', '199.99'),
('9', 'Focus GX-750', 'Seasonic', '750', 'Gold', 'modulaire', 'ATX', '119.99'),
('10', 'Straight Power 11', 'be quiet!', '850', 'Gold', 'modulaire', 'ATX', '169.90'),
('11', 'PRIME TX-750', 'Seasonic', '750', 'Titanium', 'modulaire', 'ATX', '249.99');