<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
class Barrette_de_ram{
    private $id;
    private $nom;
    private $marque;
    private $type_memoire; //DDR4 ou DDR5
    private $frequence;
    private $nb_barettes;
    private $capacites_totale;
    private $led; //oui ou non
    private $prix;

    //Constructeur
    public function __construct($id,$nom,$marque,$type_memoire,$frequence,$nb_barettes,$capacites_totale,$led,$prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->marque = $marque;
        $this->type_memoire = $type_memoire;
        $this->frequence = $frequence;
        $this->nb_barettes = $nb_barettes;
        $this->capacites_totale = $capacites_totale;
        $this->led = $led;
        $this->prix = $prix;
    }

    //
    public function __toString(){
        $info = "id: ".$this->id."<br>nom: ".$this->nom."<br> marque: ".$this->marque."<br> type memoire: ".$this->type_memoire."<br>";
        $info .= "frequence: ".$this->frequence."<br> nb barettes: ".$this->nb_barettes;
        $info .= "<br>capacites totale: ".$this->capacites_totale."<br>led: ".$this->led."<br> prix: ".$this->prix."<br>";
        return $info;
    }
}

$id=null;$nom = null;$marque = null;$type_memoire = null;$frequence =  null;$nb_barettes = null;$capacites_totale=null;$led=null;$prix = null;
$erreur=array("nom"=>null,"marque"=>null,"type_memoire"=>null,"frequence"=>null,"nb_barettes"=>null,"capacites_totale"=>null,"led"=>null,"prix"=>null);
$tab_ram=array();

//fonction pour gerer les erreurs elle est créer la pour eviter la répition dans insert et update
function validerFormulaire($nom,$marque,$type_memoire,$frequence,$nb_barettes,$capacites_totale,$led,$prix){
    $erreur = array();
    if ($nom=="")     $erreur["nom"] ="il manque un nom";
    if ($marque=="") $erreur["marque"] ="il manque le nom de la marque";

    if ($type_memoire=="") $erreur["type_memoire"] ="il manque le type de memoire (DDR4/DDR5)";
    else if (is_numeric($type_memoire)==true) $erreur["type_memoire"] ="le type de memoire ne doit pas etre un nombre (DDR4/DDR5)";
    else if (strlen($type_memoire)>10) $erreur["type_memoire"] ="le type de memoire doit contenir moins de caractere (DDR4/DDR5)";

    if ($frequence=="") $erreur["frequence"] ="il manque la frequence ";
    else if (is_numeric($frequence)==true) $erreur["frequence"] ="la frequence ne doit pas etre que des nombre";
    else if (strlen($frequence)>20) $erreur["frequence"] ="la frequence doit contenir moins de caractere";

    if ($nb_barettes=="")     $erreur["nb_barettes"] ="il manque le nb de barettes";
    else if (is_numeric($nb_barettes)==false) $erreur["nb_barettes"] ="le nb de barettes doit etre un nombre";

    if ($capacites_totale=="")     $erreur["capacites_totale"] ="il manque la capacité totale";
    else if (is_numeric($capacites_totale)==false) $erreur["capacites_totale"] ="la capacité totale doit etre un nombre";

    if ($led=="") $erreur["led"] ="il manque la led (oui/non)";
    else if (is_numeric($led)==true) $erreur["led"] ="la led ne doit pas etre un nombre (oui/non)";
    else if (strlen($led)>10) $erreur["led"] ="la led doit contenir moins de caractere (oui/non)";

    if ($prix=="")     $erreur["prix"] ="il manque un prix";
    else if (is_numeric($prix)==false) $erreur["prix"] ="le prix doit etre un nombre";

    return $erreur;
}


