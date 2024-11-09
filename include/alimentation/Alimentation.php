<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
//cette class créer l'objet Alimentation
class Alimentation{
    private $id;
    private $nom;
    private $marque;
    private $puissance;
    private $norme_80_plus;
    private $modularites;
    private $format;
    private $prix;

    //Constructeur
    public function __construct($id,$nom,$marque,$puissance,$norme_80_plus,$modularites,$format,$prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->marque = $marque;
        $this->puissance = $puissance;
        $this->norme_80_plus = $norme_80_plus;
        $this->modularites = $modularites;
        $this->format = $format;
        $this->prix = $prix;
    }

    //
    public function __toString(){
        $info = "id: ".$this->id."<br>nom: ".$this->nom."<br> marque: ".$this->marque."<br> puissance: ".$this->puissance."<br>";
        $info .= "norme_80_plus: ".$this->norme_80_plus."<br> modularites: ".$this->modularites;
        $info .= "<br>format: ".$this->format."<br> prix: ".$this->prix."<br>";
        return $info;
    }
}

$id=null;$nom = null;$marque = null;$puissance = null;$norme_80_plus =  null;$modularites = null;$format=null;$prix = null;
$erreur=array("nom"=>null,"marque"=>null,"puissance"=>null,"norme_80_plus"=>null,"modularites"=>null,"format"=>null,"prix"=>null);
$tab_alimentation=array();

//fonction pour gerer les erreurs elle est créer la pour eviter la répition dans insert et update
function validerFormulaire($nom,$marque,$puissance,$norme_80_plus,$modularites,$format,$prix){
    $erreur = array();
    if ($nom=="")     $erreur["nom"] ="il manque un nom";
    if ($marque=="") $erreur["marque"] ="il manque une marque";
    if ($puissance=="")  $erreur["puissance"] ="il manque une puissance";
    else if (is_numeric($puissance)==false) $erreur["puissance"] ="la puissance doit un etre un nombre";

    if ($norme_80_plus=="") $erreur["norme_80_plus"] ="il manque une norme 80 plus";
    else if (is_numeric($norme_80_plus)==true) $erreur["norme_80_plus"] ="la norme 80 plus ne doit pas etre un nombre";
    else if (strlen($norme_80_plus)>20) $erreur["norme_80_plus"] ="la norme 80 plus doit contenir moins de caractere";

    if ($modularites=="")     $erreur["modularites"] ="il manque la mudularités";
    else if (is_numeric($modularites)==true) $erreur["modularites"] ="la mudularités ne doit pas etre un nombre";
    else if (strlen($modularites)>30) $erreur["modularites"] ="la mudularités doit contenir moins de caractere";

    if ($format=="") $erreur["format"] ="il manque le format";
    else if (is_numeric($format)==true) $erreur["format"] ="le format ne doit pas etre un nombre";
    else if (strlen($format)>20) $erreur["format"] ="le format doit contenir moins de caractere";

    if ($prix=="")     $erreur["prix"] ="il manque un prix";
    else if (is_numeric($prix)==false) $erreur["prix"] ="le prix doit un etre un nombre";

    return $erreur;
}


