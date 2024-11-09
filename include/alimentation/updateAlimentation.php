<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Alimentation.php");

$id=$_GET["id"];
$connection =connecter();
$requete="SELECT * FROM ALIMENTATION where id like '$id'";
$query  = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $query->fetch() ){
      $id=$enregistrement->id;
      $nom=$enregistrement->nom;
      $marque=$enregistrement->marque;
      $puissance=$enregistrement->puissance;
      $norme_80_plus=$enregistrement->norme_80_plus;
      $modularites=$enregistrement->modularites;
      $format=$enregistrement->format;
      $prix=$enregistrement->prix;
      }

if (!isset($_POST["nom"]) && !isset($_POST["marque"]) && !isset($_POST["puissance"]) && !isset($_POST["norme_80_plus"])){
  if(!isset($_POST["modularites"]) && !isset($_POST["format"]) && !isset($_POST["prix"])){
    include("formulaire_alimentation.html");
  }
}
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $puissance = key_exists('puissance', $_POST)? trim($_POST['puissance']): null;
    $norme_80_plus = key_exists('norme_80_plus', $_POST)? trim($_POST['norme_80_plus']): null;
    $modularites = key_exists('modularites', $_POST)? trim($_POST['modularites']): null;
    $format = key_exists('format', $_POST)? trim($_POST['format']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$puissance,$norme_80_plus,$modularites,$format,$prix);
    if (empty($erreurs)){
        $sql="UPDATE ALIMENTATION SET
              nom=:nom,
              marque=:marque,
              puissance=:puissance,
              norme_80_plus=:norme_80_plus,
              modularites=:modularites,
              format=:format,
              prix=:prix
              WHERE id=:id";
        $tab='<form action="Alimentation.php?action=sauvegarde" method="post">
        <input type="hidden" name="type" value="'.'confirmupdate'.'"/>
        <input type="hidden" name="id" value="'.$id.'"/>
        <input type="hidden" name="sql" value="'.$sql.'"/>
        <input type="hidden" name="nom" value="'.$nom.'"/>
        <input type="hidden" name="marque" value="'.$marque.'"/>
        <input type="hidden" name="puissance" value="'.$puissance.'"/>
        <input type="hidden" name="norme_80_plus" value="'.$norme_80_plus.'"/>
        <input type="hidden" name="modularites" value="'.$modularites.'"/>
        <input type="hidden" name="format" value="'.$format.'"/>
        <input type="hidden" name="prix" value="'.$prix.'"/>
        <p>Etes vous sûr de vouloir mettre à jour cette Alimentation ?</p>
        <p>
          <input type="submit" value="Enregistrer" class="btn btn-danger">
          <a href="Alimentation.php?action=liste" class="btn btn-secondary">Annuler</a>
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
      include("formulaire_alimentation.html");
    }
}

$connection = null;


 ?>
