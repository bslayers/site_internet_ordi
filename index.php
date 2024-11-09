<?php
$root = $_SERVER["DOCUMENT_ROOT"]; //pour récuperer la racine du serveur
include_once($root."../include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;

switch ($action){


    case 'liste':
        $cible='liste';
		$requete="SELECT * FROM COMPOSANT";
        $nomClasse = "index";
        $phraseListe = "Liste des differents Composant";
        $listeduComposant = composant($requete,$nomClasse,$phraseListe);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;


    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM COMPOSANT WHERE type LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM COMPOSANT";
        }
        $nomClasse = "index";
        $phraseListe = "Liste des differents Composant";
        $listeduComposant = composant($requete,$nomClasse,$phraseListe);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
        break;

    //associe à chaque idée un lien vers la class php corespondante
    case 'select':
        $id=$_GET["id"];
        if ($id == 1){
            header("Location:include/alimentation/Alimentation.php?action=liste");
        }
        if ($id == 2){
            header("Location:include/ram/Barrette_de_ram.php?action=liste");
        }
        if ($id == 3){
            header("Location:include/boitier/Boitier.php?action=liste");
        }
        if ($id == 4){
            header("Location:include/carte_graphique/Carte_graphique.php?action=liste");
        }
        if ($id == 5){
            header("Location:include/carte_mere/Carte_mere.php?action=liste");
        }
        if ($id == 6){
            header("Location:include/processeur/Processeur.php?action=liste");
        }
        if ($id == 7){
            header("Location:include/stockage/Stockage.php?action=liste");
        }
        $connection = null;
        $zonePrincipale="";
        $zoneAjouter="";
        $nomClasse = "index";
        break;

    default:
    $cible='liste';
    $requete="SELECT * FROM COMPOSANT";
    $nomClasse = "index";
    $phraseListe = "Liste des differents Composant";
    $listeduComposant = composant($requete,$nomClasse,$phraseListe);
    $zoneAjouter = $listeduComposant[1];
    $zonePrincipale = $listeduComposant[0];
    break;
}
include("squelettes/squelette.php");

?>
