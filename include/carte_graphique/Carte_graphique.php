<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
$action = key_exists('action', $_GET)? trim($_GET['action']): null;
$sauvegarde = key_exists('sauvegarde', $_GET)? trim($_GET['sauvegarde']): null;
class Carte_graphique{
    private $id;
    private $nom;
    private $marque;
    private $chipset_Graphique;
    private $memoire_video;
    private $consommation;
    private $prix;

    //Constructeur
    public function __construct($id,$nom,$marque,$chipset_Graphique,$memoire_video,$consommation,$prix){
        $this->id = $id;
        $this->nom = $nom;
        $this->marque = $marque;
        $this->chipset_Graphique = $chipset_Graphique;
        $this->memoire_video = $memoire_video;
        $this->consommation = $consommation;
        $this->prix = $prix;
    }

    //
    public function __toString(){
        $info = "id: ".$this->id."<br>nom: ".$this->nom."<br> marque: ".$this->marque."<br> chipset graphique: ".$this->chipset_Graphique."<br>";
        $info .= "memoire vidéo: ".$this->memoire_video."<br> consommation: ".$this->consommation."<br>prix: ".$this->prix."<br>";
        return $info;
    }
}


$id=null;$nom = null;$marque = null;$chipset_Graphique = null;$memoire_video =  null;$consommation = null;$prix = null;
$erreur=array("nom"=>null,"marque"=>null,"chipset_Graphique"=>null,"memoire_video"=>null,"consommation"=>null,"prix"=>null);
$tab_carte_graphique=array();

//fonction pour gerer les erreurs elle est créer la pour eviter la répition dans insert et update
function validerFormulaire($nom,$marque,$chipset_Graphique,$memoire_video,$consommation,$prix) {
    $erreur = array();

    if ($nom=="")     $erreur["nom"] ="il manque un nom";
    if ($marque=="") $erreur["marque"] ="il manque une marque";

    if ($chipset_Graphique=="") $erreur["chipset_Graphique"] ="il manque le chipset Graphique";
    else if (is_numeric($chipset_Graphique)==true) $erreur["chipset_Graphique"] ="le chipset Graphique ne doit pas etre un nombre";
    else if (strlen($chipset_Graphique)>30) $erreur["chipset_Graphique"] ="le chipset Graphique doit contenir moins de caractere";

    if ($memoire_video=="") $erreur["memoire_video"] ="il manque la memoire video";
    else if (is_numeric($memoire_video)==false) $erreur["memoire_video"] ="la memoire video doit un etre un nombre";

    if ($consommation=="") $erreur["consommation"] ="il manque la consommation";
    else if (is_numeric($consommation)==false) $erreur["consommation"] ="la consommation doit un etre un nombre";

    if ($prix=="")     $erreur["prix"] ="il manque un prix";
    else if (is_numeric($prix)==false) $erreur["prix"] ="le prix doit un etre un nombre";

    return $erreur;
  }

