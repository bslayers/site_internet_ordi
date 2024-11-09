<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Stockage.php");

$id=$_GET["id"];
$connection =connecter();
$requete="SELECT * FROM STOCKAGE where id like '$id'";
$query  = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $query->fetch() ){
      $id=$enregistrement->id;
      $nom=$enregistrement->nom;
      $marque=$enregistrement->marque;
      $type=$enregistrement->type;
      $capacites=$enregistrement->capacites;
      $vitesse_lecture=$enregistrement->vitesse_lecture;
      $vitesse_ecriture=$enregistrement->vitesse_ecriture;
      $prix=$enregistrement->prix;
      }

if (!isset($_POST["nom"]) && !isset($_POST["marque"]) && !isset($_POST["type"]) && !isset($_POST["capacites"]) && !isset($_POST["vitesse_lecture"])){
  if(!isset($_POST["vitesse_ecriture"]) && !isset($_POST["prix"])){
    include("formulaire_stockage.html");
  }
}
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $type = key_exists('type', $_POST)? trim($_POST['type']): null;
    $capacites = key_exists('capacites', $_POST)? trim($_POST['capacites']): null;
    $vitesse_lecture = key_exists('vitesse_lecture', $_POST)? trim($_POST['vitesse_lecture']): null;
    $vitesse_ecriture = key_exists('vitesse_ecriture', $_POST)? trim($_POST['vitesse_ecriture']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$type,$capacites,$vitesse_lecture,$vitesse_ecriture,$prix);
    if (empty($erreurs)) {
        $sql="UPDATE STOCKAGE SET
              nom=:nom,
              marque=:marque,
              type=:type,
              capacites=:capacites,
              vitesse_lecture=:vitesse_lecture,
              vitesse_ecriture=:vitesse_ecriture,
              prix=:prix
              WHERE id=:id";
        $tab='<form action="Stockage.php?action=sauvegarde" method="post">
        <input type="hidden" name="types" value="'.'confirmupdate'.'"/>
        <input type="hidden" name="id" value="'.$id.'"/>
        <input type="hidden" name="sql" value="'.$sql.'"/>
        <input type="hidden" name="nom" value="'.$nom.'"/>
        <input type="hidden" name="marque" value="'.$marque.'"/>
        <input type="hidden" name="type" value="'.$type.'"/>
        <input type="hidden" name="capacites" value="'.$capacites.'"/>
        <input type="hidden" name="vitesse_lecture" value="'.$vitesse_lecture.'"/>
        <input type="hidden" name="vitesse_ecriture" value="'.$vitesse_ecriture.'"/>
        <input type="hidden" name="prix" value="'.$prix.'"/>
        <p>Etes vous sûr de vouloir mettre à jour ce stockage ?</p>
        <p>
          <input type="submit" value="Enregistrer" class="btn btn-danger">
          <a href="Stockage.php?action=liste" class="btn btn-secondary">Annuler</a>
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
      include("formulaire_stockage.html");
    }
}

$connection = null;


 ?>
