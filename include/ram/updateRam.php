<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Barrette_de_ram.php");

$id=$_GET["id"];
$connection =connecter();
$requete="SELECT * FROM RAM where id like '$id'";
$query  = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $query->fetch() ){
      $id=$enregistrement->id;
      $nom=$enregistrement->nom;
      $marque=$enregistrement->marque;
      $type_memoire=$enregistrement->type_memoire;
      $frequence=$enregistrement->frequence;
      $nb_barettes=$enregistrement->nb_barettes;
      $capacites_totale=$enregistrement->capacites_totale;
      $led=$enregistrement->led;
      $prix=$enregistrement->prix;
      }

if (!isset($_POST["nom"]) && !isset($_POST["marque"]) && !isset($_POST["type_memoire"]) && !isset($_POST["frequence"])){
  if(!isset($_POST["nb_barettes"]) && !isset($_POST["capacites_totale"]) &&  !isset($_POST["led"]) && !isset($_POST["prix"])){
    include("formulaire_ram.html");
  }
}
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $type_memoire = key_exists('type_memoire', $_POST)? trim($_POST['type_memoire']): null;
    $frequence = key_exists('frequence', $_POST)? trim($_POST['frequence']): null;
    $nb_barettes = key_exists('nb_barettes', $_POST)? trim($_POST['nb_barettes']): null;
    $capacites_totale = key_exists('capacites_totale', $_POST)? trim($_POST['capacites_totale']): null;
    $led = key_exists('led', $_POST)? trim($_POST['led']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$type_memoire,$frequence,$nb_barettes,$capacites_totale,$led,$prix);
    if (empty($erreurs)) {
        $sql="UPDATE RAM SET
              nom=:nom,
              marque=:marque,
              type_memoire=:type_memoire,
              frequence=:frequence,
              nb_barettes=:nb_barettes,
              capacites_totale=:capacites_totale,
              led=:led,
              prix=:prix
              WHERE id=:id";
        $tab='<form action="Barrette_de_ram.php?action=sauvegarde" method="post">
        <input type="hidden" name="type" value="'.'confirmupdate'.'"/>
        <input type="hidden" name="id" value="'.$id.'"/>
        <input type="hidden" name="sql" value="'.$sql.'"/>
        <input type="hidden" name="nom" value="'.$nom.'"/>
        <input type="hidden" name="marque" value="'.$marque.'"/>
        <input type="hidden" name="type_memoire" value="'.$type_memoire.'"/>
        <input type="hidden" name="frequence" value="'.$frequence.'"/>
        <input type="hidden" name="nb_barettes" value="'.$nb_barettes.'"/>
        <input type="hidden" name="capacites_totale" value="'.$capacites_totale.'"/>
        <input type="hidden" name="led" value="'.$led.'"/>
        <input type="hidden" name="prix" value="'.$prix.'"/>
        <p>Etes vous sûr de vouloir mettre à jour ces barettes de ram ?</p>
        <p>
          <input type="submit" value="Enregistrer" class="btn btn-danger">
          <a href="Barrette_de_ram.php?action=liste" class="btn btn-secondary">Annuler</a>
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
      include("formulaire_ram.html");
    }
}

$connection = null;


 ?>
