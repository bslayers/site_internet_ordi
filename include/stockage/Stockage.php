<?php
$root =$_SERVER['DOCUMENT_ROOT'];
include_once($root."/include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
class Stockage{
    private $id;
    private $nom;
    private $marque;
    private $type; //SSD M.2 ou SSD normal ou HDD
    private $capacites;
    private $vitesse_lecture;
    private $vitesse_ecriture;
    private $prix;

    //Constructeur
    public function __construct($id,$nom,$marque,$type,$capacites,$vitesse_lecture,$vitesse_ecriture,$prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->marque = $marque;
        $this->type = $type;
        $this->capacites = $capacites;
        $this->vitesse_lecture = $vitesse_lecture;
        $this->vitesse_ecriture = $vitesse_ecriture;
        $this->prix = $prix;
    }

    //
    public function __toString(){
        $info = "id: ".$this->id."<br>nom: ".$this->nom."<br> marque: ".$this->marque."<br> type: ".$this->type."<br>";
        $info .= "capacites: ".$this->capacites."<br> vitesse lecture: ".$this->vitesse_lecture;
        $info .= "<br>vitesse ecriture: ".$this->vitesse_ecriture."<br>prix: ".$this->prix."<br>";
        return $info;
    }
}



$id=null;$nom = null;$marque = null;$type = null;$capacites =  null;$vitesse_lecture = null;$vitesse_ecriture=null;$prix = null;
$erreur=array("nom"=>null,"marque"=>null,"type"=>null,"capacites"=>null,"vitesse_lecture"=>null,"vitesse_ecriture"=>null,"prix"=>null);
$tab_stockage=array();

//fonction pour gerer les erreurs elle est créer la pour eviter la répition dans insert et update
function validerFormulaire($nom,$marque,$type,$capacites,$vitesse_lecture,$vitesse_ecriture,$prix){
    $erreur = array();
    if ($nom=="")     $erreur["nom"] ="il manque un nom";
    if ($marque=="") $erreur["marque"] ="il manque une marque";

    if ($type=="") $erreur["type"] ="il manque le type (SSD M.2/ SSD / HDD)";
    else if (is_numeric($type)==true) $erreur["type"] ="le type ne doit pas etre un nombre (SSD M.2/ SSD / HDD)";
    else if (strlen($type)>10) $erreur["type"] ="le type doit contenir moins de caractere (SSD M.2/ SSD / HDD)";

    if ($capacites=="") $erreur["capacites"] ="il manque la capacites";
    else if (is_numeric($capacites)==true) $erreur["capacites"] ="la capacites ne doit pas etre que des nombres";
    else if (strlen($capacites)>20) $erreur["capacites"] ="la capacites doit contenir moins de caractere";

    if ($vitesse_lecture=="")     $erreur["vitesse_lecture"] ="il manque la vitesse de lecture";
    else if (is_numeric($vitesse_lecture)==true) $erreur["vitesse_lecture"] ="la vitesse de lecture ne doit pas etre un nombre ";
    else if (strlen($vitesse_lecture)>30) $erreur["vitesse_lecture"] ="la vitesse de lecture doit contenir moins de caractere ";

    if ($vitesse_ecriture=="")     $erreur["vitesse_ecriture"] ="il manque la vitesse d'écriture";
    else if (is_numeric($vitesse_ecriture)==true) $erreur["vitesse_ecriture"] ="la vitesse d'écriture ne doit pas etre un nombre ";
    else if (strlen($vitesse_ecriture)>30) $erreur["vitesse_ecriture"] ="la vitesse d'écriture doit contenir moins de caractere ";

    if ($prix=="")     $erreur["prix"] ="il manque un prix";
    else if (is_numeric($prix)==false) $erreur["prix"] ="le prix doit etre un nombre";

    return $erreur;
}

switch ($action){

    case 'liste':
        $cible='liste';
		$requete="SELECT * FROM STOCKAGE";
        $nomPackage = "stockage";
        $nomClasse = "Stockage";
        $phraseListe = "Liste des Stockage";
        $phraseAjout = "un stockage";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM STOCKAGE WHERE nom LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM STOCKAGE";
        }
        $nomPackage = "stockage";
        $nomClasse = "Stockage";
        $phraseListe = "Liste des Stockage";
        $phraseAjout = "un stockage";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
        break;

    case 'select':
        $id=$_GET["id"];
        $corps="<h1>Sélection du stockage</h1>" ;
        $connection =connecter();
        $requete="SELECT * FROM STOCKAGE where id=$id";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() ){
            $corps .= "id:".$enregistrement->id."<br>nom:".$enregistrement->nom."<br>marque:".$enregistrement->marque."<br>";
            $corps.= "type:".$enregistrement->type."<br>capacites:".$enregistrement->capacites."<br>vitesse lecture:".$enregistrement->vitesse_lecture."<br>";
            $corps.= "vitesse ecriture:".$enregistrement->vitesse_ecriture."<br>prix:".$enregistrement->prix."<br>";
        }
        $query = null;
        $connection = null;
        $zonePrincipale=$corps;
        $zoneAjouter="";
        $nomClasse = "Stockage";
        break;

    case 'update':
        $cible="update";
        include("updateStockage.php");
        $zoneAjouter="";
        $nomClasse = "Stockage";
        break;

    case 'insert':
        $cible="insert";
        include("insertStockage.php");
        $zoneAjouter="";
        $nomClasse = "Stockage";
        break;

    case 'delete':
        $cible="delete";
        $corps=supprimer_base("STOCKAGE","Stockage","ce stockage");
        $zonePrincipale = $corps;
        $zoneAjouter="";
        $nomClasse = "Stockage";
        break;

    case 'sauvegarde':
        $cible='sauvegarde';
        $connection =connecter();
        $types = key_exists('types',$_POST)? $_POST['types']: null;
        $id = key_exists('id',$_POST)? $_POST['id']: null;
        $sql = key_exists('sql',$_POST)? $_POST['sql']: null;
        $nom = key_exists('nom',$_POST)? $_POST['nom']: null;
        $marque = key_exists('marque',$_POST)? $_POST['marque']: null;
        $type = key_exists('type',$_POST)? $_POST['type']: null;
        $capacites = key_exists('capacites',$_POST)? $_POST['capacites']: null;
        $vitesse_lecture = key_exists('vitesse_lecture',$_POST)? $_POST['vitesse_lecture']: null;
        $vitesse_ecriture = key_exists('vitesse_ecriture',$_POST)? $_POST['vitesse_ecriture']: null;
        $prix = key_exists('prix',$_POST)? $_POST['prix']: null;
        if ($types =='confirmupdate'){
            $corps="<h1>Mise à jour du Stockage ".$id."</h1>" ;
            $data = array(
                ":id" => $id , ":nom" => $nom,
                ":marque" => $marque,":type" => $type,
                ":capacites"=>$capacites,":vitesse_lecture"=>$vitesse_lecture,
                ":vitesse_ecriture"=>$vitesse_ecriture,":prix"=>$prix
            );
            $req=$connection->prepare($sql);
            $req->execute($data);
        }
        else{
            $corps="<h1>Suppression du Stockage ".$id."</h1>";
            $req=$connection->prepare($sql);
            $req->bindParam(':id', $id);
            $req->execute();
        }
        $zonePrincipale=$corps ;
        $connection = null;
        $zoneAjouter="";
        $nomClasse = "Stockage";
        break;

    case "trieMarque":
        $cible='liste';
        $requete="SELECT * FROM STOCKAGE ORDER BY marque ASC";
        $nomPackage = "stockage";
        $nomClasse = "Stockage";
        $phraseListe = "Liste des Stockage";
        $phraseAjout = "un stockage";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixASC":
        $cible='liste';
        $requete="SELECT * FROM STOCKAGE ORDER BY prix ASC";
        $nomPackage = "stockage";
        $nomClasse = "Stockage";
        $phraseListe = "Liste des Stockage";
        $phraseAjout = "un stockage";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixDESC":
        $cible='liste';
        $requete="SELECT * FROM STOCKAGE ORDER BY prix DESC";
        $nomPackage = "stockage";
        $nomClasse = "Stockage";
        $phraseListe = "Liste des Stockage";
        $phraseAjout = "un stockage";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    default:
    $zonePrincipale="" ;
    $zoneAjouter="";
    $nomClasse = "Stockage";
    break;
}

include($root."/squelettes/squelette.php");

?>
