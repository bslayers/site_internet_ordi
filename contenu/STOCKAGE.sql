DROP TABLE IF EXISTS `STOCKAGE`;
CREATE TABLE STOCKAGE ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL, marque VARCHAR(100) NOT NULL, type VARCHAR(10) NOT NULL, capacites VARCHAR(20) NOT NULL, vitesse_lecture VARCHAR(30) NOT NULL, 
vitesse_ecriture VARCHAR(30) NOT NULL, prix FLOAT(10,2) NOT NULL);

INSERT INTO `STOCKAGE` (`id`, `nom`, `marque`, `type`, `capacites`, `vitesse_lecture`, `vitesse_ecriture`, `prix`) VALUES
('1', 'Corsair Force MP600 Pro 4 To', 'Corsair', 'SSD M.2', '4To', '7000 Mo/s', '6850 Mo/s', '929.95'),
('2', 'Samsung 980 PRO 1 To', 'Samsung', 'SSD M.2', '1To', '7000 Mo/s', '5000 Mo/s', '219.95'),
('3', 'Western Digital Black SN750 2 To', 'Western Digital', 'SSD M.2', '2To', '3470 Mo/s', '3000 Mo/s', '399.95'),
('4', 'Seagate IronWolf 16 To', 'Seagate', 'HDD', '16To', '210 Mo/s', '210 Mo/s', '599.95'),
('5', 'Toshiba X300 6 To', 'Toshiba', 'HDD', '6To', '220 Mo/s', '220 Mo/s', '149.95'),
('6', 'Crucial MX500 2 To', 'Crucial', 'SSD 2,5 pouces', '2To', '560 Mo/s', '510 Mo/s', '239.95'),
('7', 'ADATA XPG Spectrix S40G 1 To', 'ADATA', 'SSD M.2', '1To', '3500 Mo/s', '3000 Mo/s', '149.95'),
('8', 'Kingston A2000 500 Go', 'Kingston', 'SSD M.2', '500Go', '2200 Mo/s', '2000 Mo/s', '79.95'),
('9', 'SanDisk Extreme PRO 2 To', 'SanDisk', 'SSD portable', '2To', '1050 Mo/s', '1000 Mo/s', '399.95'),
('10', 'Crucial P5 Plus 2 To', 'Crucial', 'SSD M.2', '2To', '6600 Mo/s', '5000 Mo/s', '399.95'),
('11', 'Seagate Expansion Desktop 14 To', 'Seagate', 'HDD externe', '14To', '120 Mo/s', '120 Mo/s', '279.95');