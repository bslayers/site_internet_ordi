<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
class Carte_mere{
    private $id;
    private $nom;
    private $marque;
    private $chipset;
    private $frequence_memoire_max;
    private $wifi; //oui ou non
    private $nb_slot_ram; //2 ou 4
    private $led;
    private $format;
    private $prix;

    //Constructeur
    public function __construct($id,$nom,$marque,$chipset,$frequence_memoire_max,$wifi,$nb_slot_ram,$led,$format,$prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->marque = $marque;
        $this->chipset = $chipset;
        $this->frequence_memoire_max = $frequence_memoire_max;
        $this->wifi = $wifi;
        $this->$nb_slot_ram = $nb_slot_ram;
        $this->led = $led;
        $this->format = $format;
        $this->prix = $prix;
    }

    //
    public function __toString(){
        $info = "id: ".$this->id."<br>nom: ".$this->nom."<br> marque: ".$this->marque."<br> chipset: ".$this->chipset."<br>";
        $info .= "frequence memoire max: ".$this->frequence_memoire_max."<br> wifi: ".$this->wifi."<br> nb slot ram: ".$this->nb_slot_ram;
        $info .= "<br>led: ".$this->led."<br>format: ".$this->format."<br>prix: ".$this->prix."<br>";
        return $info;
    }
}



$id=null;$nom = null;$marque = null;$chipset = null;$frequence_memoire_max =  null;$wifi = null;$nb_slot_ram=null;$led=null;$format=null;$prix = null;
$erreur=array("nom"=>null,"marque"=>null,"chipset"=>null,"frequence_memoire_max"=>null,"wifi"=>null,"nb_slot_ram"=>null,"led"=>null,"format"=>null,"prix"=>null);
$tab_carte_mere=array();

//fonction pour gerer les erreurs elle est créer la pour eviter la répition dans insert et update
function validerFormulaire($nom,$marque,$chipset,$frequence_memoire_max,$wifi,$nb_slot_ram,$led,$format,$prix){
    $erreur = array();
    if ($nom=="")     $erreur["nom"] ="il manque un nom";
    if ($marque=="") $erreur["marque"] ="il manque une marque";

    if ($chipset=="") $erreur["chipset"] ="il manque le chipset";
    else if (is_numeric($chipset)==true) $erreur["chipset"] ="le chipset ne doit pas etre un nombre";
    else if (strlen($chipset)>50) $erreur["chipset"] ="le chipset doit contenir moins de caractere";

    if ($frequence_memoire_max=="") $erreur["frequence_memoire_max"] ="il manque la frequence memoire max";
    else if (is_numeric($frequence_memoire_max)==true) $erreur["frequence_memoire_max"] ="la frequence memoire max ne doit pas etre que des nombre";
    else if (strlen($frequence_memoire_max)>30) $erreur["frequence_memoire_max"] ="la frequence memoire max doit contenir moins de caractere";

    if ($wifi=="")     $erreur["wifi"] ="il manque le wifi (oui/non)";
    else if (is_numeric($wifi)==true) $erreur["wifi"] ="le wifi ne doit pas etre un nombre (oui/non)";
    else if (strlen($wifi)>10) $erreur["wifi"] ="le wifi doit contenir moins de caractere (oui/non)";

    if ($nb_slot_ram=="")     $erreur["nb_slot_ram"] ="il manque le nombre de slot de ram";
    else if (is_numeric($nb_slot_ram)==false) $erreur["nb_slot_ram"] ="le nombre de slot de ram doit un etre un nombre";

    if ($led=="") $erreur["led"] ="il manque la led (oui/non)";
    else if (is_numeric($led)==true) $erreur["led"] ="la led ne doit pas etre un nombre (oui/non)";
    else if (strlen($led)>10) $erreur["led"] ="la led doit contenir moins de caractere (oui/non)";

    if ($format=="") $erreur["format"] ="il manque le format";
    else if (is_numeric($format)==true) $erreur["format"] ="le format ne doit pas etre que des nombre";
    else if (strlen($format)>20) $erreur["format"] ="le format doit contenir moins de caractere";

    if ($prix=="")     $erreur["prix"] ="il manque un prix";
    else if (is_numeric($prix)==false) $erreur["prix"] ="le prix doit un etre un nombre";

    return $erreur;
}



