DROP TABLE IF EXISTS `CARTE_GRAPHIQUE`;
CREATE TABLE CARTE_GRAPHIQUE ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL, marque VARCHAR(100) NOT NULL, chipset_Graphique VARCHAR(30) NOT NULL, memoire_video INT NOT NULL, consommation INT NOT NULL, 
prix FLOAT(10,2) NOT NULL);

INSERT INTO `CARTE_GRAPHIQUE` (`id`, `nom`, `marque`, `chipset_Graphique`, `memoire_video`, `consommation`, `prix`) VALUES
('1', 'ASUS ROG Strix 4090OC 24GB', 'ASUS ', 'RTX 4090 OC', '24', '450', '2449.96'),
('2', 'MSI RTX 3080 Ti SUPRIM X 12G', 'MSI', 'RTX 3080 Ti', '12', '400', '1899.95'),
('3', 'Gigabyte AORUS Radeon RX 6900 XT 16G', 'Gigabyte', 'Radeon RX 6900 XT', '16', '330', '2099.95'),
('4', 'EVGA GeForce RTX 3070 FTW3 Ultra Gaming 8G', 'EVGA', 'RTX 3070', '8', '300', '1199.95'),
('5', 'ZOTAC GAMING GeForce RTX 3060 AMP White Edition 12G', 'ZOTAC', 'RTX 3060', '12', '170', '899.95'),
('6', 'PNY XLR8 Gaming EPIC-X RGB DDR4 32GB', 'PNY', 'Geforce RTX 3060', '6', '170', '429.95'),
('7', 'ASUS ROG Strix LC Radeon RX 6900 XT OC 16G', 'ASUS', 'Radeon RX 6900 XT', '16', '330', '2349.95'),
('8', 'Gigabyte GeForce RTX 2060 SUPER WINDFORCE OC 8G', 'Gigabyte', 'RTX 2060 SUPER', '8', '175', '729.95'),
('9', 'ASRock Radeon RX 6700 XT Challenger Pro 12G OC', 'ASRock', 'Radeon RX 6700 XT', '12', '230', '849.95'),
('10', 'Sapphire PULSE Radeon RX 6600 XT 8G', 'Sapphire', 'Radeon RX 6600 XT', '8', '160', '579.95');