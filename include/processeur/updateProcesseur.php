<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Processeur.php");

$id=$_GET["id"];
$connection =connecter();
$requete="SELECT * FROM PROCESSEUR where id like '$id'";
$query  = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $query->fetch() ){
      $id=$enregistrement->id;
      $nom=$enregistrement->nom;
      $marque=$enregistrement->marque;
      $generation=$enregistrement->generation;
      $coeur=$enregistrement->coeur;
      $controleur_memoire=$enregistrement->controleur_memoire;
      $prix=$enregistrement->prix;
      }

if (!isset($_POST["nom"]) && !isset($_POST["marque"]) && !isset($_POST["generation"]) && !isset($_POST["coeur"])){
  if(!isset($_POST["controleur_memoire"]) && !isset($_POST["prix"])){
    include("formulaire_processeur.html");
  }
}
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $generation = key_exists('generation', $_POST)? trim($_POST['generation']): null;
    $coeur = key_exists('coeur', $_POST)? trim($_POST['coeur']): null;
    $controleur_memoire = key_exists('controleur_memoire', $_POST)? trim($_POST['controleur_memoire']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$generation,$coeur,$controleur_memoire,$prix);
    if (empty($erreurs)) {
        $sql="UPDATE PROCESSEUR SET
              nom=:nom,
              marque=:marque,
              generation=:generation,
              coeur=:coeur,
              controleur_memoire=:controleur_memoire,
              prix=:prix
              WHERE id=:id";
        $tab='<form action="Processeur.php?action=sauvegarde" method="post">
        <input type="hidden" name="type" value="'.'confirmupdate'.'"/>
        <input type="hidden" name="id" value="'.$id.'"/>
        <input type="hidden" name="sql" value="'.$sql.'"/>
        <input type="hidden" name="nom" value="'.$nom.'"/>
        <input type="hidden" name="marque" value="'.$marque.'"/>
        <input type="hidden" name="generation" value="'.$generation.'"/>
        <input type="hidden" name="coeur" value="'.$coeur.'"/>
        <input type="hidden" name="controleur_memoire" value="'.$controleur_memoire.'"/>
        <input type="hidden" name="prix" value="'.$prix.'"/>
        <p>Etes vous sûr de vouloir mettre à jour ce Processeur ?</p>
        <p>
          <input type="submit" value="Enregistrer" class="btn btn-danger">
          <a href="Processeur.php?action=liste" class="btn btn-secondary">Annuler</a>
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
      include("formulaire_processeur.html");
    }
}

$connection = null;


 ?>