switch ($action){

    case 'liste':
        $cible='liste';
		$requete="SELECT * FROM CARTE_MERE";
        $nomPackage = "carte_mere";
        $nomClasse = "Carte_mere";
        $phraseListe = "Liste des Cartes Mères";
        $phraseAjout = "une carte mère";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM CARTE_MERE WHERE nom LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM CARTE_MERE";
        }
        $nomPackage = "carte_mere";
        $nomClasse = "Carte_mere";
        $phraseListe = "Liste des Cartes Mères";
        $phraseAjout = "une carte mère";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'select':
        $cible="select";
        $id=$_GET["id"];
        $corps="<h1>Sélection de la carte mère</h1>" ;
        $connection =connecter();
        $requete="SELECT * FROM CARTE_MERE where id=$id";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() ){
            $corps .= "id:".$enregistrement->id."<br>nom:".$enregistrement->nom."<br>marque:".$enregistrement->marque."<br>";
            $corps.= "chipset:".$enregistrement->chipset."<br>frequence memoire max:".$enregistrement->frequence_memoire_max."<br>wifi:".$enregistrement->wifi."<br>";
            $corps.= "nb slot ram:".$enregistrement->nb_slot_ram."<br>led:".$enregistrement->led."<br>format:".$enregistrement->format."<br>prix:".$enregistrement->prix."<br>";
        }
        $query = null;
        $connection = null;
        $zonePrincipale=$corps;
        $zoneAjouter="";
        $nomClasse = "Carte_mere";
        break;

    case 'update':
        $cible="update";
        include("updateCarteMere.php");
        $zoneAjouter="";
        $nomClasse = "Carte_mere";
        break;

    case 'insert':
        $cible="insert";
        include("insertCarteMere.php");
        $zoneAjouter="";
        $nomClasse = "Carte_mere";
        break;

    case 'delete':
        $cible="delete";
        $corps=supprimer_base("CARTE_MERE","Carte_mere","cette carte mère");
        $zonePrincipale = $corps;
        $zoneAjouter="";
        $nomClasse = "Carte_mere";
        break;

    case 'sauvegarde':
        $cible='sauvegarde';
        $connection =connecter();
        $type = key_exists('type',$_POST)? $_POST['type']: null;
        $id = key_exists('id',$_POST)? $_POST['id']: null;
        $sql = key_exists('sql',$_POST)? $_POST['sql']: null;
        $nom = key_exists('nom',$_POST)? $_POST['nom']: null;
        $marque = key_exists('marque',$_POST)? $_POST['marque']: null;
        $chipset = key_exists('chipset',$_POST)? $_POST['chipset']: null;
        $frequence_memoire_max = key_exists('frequence_memoire_max',$_POST)? $_POST['frequence_memoire_max']: null;
        $wifi = key_exists('wifi',$_POST)? $_POST['wifi']: null;
        $nb_slot_ram = key_exists('nb_slot_ram',$_POST)? $_POST['nb_slot_ram']: null;
        $led = key_exists('led',$_POST)? $_POST['led']: null;
        $format = key_exists('format',$_POST)? $_POST['format']: null;
        $prix = key_exists('prix',$_POST)? $_POST['prix']: null;
        if ($type =='confirmupdate'){
            $corps="<h1>Mise à jour de la carte mère ".$id."</h1>" ;
            $data = array(
                ":id" => $id , ":nom" => $nom,
                ":marque" => $marque,":chipset" => $chipset,
                ":frequence_memoire_max"=>$frequence_memoire_max,":wifi"=>$wifi,
                ":nb_slot_ram"=>$nb_slot_ram,":led"=>$led,
                ":format"=>$format,":prix"=>$prix
            );
            $req=$connection->prepare($sql);
            $req->execute($data);
        }
        else{
            $corps="<h1>Suppression de la carte mère ".$id."</h1>" ;
            $req=$connection->prepare($sql);
            $req->bindParam(':id', $id);
            $req->execute();
        }
        $zonePrincipale=$corps ;
        $connection = null;
        $zoneAjouter="";
        $nomClasse = "Carte_mere";
        break;

    case "trieMarque":
        $cible='liste';
		$requete="SELECT * FROM CARTE_MERE ORDER BY marque ASC";
        $nomPackage = "carte_mere";
        $nomClasse = "Carte_mere";
        $phraseListe = "Liste des Cartes Mères";
        $phraseAjout = "une carte mère";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixASC":
        $cible='liste';
		$requete="SELECT * FROM CARTE_MERE ORDER BY prix ASC";
        $nomPackage = "carte_mere";
        $nomClasse = "Carte_mere";
        $phraseListe = "Liste des Cartes Mères";
        $phraseAjout = "une carte mère";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixDESC":
        $cible='liste';
		$requete="SELECT * FROM CARTE_MERE ORDER BY prix DESC";
        $nomPackage = "carte_mere";
        $nomClasse = "Carte_mere";
        $phraseListe = "Liste des Cartes Mères";
        $phraseAjout = "une carte mère";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;





    default:
    $zonePrincipale="" ;
    $zoneAjouter="";
    $nomClasse = "Carte_mere";
    break;
}
include($root."/squelettes/squelette.php");

?>
