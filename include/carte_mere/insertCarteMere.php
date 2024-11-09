<?php

$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Carte_mere.php");

if (!isset($_POST["nom"])    && !isset($_POST["marque"]) ) /* et autres champs*/
{
    include("formulaire_carte_mere.html");
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
        $connection =connecter();
        $corps = "Connection etablie <br>";
		$corps .= "Il faut maintenant insérer les données du formulaire dans la base <br>";
        $rq = "INSERT INTO CARTE_MERE (id,nom,marque,chipset,frequence_memoire_max,wifi,nb_slot_ram,led,format,prix)
            VALUES (:id,:nom,:marque,:chipset,:frequence_memoire_max,:wifi,:nb_slot_ram,:led,:format,:prix)";
		$stmt = $connection->prepare($rq);
		$data = array(
            ":id" => $id , ":nom" => $nom,
            ":marque" => $marque,":chipset" => $chipset,
            ":frequence_memoire_max"=>$frequence_memoire_max,":wifi"=>$wifi,
            ":nb_slot_ram"=>$nb_slot_ram,":led"=>$led,
            ":format"=>$format,":prix"=>$prix
        );
		$stmt->execute($data);
		$id = $connection->lastInsertId();
		$corps .= "et récupérer l'identifiant ". $id. "<br>";
        $carte_mere = new CARTE_MERE($id,$nom,$marque,$chipset,$frequence_memoire_max,$wifi,$nb_slot_ram,$led,$format,$prix);
        $corps = "Insertion de : <br>". $carte_mere;
        $zonePrincipale=$corps ;
        $zoneAjouter="";
        $connection = null;
    }
    else {
        // Afficher les messages d'erreur
        foreach ($erreurs as $key => $message) {
            $erreur[$key] = $message;
        }
        include("formulaire_carte_mere.html");
    }
}
?>
