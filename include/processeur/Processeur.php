<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
class Processeur{
    private $id;
    private $nom;
    private $marque;
    private $generation; // 12eme, 13eme,...
    private $coeur;
    private $controleur_memoire; //DDR4 ou DDR5
    private $prix;

    //Constructeur
    public function __construct($id,$nom,$marque,$generation,$coeur,$controleur_memoire,$prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->marque = $marque;
        $this->generation = $generation;
        $this->coeur = $coeur;
        $this->controleur_memoire = $controleur_memoire;
        $this->prix = $prix;
    }

    //
    public function __toString(){
        $info = "id: ".$this->id."<br>nom: ".$this->nom."<br> marque: ".$this->marque."<br> chipset graphique: ".$this->generation."<br>";
        $info .= "memoire vidéo: ".$this->coeur."<br> consomation: ".$this->controleur_memoire."<br> prix: ".$this->prix."<br>";
        return $info;
    }
}



$id=null;$nom = null;$marque = null;$generation = null;$coeur =  null;$controleur_memoire = null;$prix = null;
$erreur=array("nom"=>null,"marque"=>null,"generation"=>null,"coeur"=>null,"controleur_memoire"=>null,"prix"=>null);
$tab_processeur=array();

//fonction pour gerer les erreurs elle est créer la pour eviter la répition dans insert et update
function validerFormulaire($nom,$marque,$generation,$coeur,$controleur_memoire,$prix){
    $erreur = array();
    if ($nom=="")     $erreur["nom"] ="il manque un nom";
    if ($marque=="") $erreur["marque"] ="il manque une marque";

    if ($generation=="") $erreur["generation"] ="il manque la generation";
    else if (is_numeric($generation)==true) $erreur["chipset"] ="la generation ne doit pas etre que des nombres";
    else if (strlen($generation)>20) $erreur["chipset"] ="la generation doit contenir moins de caractere";

    if ($coeur=="") $erreur["coeur"] ="il manque le nombre de coeurs";
    else if (is_numeric($coeur)==false) $erreur["coeur"] ="les coeurs doivent etre un nombre";

    if ($controleur_memoire=="")     $erreur["controleur_memoire"] ="il manque le controleur memoire (DDR4/DDR5)";
    else if (is_numeric($controleur_memoire)==true) $erreur["controleur_memoire"] ="le controleur memoire ne doit pas etre un nombre (DDR4/DDR5)";
    else if (strlen($controleur_memoire)>30) $erreur["controleur_memoire"] ="le controleur memoire doit contenir moins de caractere (DDR4/DDR5)";

    if ($prix=="")     $erreur["prix"] ="il manque un prix";
    else if (is_numeric($prix)==false) $erreur["prix"] ="le prix doit un etre un nombre";

    return $erreur;
}


switch ($action){

    case 'liste':
        $cible='liste';
		$requete="SELECT * FROM PROCESSEUR";
        $nomPackage = "processeur";
        $nomClasse = "Processeur";
        $phraseListe = "Liste des Processeur";
        $phraseAjout = "un processeur";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM PROCESSEUR WHERE nom LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM PROCESSEUR";
        }
        $nomPackage = "processeur";
        $nomClasse = "Processeur";
        $phraseListe = "Liste des Processeur";
        $phraseAjout = "un processeur";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'select':
        $id=$_GET["id"];
        $corps="<h1>Sélection du processeur</h1>" ;
        $connection =connecter();
        $requete="SELECT * FROM PROCESSEUR where id=$id";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() ){
            $corps .= "id:".$enregistrement->id."<br>nom:".$enregistrement->nom."<br>marque:".$enregistrement->marque."<br>";
            $corps.= "generation:".$enregistrement->generation."<br>coeur:".$enregistrement->coeur."<br>controleur memoire:".$enregistrement->controleur_memoire."<br>";
            $corps.= "prix:".$enregistrement->prix."<br>";
        }
        $query = null;
        $connection = null;
        $zonePrincipale=$corps;
        $zoneAjouter="";
        $nomClasse = "Processeur";
        break;

    case 'update':
        $cible="update";
        include("updateProcesseur.php");
        $zoneAjouter="";
        $nomClasse = "Processeur";
        break;

    case 'insert':
        $cible="insert";
        include("insertProcesseur.php");
        $zoneAjouter="";
        $nomClasse = "Processeur";
        break;

    case 'delete':
        $cible="delete";
        $corps=supprimer_base("PROCESSEUR","Processeur","ce processeur");
        $zonePrincipale = $corps;
        $zoneAjouter="";
        $nomClasse = "Processeur";
        break;

    case 'sauvegarde':
        $cible='sauvegarde';
        $connection =connecter();
        $type = key_exists('type',$_POST)? $_POST['type']: null;
        $id = key_exists('id',$_POST)? $_POST['id']: null;
        $sql = key_exists('sql',$_POST)? $_POST['sql']: null;
        $nom = key_exists('nom',$_POST)? $_POST['nom']: null;
        $marque = key_exists('marque',$_POST)? $_POST['marque']: null;
        $generation = key_exists('generation',$_POST)? $_POST['generation']: null;
        $coeur = key_exists('coeur',$_POST)? $_POST['coeur']: null;
        $controleur_memoire = key_exists('controleur_memoire',$_POST)? $_POST['controleur_memoire']: null;
        $prix = key_exists('prix',$_POST)? $_POST['prix']: null;
        if ($type =='confirmupdate'){
            $corps="<h1>Mise à jour du Processeur ".$id."</h1>" ;
            $data = array(
                ":id" => $id , ":nom" => $nom,
                ":marque" => $marque,":generation" => $generation,
                ":coeur"=>$coeur,":controleur_memoire"=>$controleur_memoire,
                ":prix"=>$prix
            );
            $req=$connection->prepare($sql);
            $req->execute($data);
        }
        else{
            $corps="<h1>Suppression du Processeur ".$id."</h1>" ;
            $req=$connection->prepare($sql);
            $req->bindParam(':id', $id);
            $req->execute();
        }
        $zonePrincipale=$corps ;
        $connection = null;
        $zoneAjouter="";
        $nomClasse = "Processeur";
        break;

    case "trieMarque":
        $cible='liste';
		$requete="SELECT * FROM PROCESSEUR ORDER BY marque ASC";
        $nomPackage = "processeur";
        $nomClasse = "Processeur";
        $phraseListe = "Liste des Processeur";
        $phraseAjout = "un processeur";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixASC":
        $cible='liste';
		$requete="SELECT * FROM PROCESSEUR ORDER BY prix ASC";
        $nomPackage = "processeur";
        $nomClasse = "Processeur";
        $phraseListe = "Liste des Processeur";
        $phraseAjout = "un processeur";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixDESC":
        $cible='liste';
		$requete="SELECT * FROM PROCESSEUR ORDER BY prix DESC";
        $nomPackage = "processeur";
        $nomClasse = "Processeur";
        $phraseListe = "Liste des Processeur";
        $phraseAjout = "un processeur";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    default:
    $zonePrincipale="" ;
    $zoneAjouter="";
    $nomClasse = "Processeur";
    break;
}
include($root."/squelettes/squelette.php");

?>