switch ($action){

    case 'liste':
		$requete="SELECT * FROM CARTE_GRAPHIQUE";
        $nomPackage = "carte_graphique";
        $nomClasse = "Carte_graphique";
        $phraseListe = "Liste des Cartes Graphiques";
        $phraseAjout = "une carte graphique";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case 'recherche':
        $cible="recherche";
        $recherche = isset($_GET['recherche']) ? $_GET['recherche'] : '';
        if (!empty($recherche)) {
            $requete = "SELECT * FROM CARTE_GRAPHIQUE WHERE nom LIKE '$recherche%'";
        } else {
            $requete="SELECT * FROM CARTE_GRAPHIQUE";
        }
        $nomPackage = "carte_graphique";
        $nomClasse = "Carte_graphique";
        $phraseListe = "Liste des Cartes Graphiques";
        $phraseAjout = "une carte graphique";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
        break;

    case 'select':
        $id=$_GET["id"];
        $corps="<h1>Sélection de la carte graphique</h1>" ;
        $connection =connecter();
        $requete="SELECT * FROM CARTE_GRAPHIQUE where id=$id";
        $query  = $connection->query($requete);
        $query->setFetchMode(PDO::FETCH_OBJ);
        while( $enregistrement = $query->fetch() ){
            $corps .= "id:".$enregistrement->id."<br>nom:".$enregistrement->nom."<br>marque:".$enregistrement->marque."<br>";
            $corps.= "chipset Graphique:".$enregistrement->chipset_Graphique."<br>memoire video:".$enregistrement->memoire_video."<br>consommation:".$enregistrement->consommation."<br>";
            $corps.= "prix:".$enregistrement->prix."<br>";
        }
        $query = null;
        $connection = null;
        $zonePrincipale=$corps;
        $zoneAjouter="";
        $nomClasse = "Carte_graphique";
        break;

        case 'update':
            $cible="update";
            include("updateCarteGraphique.php");
            $zoneAjouter="";
            $nomClasse = "Carte_graphique";
            break;

        case 'insert':
            $cible="insert";
            include("insertCarteGraphique.php");
            $zoneAjouter="";
            $nomClasse = "Carte_graphique";
            break;

        case 'delete':
            $cible="delete";
            $corps=supprimer_base("CARTE_GRAPHIQUE","Carte_graphique","cette carte graphique");
            $zonePrincipale = $corps;
            $zoneAjouter="";
            $nomClasse = "Carte_graphique";
            break;

        case 'sauvegarde':
            $cible='sauvegarde';
            $connection =connecter();
            $type = key_exists('type',$_POST)? $_POST['type']: null;
            $id = key_exists('id',$_POST)? $_POST['id']: null;
            $sql = key_exists('sql',$_POST)? $_POST['sql']: null;;
            $nom = key_exists('nom',$_POST)? $_POST['nom']: null;
            $marque = key_exists('marque',$_POST)? $_POST['marque']: null;
            $chipset_Graphique = key_exists('chipset_Graphique',$_POST)? $_POST['chipset_Graphique']: null;
            $memoire_video = key_exists('memoire_video',$_POST)? $_POST['memoire_video']: null;
            $consommation = key_exists('consommation',$_POST)? $_POST['consommation']: null;
            $prix = key_exists('prix',$_POST)? $_POST['prix']: null;
            if ($type =='confirmupdate'){
                $corps="<h1>Mise à jour de la carte graphique ".$id."</h1>";
                $data = array(
                    ":id" => $id , ":nom" => $nom,
                    ":marque" => $marque,":chipset_Graphique" => $chipset_Graphique,
                    ":memoire_video"=>$memoire_video,":consommation"=>$consommation,
                    ":prix"=>$prix
                );
                $req=$connection->prepare($sql);
                $req->execute($data);
            }
            else{
                $corps="<h1>Suppression de la carte graphique ".$id."</h1>";
                $req = $connection->prepare($sql);
                $req->bindParam(':id', $id);
                $req->execute();
            }

            $zonePrincipale=$corps ;
            $connection = null;
            $zoneAjouter="";
            $nomClasse = "Carte_graphique";
            break;

    case "trieMarque":
        $requete="SELECT * FROM CARTE_GRAPHIQUE ORDER BY marque ASC";
        $nomPackage = "carte_graphique";
        $nomClasse = "Carte_graphique";
        $phraseListe = "Liste des Cartes Graphiques";
        $phraseAjout = "une carte graphique";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixASC":
        $requete="SELECT * FROM CARTE_GRAPHIQUE ORDER BY prix ASC";
        $nomPackage = "carte_graphique";
        $nomClasse = "Carte_graphique";
        $phraseListe = "Liste des Cartes Graphiques";
        $phraseAjout = "une carte graphique";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;

    case "triePrixDESC":
        $requete="SELECT * FROM CARTE_GRAPHIQUE ORDER BY marque DESC";
        $nomPackage = "carte_graphique";
        $nomClasse = "Carte_graphique";
        $phraseListe = "Liste des Cartes Graphiques";
        $phraseAjout = "une carte graphique";
        $listeduComposant = listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout);
        $zoneAjouter = $listeduComposant[1];
        $zonePrincipale = $listeduComposant[0];
		break;



    default:
    $zonePrincipale="" ;
    $zoneAjouter="";
    $nomClasse = "Carte_graphique";
    break;
}
include($root."/squelettes/squelette.php");
?>
