DROP TABLE IF EXISTS `BOITIER`;
CREATE TABLE BOITIER ( idP INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL, marque VARCHAR(100) NOT NULL, type_tour VARCHAR(20) NOT NULL, format VARCHAR(20) NOT NULL, fenetre VARCHAR(10) NOT NULL, 
couleur VARCHAR(20) NOT NULL, led VARCHAR(10) NOT NULL, prix FLOAT(10,2) NOT NULL);

INSERT INTO `BOITIER` (`idP`, `nom`, `marque`, `type_tour`, `format`, `fenetre`, `couleur`,`led`, `prix`) VALUES
('1', 'Corsair iCUE 5000T', 'Corsair', 'moyen-tour', 'ATX', 'oui', 'noir',"oui", '449.95'),
('2', 'Cooler Master MasterBox MB511 RGB', 'Cooler Master', 'moyen-tour', 'ATX', 'oui', 'noir', 'oui', 89.99),
('3', 'be quiet! Pure Base 500DX', 'be quiet!', 'moyen-tour', 'ATX', 'oui', 'blanc', 'oui', 129.90),
('4', 'Phanteks Enthoo Pro M', 'Phanteks', 'moyen-tour', 'ATX', 'oui', 'noir', 'non', 109.99),
('5', 'Lian Li PC-O11 Dynamic', 'Lian Li', 'grande-tour', 'ATX', 'oui', 'noir', 'non', 159.99),
('6', 'Fractal Design Define R6', 'Fractal Design', 'grande-tour', 'E-ATX', 'non', 'noir', 'non', 169.99),
('7', 'Corsair Obsidian 1000D', 'Corsair', 'très grande-tour', 'E-ATX', 'oui', 'noir', 'oui', 499.99),
('8', 'Thermaltake Core P3', 'Thermaltake', 'ouvert', 'ATX', 'oui', 'noir', 'non', 139.99),
('9', 'NZXT H710', 'NZXT', 'grande-tour', 'E-ATX', 'oui', 'noir', 'non', 169.99),
('10', 'SilverStone Fortress FT05', 'SilverStone', 'moyen-tour', 'ATX', 'non', 'noir', 'non', 169.99),
('11', 'In Win 101C', 'In Win', 'moyen-tour', 'ATX', 'oui', 'noir', 'oui', 109.99);