switch ($action){

    case 'liste':
        $cible="liste";
		$requete="SELECT * FROM ALIMENTATION";
        $nomPackage = "alimentation";
        $nomClasse = "Alimentation";
        $phraseListe = "Liste des Alimentation";
        $phraseAjout = "une alimentation";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout); //c'est fonction est dans le fichier connection.php
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM ALIMENTATION WHERE nom LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM ALIMENTATION";
        }
        $nomPackage = "alimentation";
        $nomClasse = "Alimentation";
        $phraseListe = "Liste des Alimentation";
        $phraseAjout = "une alimentation";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout); //c'est fonction est dans le fichier connection.php
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
        break;


    case 'select':
        $id=$_GET["id"];
        $corps="<h1>Sélection de l'Alimentation</h1>" ;
        $connection =connecter();
        $requete="SELECT * FROM ALIMENTATION where id=$id";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() ){
            $corps .= "id:".$enregistrement->id."<br>nom: ".$enregistrement->nom."<br>marque: ".$enregistrement->marque."<br>";
            $corps.= "puissance: ".$enregistrement->puissance."<br>norme 80 plus: ".$enregistrement->norme_80_plus."<br>modularités: ".$enregistrement->modularites."<br>";
            $corps.= "format: ".$enregistrement->format."<br>prix: ".$enregistrement->prix."<br>";
        }
        $query = null;
        $connection = null;
        $zonePrincipale=$corps;
        $zoneAjouter="";
        $nomClasse = "Alimentation";
        break;

    case 'update':
        $cible="update";
        include("updateAlimentation.php");
        $zoneAjouter="";
        $nomClasse = "Alimentation";
        break;

    case 'insert':
        $cible="insert";
        include("insertAlimentation.php");
        $zoneAjouter="";
        $nomClasse = "Alimentation";
        break;

    case 'delete':
        $cible="delete";
        $corps=supprimer_base("ALIMENTATION","Alimentation","cette alimentation");
        $zonePrincipale = $corps;
        $zoneAjouter="";
        $nomClasse = "Alimentation";
        break;

    case 'sauvegarde':
		$cible='sauvegarde';
		$connection =connecter();
		$type = key_exists('type',$_POST)? $_POST['type']: null;
		$id = key_exists('id',$_POST)? $_POST['id']: null;
		$sql = key_exists('sql',$_POST)? $_POST['sql']: null;
        $nom = key_exists('nom',$_POST)? $_POST['nom']: null;
        $marque = key_exists('marque',$_POST)? $_POST['marque']: null;
        $puissance = key_exists('puissance',$_POST)? $_POST['puissance']: null;
        $norme_80_plus = key_exists('norme_80_plus',$_POST)? $_POST['norme_80_plus']: null;
        $modularites = key_exists('modularites',$_POST)? $_POST['modularites']: null;
        $format = key_exists('format',$_POST)? $_POST['format']: null;
        $prix = key_exists('prix',$_POST)? $_POST['prix']: null;
		if ($type =='confirmupdate'){
			$corps="<h1>Mise à jour de l'alimentation ".$id."</h1>" ;
            $data = array(
                ':id' => $id,
                ':nom' => $nom,
                ':marque' => $marque,
                ':puissance' => $puissance,
                ':norme_80_plus' => $norme_80_plus,
                ':modularites' => $modularites,
                ':format' => $format,
                ':prix' => $prix
            );
            $req=$connection->prepare($sql);
            $req->execute($data);

		}
		else{
			$corps="<h1>Suppression de l'alimentation ".$id."</h1>" ;
            $req = $connection->prepare($sql);
            $req->bindParam(':id', $id);
            $req->execute();
		}
		$zonePrincipale=$corps ;
		$connection = null;
        $nomClasse = "Alimentation";
        $zoneAjouter="";
		break;

    case "trieMarque":
		$requete="SELECT * FROM ALIMENTATION ORDER BY marque ASC";
        $nomPackage = "alimentation";
        $nomClasse = "Alimentation";
        $phraseListe = "Liste des Alimentation";
        $phraseAjout = "une alimentation";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixASC":
        $requete="SELECT * FROM ALIMENTATION ORDER BY prix ASC";
        $nomPackage = "alimentation";
        $nomClasse = "Alimentation";
        $phraseListe = "Liste des Alimentation";
        $phraseAjout = "une alimentation";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixDESC":
        $requete="SELECT * FROM ALIMENTATION ORDER BY prix DESC";
        $nomPackage = "alimentation";
        $nomClasse = "Alimentation";
        $phraseListe = "Liste des Alimentation";
        $phraseAjout = "une alimentation";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    default:
    $zonePrincipale="" ;
    $zoneAjouter="";
    $nomClasse = "Alimentation";
    break;
}
include($root."/squelettes/squelette.php");
?>
