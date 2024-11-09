<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."include/config/connection.php");
include_once("Barrette_de_ram.php");

if (!isset($_POST["nom"])    && !isset($_POST["marque"]) ) /* et autres champs*/
{
    include("formulaire_ram.html");
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
        $connection =connecter();
        $corps = "Connection etablie <br>";
		$corps .= "Il faut maintenant insérer les données du formulaire dans la base <br>";
        $rq = "INSERT INTO RAM (id,nom,marque,type_memoire,frequence,nb_barettes,capacites_totale,led,prix)
            VALUES (:id,:nom,:marque,:type_memoire,:frequence,:nb_barettes,:capacites_totale,:led,:prix)";
		$stmt = $connection->prepare($rq);
		$data = array(
            ":id" => $id , ":nom" => $nom,
            ":marque" => $marque,":type_memoire" => $type_memoire,
            ":frequence"=>$frequence,":nb_barettes"=>$nb_barettes,
            ":capacites_totale"=>$capacites_totale,":led"=>$led,
            ":prix"=>$prix
        );
		$stmt->execute($data);
		$id = $connection->lastInsertId();
		$corps .= "et récupérer l'identifiant ". $id. "<br>";
        $ram = new Barrette_de_ram($id,$nom,$marque,$type_memoire,$frequence,$nb_barettes,$capacites_totale,$led,$prix);
        $corps = "Insertion de : <br>". $ram;
        $zonePrincipale=$corps ;
        $zoneAjouter="";
        $connection = null;
    }
    else {
        // Afficher les messages d'erreur
        foreach ($erreurs as $key => $message) {
            $erreur[$key] = $message;
        }
        include("formulaire_ram.html");
    }
}
?>
