<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
class Boitier{
    private $id;
    private $nom;
    private $marque;
    private $type_tour; //petite moyenne ou grande tour
    private $format; //micro atk, mini atx ,atx
    private $fenetre; //oui ou non
    private $couleur;
    private $led; //oui ou non
    private $prix;

    //Constructeur
    public function __construct($id,$nom,$marque,$type_tour,$format,$fenetre,$couleur,$led,$prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->marque = $marque;
        $this->type_tour = $type_tour;
        $this->format = $format;
        $this->fenetre = $fenetre;
        $this->couleur = $couleur;
        $this->led = $led;
        $this->prix = $prix;
    }

    //
    public function __toString(){
        $info = "id: ".$this->id."<br>nom: ".$this->nom."<br> marque: ".$this->marque."<br> type_tour: ".$this->type_tour."<br>";
        $info .= "frequence: ".$this->format."<br> fenetre: ".$this->fenetre;
        $info .= "<br>couleur: ".$this->couleur."<br>led: ".$this->led."<br>prix: ".$this->prix."<br>";
        return $info;
    }
}

$id=null;$nom = null;$marque = null;$type_tour = null;$format =  null;$fenetre = null;$couleur=null;$led=null;$prix = null;
$erreur=array("nom"=>null,"marque"=>null,"type_tour"=>null,"format"=>null,"fenetre"=>null,"couleur"=>null,"led"=>null,"prix"=>null);
$tab_boitier=array();

//fonction pour gerer les erreurs elle est créer la pour eviter la répition dans insert et update
function validerFormulaire($nom,$marque,$type_tour,$format,$fenetre,$couleur,$led,$prix){
    $erreur = array();
    if ($nom=="")     $erreur["nom"] ="il manque un nom";
    if ($marque=="") $erreur["marque"] ="il manque une marque";

    if ($type_tour=="") $erreur["type_tour"] ="il manque le type de la tour";
    else if (is_numeric($type_tour)==true) $erreur["type_tour"] ="le type de la tour ne doit pas etre un nombre";
    else if (strlen($type_tour)>20) $erreur["type_tour"] ="le type de la tour doit contenir moins de caractere";

    if ($format=="") $erreur["format"] ="il manque le format";
    else if (is_numeric($format)==true) $erreur["format"] ="le format ne doit pas etre un nombre";
    else if (strlen($format)>20) $erreur["format"] ="le format doit contenir moins de caractere";

    if ($fenetre=="")     $erreur["fenetre"] ="il manque la fenetre (oui/non)";
    else if (is_numeric($fenetre)==true) $erreur["fenetre"] ="la fenetre ne doit pas etre un nombre (oui/non)";
    else if (strlen($fenetre)>10) $erreur["fenetre"] ="la fenetre doit contenir moins de caractere (oui/non)";

    if ($couleur=="") $erreur["couleur"] ="il manque la couleur";
    else if (is_numeric($couleur)==true) $erreur["couleur"] ="la couleur ne doit pas etre un nombre";
    else if (strlen($couleur)>20) $erreur["couleur"] ="la couleur doit contenir moins de caractere";

    if ($led=="") $erreur["led"] ="il manque la led (oui/non)";
    else if (is_numeric($led)==true) $erreur["led"] ="la led ne doit pas etre un nombre (oui/non)";
    else if (strlen($led)>20) $erreur["led"] ="la led doit contenir moins de caractere (oui/non)";

    if ($prix=="")     $erreur["prix"] ="il manque un prix";
    else if (is_numeric($prix)==false) $erreur["prix"] ="le prix doit un etre un nombre";

    return $erreur;
}


