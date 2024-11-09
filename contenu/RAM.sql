DROP TABLE IF EXISTS `RAM`;
CREATE TABLE RAM ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL, marque VARCHAR(100) NOT NULL, type_memoire VARCHAR(10) NOT NULL, frequence VARCHAR(20) NOT NULL, nb_barettes INT NOT NULL, 
capacites_totale INT NOT NULL, led VARCHAR(10) NOT NULL, prix FLOAT(10,2) NOT NULL);

INSERT INTO `RAM` (`id`, `nom`, `marque`, `type_memoire`, `frequence`, `nb_barettes`, `capacites_totale`,`led`, `prix`) VALUES
('1', 'Corsair Vengeance DDR5 64Go 6600MHz', 'Corsair', 'DDR5', '6600MHz CL32', '2', '64','non', '486.95'),
('2', 'G.Skill Trident Z Neo 32Go 3600MHz', 'G.Skill', 'DDR4', '3600MHz CL16', '2', '32', 'oui', '259.99'),
('3', 'HyperX Fury DDR4 16Go 3200MHz', 'HyperX', 'DDR4', '3200MHz CL16', '1', '16', 'non', '89.99'),
('4', 'Crucial Ballistix DDR4 64Go 3600MHz', 'Crucial', 'DDR4', '3600MHz CL16', '4', '64', 'non', '534.99'),
('5', 'Corsair Dominator Platinum RGB DDR4 32Go 3200MHz', 'Corsair', 'DDR4', '3200MHz CL16', '4', '32', 'oui', '304.99'),
('6', 'Kingston HyperX Predator DDR4 32Go 3600MHz', 'Kingston', 'DDR4', '3600MHz CL17', '2', '32', 'non', '239.99'),
('7', 'ADATA XPG Spectrix DDR4 16Go 3200MHz', 'ADATA', 'DDR4', '3200MHz CL16', '2', '16', 'oui', '89.99'),
('8', 'TeamGroup T-Force Night Hawk DDR4 32Go 3200MHz', 'TeamGroup', 'DDR4', '3200MHz CL14', '2', '32', 'oui', '229.99'),
('9', 'Patriot Viper RGB DDR4 16Go 3600MHz', 'Patriot', 'DDR4', '3600MHz CL18', '2', '16', 'oui', '94.99'),
('10', 'OLOy Warhawk RGB DDR4 32Go 3600MHz', 'OLOy', 'DDR4', '3600MHz CL18', '2', '32', 'oui', '204.99'),
('11', 'Mushkin Redline DDR4 64Go 3600MHz', 'Mushkin', 'DDR4', '3600MHz CL18', '4', '64', 'non', '514.99');
