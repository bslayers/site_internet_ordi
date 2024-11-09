<?php
$zonePrincipale = '<h2>À propos de moi</h2>
<p>Je suis ? ?.</p>
<p>Ce site permet de consulter une liste de composant utilisé dans des ordinateurs</p>
<p><b>Liste des points que j\'ai réalisé</b></p>
<ul>
    <li>Une liste pour chaque base de donnees</li>
    <li>La possibilité de modifier n\'importe quel élément des différentes bases de données </li>
    <li>La possibilité de selectionner n\'importe quel élément des différentes bases de données pour avoir plus d\info sur l\'element selectionné</li>
    <li>La possibilité de supprimer n\'importe quel élément des différentes bases de données </li>
    <li>La possibilité de créér n\'importe quel élément dans les différentes bases de données </li>
    <li>Il y a une demande de confirmation lorsque l\'utilisateur souhaite supprimer ou modifier une donnée </li>
    <li>J\'ai fais comme <b>complément</b> la possibilité de trier en fonction du prix ou de la marque </li>
    <li>Le trie en fonction de la marque ce fait forcement dans l\'ordre alphabétique contrairement au prix</li>
    <li>j\'ai aussi fait comme <b>complément</b> un formulaire de recherche. Il est important de préciser qu\'il ne prend pas en compte de si on a trié ou pas la liste</li>
    <li>donc recherche et trie ne sont pas compatible sur ce site</li>
</ul>
<p><b>Point qu\'il me semble utile de signaler:</b></p>
<ul>
    <li>Je ne sais pas si mes package sont correctement ranger j\'ai fait comme je le pensais mais en raison du nombre de base de donnée differente je ne savais pas trop</li>
    <li>J\'ai créer des fonctions qui sont dans connection.php pour améliorer la lisibilité du code et pour diminuer le nombre de réptition</li>
    <li>Dans le fichier de chaque class il y a une methode verifierFormulaire qui est utiliser dans leur fichier update et insert respectif</li>
    <li>Le dossier include comprends des packages qui contiennent eux meme tout ce qui correspond au class a l\'exeption du package config qui comprend connection et apropos</li>
    <li>J\'ai laissé le package contenu qui comprend les fichier .sql pour si vous avez besoin de voir comment les tables ont étaient construite </li>
</ul>';
$zoneAjouter = '';


// Inclure le squelette de la page
$root = $_SERVER["DOCUMENT_ROOT"];
$nomClasse = 'aPropos';
include($root."/squelettes/squelette.php");
?>
