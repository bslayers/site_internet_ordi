<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Carte_graphique.php");

$id=$_GET["id"];
$connection =connecter();
$requete="SELECT * FROM CARTE_GRAPHIQUE where id like '$id'";
$query  = $connection->query($requete);
$query->setFetchMode(PDO::FETCH_OBJ);
while( $enregistrement = $query->fetch() ){
    $id=$enregistrement->id;
    $nom=$enregistrement->nom;
    $marque=$enregistrement->marque;
    $chipset_Graphique=$enregistrement->chipset_Graphique;
    $memoire_video=$enregistrement->memoire_video;
    $consommation=$enregistrement->consommation;
    $prix=$enregistrement->prix;
    }

    if (!isset($_POST["nom"]) || !isset($_POST["marque"]) || !isset($_POST["chipset_Graphique"])  ) {
      if (!isset($_POST["memoire_video"]) || !isset($_POST["consommation"]) || !isset($_POST["prix"])){
          include("formulaire_carte_graphique.html");
      }
  }
else{
  $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $chipset_Graphique = key_exists('chipset_Graphique', $_POST)? trim($_POST['chipset_Graphique']): null;
    $memoire_video = key_exists('memoire_video', $_POST)? trim($_POST['memoire_video']): null;
    $consommation = key_exists('consommation', $_POST)? trim($_POST['consommation']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$chipset_Graphique,$memoire_video,$consommation,$prix);
    if (empty($erreurs)){
        $sql="UPDATE CARTE_GRAPHIQUE SET
              nom=:nom,
              marque=:marque,
              chipset_Graphique=:chipset_Graphique,
              memoire_video=:memoire_video,
              consommation=:consommation,
              prix=:prix
              WHERE id=:id";

        $tab='<form action="Carte_graphique.php?action=sauvegarde" method="post">
        <input type="hidden" name="type" value="'.'confirmupdate'.'"/>
        <input type="hidden" name="id" value="'.$id.'"/>
        <input type="hidden" name="sql" value="'.$sql.'"/>
        <input type="hidden" name="nom" value="'.$nom.'"/>
        <input type="hidden" name="marque" value="'.$marque.'"/>
        <input type="hidden" name="chipset_Graphique" value="'.$chipset_Graphique.'"/>
        <input type="hidden" name="memoire_video" value="'.$memoire_video.'"/>
        <input type="hidden" name="consommation" value="'.$consommation.'"/>
        <input type="hidden" name="prix" value="'.$prix.'"/>
        <p>Etes vous sûr de vouloir mettre à jour la carte graphique ?</p>
        <p>
          <input type="submit" value="Enregistrer" class="btn btn-danger">
          <a href="Carte_graphique.php?action=liste" class="btn btn-secondary">Annuler</a>
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
      include("formulaire_carte_graphique.html");
    }
}

$connection = null;
 ?>
