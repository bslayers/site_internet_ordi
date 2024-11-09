<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Boitier.php");
if (!isset($_POST["nom"])    && !isset($_POST["marque"]) ) /* et autres champs*/
{
    include("formulaire_boitier.html");
}
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $type_tour = key_exists('type_tour', $_POST)? trim($_POST['type_tour']): null;
    $format = key_exists('format', $_POST)? trim($_POST['format']): null;
    $fenetre = key_exists('fenetre', $_POST)? trim($_POST['fenetre']): null;
    $couleur = key_exists('couleur', $_POST)? trim($_POST['couleur']): null;
    $led = key_exists('led', $_POST)? trim($_POST['led']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$type_tour,$format,$fenetre,$couleur,$led,$prix);
    if (empty($erreurs)) {
        $connection =connecter();
        $corps = "Connection etablie <br>";
		$corps .= "Il faut maintenant insérer les données du formulaire dans la base <br>";
        $rq = "INSERT INTO BOITIER (id,nom,marque,type_tour,format,fenetre,couleur,led,prix)
            VALUES (:id,:nom,:marque,:type_tour,:format,:fenetre,:couleur,:led,:prix)";
		$stmt = $connection->prepare($rq);
		$data = array(
            ":id" => $id , ":nom" => $nom,
            ":marque" => $marque,":type_tour" => $type_tour,
            ":format"=>$format,":fenetre"=>$fenetre,
            ":couleur"=>$couleur,":led"=>$led,
            ":prix"=>$prix
        );
		$stmt->execute($data);
		$id = $connection->lastInsertId();
		$corps .= "et récupérer l'identifiant ". $id. "<br>";
        $boitier = new BOITIER($id,$nom,$marque,$type_tour,$format,$fenetre,$couleur,$led,$prix);
        $corps = "Insertion de : <br>". $boitier;
        $zonePrincipale=$corps ;
        $zoneAjouter="";
        $connection = null;
    }
    else {
        // Afficher les messages d'erreur
        foreach ($erreurs as $key => $message) {
            $erreur[$key] = $message;
        }
        include("formulaire_boitier.html");
    }
}
?>
