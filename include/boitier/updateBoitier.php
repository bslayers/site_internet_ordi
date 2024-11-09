<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Boitier.php");

$id=$_GET["id"];
$connection =connecter();
$requete="SELECT * FROM BOITIER where id like '$id'";
$query  = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $query->fetch() ){
      $id=$enregistrement->id;
      $nom=$enregistrement->nom;
      $marque=$enregistrement->marque;
      $type_tour=$enregistrement->type_tour;
      $format=$enregistrement->format;
      $fenetre=$enregistrement->fenetre;
      $couleur=$enregistrement->couleur;
      $led=$enregistrement->led;
      $prix=$enregistrement->prix;
      }

if (!isset($_POST["nom"]) && !isset($_POST["marque"]) && !isset($_POST["type_tour"]) && !isset($_POST["format"])){
  if(!isset($_POST["fenetre"]) && !isset($_POST["couleur"]) && !isset($_POST["led"]) && !isset($_POST["prix"])){
    include("formulaire_boitier.html");
  }
}
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $type_tour = key_exists('type_tour', $_POST)? trim($_POST['type_tour']): null;
    $format = key_exists('format', $_POST)? trim($_POST['format']): null;
    $fenetre = key_exists('fenetre', $_POST)? trim($_POST['fenetre']): null;
    $couleur = key_exists('couleur', $_POST)? trim($_POST['couleur']): null;
    $led = key_exists('led', $_POST)? trim($_POST['led']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$type_tour,$format,$fenetre,$couleur,$led,$prix);
    if (empty($erreurs)) {
        $sql="UPDATE BOITIER SET
              nom=:nom,
              marque=:marque,
              type_tour=:type_tour,
              format=:format,
              fenetre=:fenetre,
              couleur=:couleur,
              led=:led,
              prix=:prix
              WHERE id=:id";
        $tab='<form action="Boitier.php?action=sauvegarde" method="post">
        <input type="hidden" name="type" value="'.'confirmupdate'.'"/>
        <input type="hidden" name="id" value="'.$id.'"/>
        <input type="hidden" name="sql" value="'.$sql.'"/>
        <input type="hidden" name="nom" value="'.$nom.'"/>
        <input type="hidden" name="marque" value="'.$marque.'"/>
        <input type="hidden" name="type_tour" value="'.$type_tour.'"/>
        <input type="hidden" name="format" value="'.$format.'"/>
        <input type="hidden" name="fenetre" value="'.$fenetre.'"/>
        <input type="hidden" name="couleur" value="'.$couleur.'"/>
        <input type="hidden" name="led" value="'.$led.'"/>
        <input type="hidden" name="prix" value="'.$prix.'"/>
        <p>Etes vous sûr de vouloir mettre à jour ce Boitier ?</p>
        <p>
          <input type="submit" value="Enregistrer" class="btn btn-danger">
          <a href="Boitier.php?action=liste" class="btn btn-secondary">Annuler</a>
        </p>
        </form>';
        $corps = $tab;
        $zonePrincipale=$corps ;

    }
    else {
      // Afficher les messages d'erreur
      foreach ($erreurs as $key => $message) {
          $erreur[$key] = $message;
      }
      include("formulaire_boitier.html");
    }
}

$connection = null;


 ?>
