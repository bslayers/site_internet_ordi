DROP TABLE IF EXISTS `COMPOSANT`;
CREATE TABLE COMPOSANT (id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, type VARCHAR(50) NOT NULL);

INSERT INTO `COMPOSANT` (`id`,`type`) VALUES
 ('1','Alimentation'),
 ('2','Barette de ram'),
 ('3','Boitier'),
 ('4','Carte Graphique'),
 ('5','Carte Mère'),
 ('6','Processeur'),
 ('7','Stockage');
