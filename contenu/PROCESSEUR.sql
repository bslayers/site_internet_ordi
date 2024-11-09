DROP TABLE IF EXISTS `PROCESSEUR`;
CREATE TABLE PROCESSEUR ( id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL, marque VARCHAR(100) NOT NULL, generation VARCHAR(20) NOT NULL, coeur INT NOT NULL, controleur_memoire VARCHAR(30) NOT NULL, 
prix FLOAT(10,2) NOT NULL);

INSERT INTO `PROCESSEUR` (`id`, `nom`, `marque`, `generation`, `coeur`, `controleur_memoire`,`prix`) VALUES
('1', 'Intel Core i9-13900 (2.0 GHz / 5.6 GHz)', 'Intel', '13eme', '24', 'DDR4/DDR5', '759.95'),
('2', 'AMD Ryzen 9 7900X (3.3 GHz / 4.6 GHz)', 'AMD', 'Zen 3', '12', 'DDR4', '499.95'),
('3', 'Intel Core i7-11700K (3.6 GHz / 5.0 GHz)', 'Intel', '11eme', '8', 'DDR4', '429.95'),
('4', 'AMD Ryzen 7 5800X (3.8 GHz / 4.7 GHz)', 'AMD', 'Zen 3', '8', 'DDR4', '399.95'),
('5', 'Intel Core i5-12600K (3.7 GHz / 4.9 GHz)', 'Intel', '12eme', '6', 'DDR4', '299.95'),
('6', 'AMD Ryzen 5 5600X (3.7 GHz / 4.6 GHz)', 'AMD', 'Zen 3', '6', 'DDR4', '279.95'),
('7', 'Intel Core i9-11900K (3.5 GHz / 5.3 GHz)', 'Intel', '11eme', '8', 'DDR4', '699.95'),
('8', 'AMD Ryzen 9 5900X (3.7 GHz / 4.8 GHz)', 'AMD', 'Zen 3', '12', 'DDR4', '699.95'),
('9', 'Intel Core i5-11600K (3.9 GHz / 4.9 GHz)', 'Intel', '11eme', '6', 'DDR4', '279.95'),
('10', 'AMD Ryzen 7 3700X (3.6 GHz / 4.4 GHz)', 'AMD', 'Zen 2', '8', 'DDR4', '329.95'),
('11', 'Intel Core i3-10100F (3.6 GHz / 4.3 GHz)', 'Intel', '10eme', '4', 'DDR4', '99.95');
