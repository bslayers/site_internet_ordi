<?php

$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Processeur.php");

if (!isset($_POST["nom"])    && !isset($_POST["marque"]) ) /* et autres champs*/
{
    include("formulaire_processeur.html");
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
        $connection =connecter();
        $corps = "Connection etablie <br>";
		$corps .= "Il faut maintenant insérer les données du formulaire dans la base <br>";
        $rq = "INSERT INTO PROCESSEUR (id,nom,marque,generation,coeur,controleur_memoire,prix)
            VALUES (:id,:nom,:marque,:generation,:coeur,:controleur_memoire,:prix)";
		$stmt = $connection->prepare($rq);
		$data = array(
            ":id" => $id , ":nom" => $nom,
            ":marque" => $marque,":generation" => $generation,
            ":coeur"=>$coeur,":controleur_memoire"=>$controleur_memoire,
            ":prix"=>$prix
        );
		$stmt->execute($data);
		$id = $connection->lastInsertId();
		$corps .= "et récupérer l'identifiant ". $id. "<br>";
        $processeur = new PROCESSEUR($id,$nom,$marque,$generation,$coeur,$controleur_memoire,$prix);
        $corps = "Insertion de : <br>". $processeur;
        $zonePrincipale=$corps ;
        $zoneAjouter="";
        $connection = null;
    }
    else {
        // Afficher les messages d'erreur
        foreach ($erreurs as $key => $message) {
            $erreur[$key] = $message;
        }
        include("formulaire_processeur.html");
    }
}
?>
