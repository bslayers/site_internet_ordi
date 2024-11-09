<?php

$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Stockage.php");

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
    if (empty($erreurs)){
        $connection =connecter();
        $corps = "Connection etablie <br>";
		$corps .= "Il faut maintenant insérer les données du formulaire dans la base <br>";
        $rq = "INSERT INTO STOCKAGE (id,nom,marque,type,capacites,vitesse_lecture,vitesse_ecriture,prix)
            VALUES (:id,:nom,:marque,:type,:capacites,:vitesse_lecture,:vitesse_ecriture,:prix)";
		$stmt = $connection->prepare($rq);
		$data = array(
            ":id" => $id , ":nom" => $nom,
            ":marque" => $marque,":type" => $type,
            ":capacites"=>$capacites,":vitesse_lecture"=>$vitesse_lecture,
            ":vitesse_ecriture"=>$vitesse_ecriture,":prix"=>$prix
        );
		$stmt->execute($data);
		$id = $connection->lastInsertId();
		$corps .= "et récupérer l'identifiant ". $id. "<br>";
        $stock = new Stockage($id,$nom,$marque,$type,$capacites,$vitesse_lecture,$vitesse_ecriture,$prix);
        $corps = "Insertion de : <br>". $stock;
        $zonePrincipale=$corps ;
        $zoneAjouter="";
        $connection = null;
    }
    else {
        // Afficher les messages d'erreur
        foreach ($erreurs as $key => $message) {
            $erreur[$key] = $message;
        }
        include("formulaire_stockage.html");
    }
}
?>