switch ($action){

    case 'liste':
        $cible='liste';
		$requete="SELECT * FROM RAM";
        $nomPackage = "ram";
        $nomClasse = "Barrette_de_ram";
        $phraseListe = "Liste des Barrettes de RAM";
        $phraseAjout = "des barrettes de RAM";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM RAM WHERE nom LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM RAM";
        }
        $nomPackage = "ram";
        $nomClasse = "Barrette_de_ram";
        $phraseListe = "Liste des Barrettes de RAM";
        $phraseAjout = "des barrettes de RAM";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
        break;

    case 'select':
        $id=$_GET["id"];
        $corps="<h1>Sélection de la RAM</h1>" ;
        $connection =connecter();
        $requete="SELECT * FROM RAM where id=$id";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() ){
            $corps .= "id: ".$enregistrement->id."<br>nom: ".$enregistrement->nom."<br>marque: ".$enregistrement->marque."<br>";
            $corps.= "type memoire: ".$enregistrement->type_memoire."<br>frequence: ".$enregistrement->frequence."<br>nomnre barettes: ".$enregistrement->nb_barettes."<br>";
            $corps.= "capacites totale: ".$enregistrement->capacites_totale."<br>led: ".$enregistrement->led."<br>prix: ".$enregistrement->prix."<br>";
        }
        $query = null;
        $connection = null;
        $zonePrincipale=$corps;
        $zoneAjouter="";
        $nomClasse = "Barrette_de_ram";
        break;

    case 'update':
        $cible="update";
        include("updateRam.php");
        $zoneAjouter="";
        $nomClasse = "Barrette_de_ram";
        break;

    case 'insert':
        $cible="insert";
        include("insertRam.php");
        $zoneAjouter="";
        $nomClasse = "Barrette_de_ram";
        break;

    case 'delete':
        $cible="delete";
        $corps=supprimer_base("RAM","Barrette_de_ram","ces barrettes de ram");
        $zonePrincipale = $corps;
        $zoneAjouter="";
        $nomClasse = "Barrette_de_ram";
        break;

    case 'sauvegarde':
        $cible='sauvegarde';
        $connection =connecter();
        $type = key_exists('type',$_POST)? $_POST['type']: null;
        $id = key_exists('id',$_POST)? $_POST['id']: null;
        $sql = key_exists('sql',$_POST)? $_POST['sql']: null;
        $nom = key_exists('nom',$_POST)? $_POST['nom']: null;
        $marque = key_exists('marque',$_POST)? $_POST['marque']: null;
        $type_memoire = key_exists('type_memoire',$_POST)? $_POST['type_memoire']: null;
        $frequence = key_exists('frequence',$_POST)? $_POST['frequence']: null;
        $nb_barettes = key_exists('nb_barettes',$_POST)? $_POST['nb_barettes']: null;
        $capacites_totale = key_exists('capacites_totale',$_POST)? $_POST['capacites_totale']: null;
        $led = key_exists('led',$_POST)? $_POST['led']: null;
        $prix = key_exists('prix',$_POST)? $_POST['prix']: null;
        if ($type =='confirmupdate'){
            $corps="<h1>Mise à jour de la barrette de ram ".$id."</h1>" ;
            $data = array(
                ":id" => $id , ":nom" => $nom,
                ":marque" => $marque,":type_memoire" => $type_memoire,
                ":frequence"=>$frequence,":nb_barettes"=>$nb_barettes,
                ":capacites_totale"=>$capacites_totale,":led"=>$led,
                ":prix"=>$prix
            );
            $req=$connection->prepare($sql);
            $req->execute($data);
        }
        else{
            $corps="<h1>Suppression de la barrette de ram ".$id."</h1>";
            $req=$connection->prepare($sql);
            $req->bindParam(':id', $id);
            $req->execute();
        }

        $zonePrincipale=$corps ;
        $connection = null;
        $zoneAjouter="";
        $nomClasse = "Barrette_de_ram";
        break;

    case "trieMarque":
        $cible='liste';
		$requete="SELECT * FROM RAM ORDER BY marque ASC";
        $nomPackage = "ram";
        $nomClasse = "Barrette_de_ram";
        $phraseListe = "Liste des Barrettes de RAM";
        $phraseAjout = "des barrettes de RAM";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixASC":
        $cible='liste';
		$requete="SELECT * FROM RAM ORDER BY prix ASC";
        $nomPackage = "ram";
        $nomClasse = "Barrette_de_ram";
        $phraseListe = "Liste des Barrettes de RAM";
        $phraseAjout = "des barrettes de RAM";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixDESC":
        $cible='liste';
		$requete="SELECT * FROM RAM ORDER BY prix DESC";
        $nomPackage = "ram";
        $nomClasse = "Barrette_de_ram";
        $phraseListe = "Liste des Barrettes de RAM";
        $phraseAjout = "des barrettes de RAM";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;


    default:
    $zonePrincipale="" ;
    $zoneAjouter="";
    $nomClasse = "Barrette_de_ram";
    break;
}
include($root."/squelettes/squelette.php");
?>