switch ($action){

    case 'liste':
        $cible="liste";
        $requete="SELECT * FROM BOITIER";
        $nomPackage = "boitier";
        $nomClasse = "Boitier";
        $phraseListe = "Liste des Boitier";
        $phraseAjout = "un Boitier";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM BOITIER WHERE nom LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM BOITIER";
        }
        $nomPackage = "boitier";
        $nomClasse = "Boitier";
        $phraseListe = "Liste des Boitier";
        $phraseAjout = "un Boitier";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
        break;

    case 'select':
        $cible = "select";
        $id=$_GET["id"];
        $corps="<h1>Sélection du boitier</h1>" ;
        $connection =connecter();
        $requete="SELECT * FROM BOITIER where id=$id";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() ){
            $corps .= "id:".$enregistrement->id."<br>nom:".$enregistrement->nom."<br>marque:".$enregistrement->marque."<br>";
            $corps.= "type tour:".$enregistrement->type_tour."<br>format:".$enregistrement->format."<br>fenetre:".$enregistrement->fenetre."<br>";
            $corps.= "couleur:".$enregistrement->couleur."<br>led:".$enregistrement->led."<br>prix:".$enregistrement->prix."<br>";
        }
        $query = null;
        $connection = null;
        $zonePrincipale=$corps;
        $zoneAjouter="";
        $nomClasse = "Boitier";
        break;

        case 'update':
            $cible="update";
            include("updateBoitier.php");
            $zoneAjouter="";
            $nomClasse = "Boitier";
            break;

        case 'insert':
            $cible="insert";
            include("insertBoitier.php");
            $zoneAjouter="";
            $nomClasse = "Boitier";
            break;

        case 'delete':
            $cible="delete";
            $corps=supprimer_base("BOITIER","Boitier","ce boitier");
            $zonePrincipale = $corps;
            $zoneAjouter="";
            $nomClasse = "Boitier";
            break;

        case 'sauvegarde':
            $cible='sauvegarde';
            $connection =connecter();
            $type = key_exists('type',$_POST)? $_POST['type']: null;
            $id = key_exists('id',$_POST)? $_POST['id']: null;
            $sql = key_exists('sql',$_POST)? $_POST['sql']: null;
            $nom = key_exists('nom',$_POST)? $_POST['nom']: null;
            $marque = key_exists('marque',$_POST)? $_POST['marque']: null;
            $type_tour = key_exists('type_tour',$_POST)? $_POST['type_tour']: null;
            $format = key_exists('format',$_POST)? $_POST['format']: null;
            $fenetre = key_exists('fenetre',$_POST)? $_POST['fenetre']: null;
            $couleur = key_exists('couleur',$_POST)? $_POST['couleur']: null;
            $led = key_exists('led',$_POST)? $_POST['led']: null;
            $prix = key_exists('prix',$_POST)? $_POST['prix']: null;
            if ($type =='confirmupdate'){
                $corps="<h1>Mise à jour du Boitier ".$id."</h1>" ;
                $data = array(
                    ":id" => $id , ":nom" => $nom,
                    ":marque" => $marque,":type_tour" => $type_tour,
                    ":format"=>$format,":fenetre"=>$fenetre,
                    ":couleur"=>$couleur,":led"=>$led,
                    ":prix"=>$prix
                );
                $req=$connection->prepare($sql);
                $req->execute($data);
            }
            else{
                $corps="<h1>Suppression du Boitier ".$id."</h1>" ;
                $req = $connection->prepare($sql);
                $req->bindParam(':id', $id);
                $req->execute();
            }
            $zonePrincipale=$corps ;
            $connection = null;
            $zoneAjouter="";
            $nomClasse = "Boitier";
            break;

        case 'trieMarque':
            $cible="liste";
            $requete="SELECT * FROM BOITIER ORDER BY marque ASC";
            $nomPackage = "boitier";
            $nomClasse = "Boitier";
            $phraseListe = "Liste des Boitier";
            $phraseAjout = "un Boitier";
            $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
            $zoneAjouter = $listeduComposant[1];
            $zonePrincipale = $listeduComposant[0];
            break;


        case 'triePrixASC':
            $cible="liste";
            $requete="SELECT * FROM BOITIER ORDER BY prix ASC";
            $nomPackage = "boitier";
            $nomClasse = "Boitier";
            $phraseListe = "Liste des Boitier";
            $phraseAjout = "un Boitier";
            $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
            $zoneAjouter = $listeduComposant[1];
            $zonePrincipale = $listeduComposant[0];
            break;

        case 'triePrixDESC':
            $cible="liste";
            $requete="SELECT * FROM BOITIER ORDER BY prix DESC";
            $nomPackage = "boitier";
            $nomClasse = "Boitier";
            $phraseListe = "Liste des Boitier";
            $phraseAjout = "un Boitier";
            $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
            $zoneAjouter = $listeduComposant[1];
            $zonePrincipale = $listeduComposant[0];
            break;


    default:
    $zonePrincipale="" ;
    $zoneAjouter="";
    $nomClasse = "Boitier";
    break;
}
include($root."/squelettes/squelette.php");
?>
