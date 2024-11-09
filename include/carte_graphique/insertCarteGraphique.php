<?php

$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Carte_graphique.php");

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
        $connection =connecter();
        $corps = "Connection etablie <br>";
		$corps .= "Il faut maintenant insérer les données du formulaire dans la base <br>";
        $rq = "INSERT INTO CARTE_GRAPHIQUE (id,nom,marque,chipset_Graphique,memoire_video,consommation,prix)
            VALUES (:id,:nom,:marque,:chipset_Graphique,:memoire_video,:consommation,:prix)";
		$stmt = $connection->prepare($rq);
		$data = array(
            ":id" => $id , ":nom" => $nom,
            ":marque" => $marque,":chipset_Graphique" => $chipset_Graphique,
            ":memoire_video"=>$memoire_video,":consommation"=>$consommation,
            ":prix"=>$prix
        );
		$stmt->execute($data);
		$id = $connection->lastInsertId();
		$corps .= "et récupérer l'identifiant ". $id. "<br>";
        $graphic_card = new Carte_graphique($id,$nom,$marque,$chipset_Graphique,$memoire_video,$consommation,$prix);
        $corps = "Insertion de : <br>". $graphic_card;
        $zonePrincipale=$corps ;
        $zoneAjouter="";
        $connection = null;
    }
    else {
        // Afficher les messages d'erreur
        foreach ($erreurs as $key => $message) {
            $erreur[$key] = $message;
        }
        include("formulaire_carte_graphique.html");
    }
}
?>
