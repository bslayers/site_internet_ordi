<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Carte_mere.php");

$id=$_GET["id"];
$connection =connecter();
$requete="SELECT * FROM CARTE_MERE where id like '$id'";
$query  = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $query->fetch() ){
      $id=$enregistrement->id;
      $nom=$enregistrement->nom;
      $marque=$enregistrement->marque;
      $chipset=$enregistrement->chipset;
      $frequence_memoire_max=$enregistrement->frequence_memoire_max;
      $wifi=$enregistrement->wifi;
      $nb_slot_ram=$enregistrement->nb_slot_ram;
      $led=$enregistrement->led;
      $format=$enregistrement->format;
      $prix=$enregistrement->prix;
      }

if (!isset($_POST["nom"]) && !isset($_POST["marque"]) && !isset($_POST["chipset"]) && !isset($_POST["frequence_memoire_max"])){
  if(!isset($_POST["wifi"]) && !isset($_POST["nb_slot_ram"]) &&  !isset($_POST["led"]) && !isset($_POST["format"]) && !isset($_POST["prix"])){
    include("formulaire_carte_mere.html");
  }
}
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $chipset = key_exists('chipset', $_POST)? trim($_POST['chipset']): null;
    $frequence_memoire_max = key_exists('frequence_memoire_max', $_POST)? trim($_POST['frequence_memoire_max']): null;
    $wifi = key_exists('wifi', $_POST)? trim($_POST['wifi']): null;
    $nb_slot_ram = key_exists('nb_slot_ram', $_POST)? trim($_POST['nb_slot_ram']): null;
    $led = key_exists('led', $_POST)? trim($_POST['led']): null;
    $format = key_exists('format', $_POST)? trim($_POST['format']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$chipset,$frequence_memoire_max,$wifi,$nb_slot_ram,$led,$format,$prix);
    if (empty($erreurs)) {
        $sql="UPDATE CARTE_MERE SET
              nom=:nom,
              marque=:marque,
              chipset=:chipset,
              frequence_memoire_max=:frequence_memoire_max,
              wifi=:wifi,
              nb_slot_ram=:nb_slot_ram,
              led=:led,
              format=:format,
              prix=:prix
              WHERE id=:id";
        $tab='<form action="Carte_mere.php?action=sauvegarde" method="post">
        <input type="hidden" name="type" value="'.'confirmupdate'.'"/>
        <input type="hidden" name="id" value="'.$id.'"/>
        <input type="hidden" name="sql" value="'.$sql.'"/>
        <input type="hidden" name="nom" value="'.$nom.'"/>
        <input type="hidden" name="marque" value="'.$marque.'"/>
        <input type="hidden" name="chipset" value="'.$chipset.'"/>
        <input type="hidden" name="frequence_memoire_max" value="'.$frequence_memoire_max.'"/>
        <input type="hidden" name="wifi" value="'.$wifi.'"/>
        <input type="hidden" name="nb_slot_ram" value="'.$nb_slot_ram.'"/>
        <input type="hidden" name="led" value="'.$led.'"/>
        <input type="hidden" name="format" value="'.$format.'"/>
        <input type="hidden" name="prix" value="'.$prix.'"/>
        <p>Etes vous sûr de vouloir mettre à jour ces barettes de ram ?</p>
        <p>
          <input type="submit" value="Enregistrer" class="btn btn-danger">
          <a href="Carte_mere.php?action=liste" class="btn btn-secondary">Annuler</a>
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
      include("formulaire_carte_mere.html");
    }
}

$connection = null;


 ?>
