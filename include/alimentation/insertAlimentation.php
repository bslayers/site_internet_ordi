<?php
$root = $_SERVER["DOCUMENT_ROOT"];
include_once($root."/include/config/connection.php");
include_once("Alimentation.php");

if (!isset($_POST["nom"]) && !isset($_POST["marque"]) && !isset($_POST["puissance"]) && !isset($_POST["norme_80_plus"])){
    if(!isset($_POST["modularites"]) && !isset($_POST["format"]) && !isset($_POST["prix"])){
      include("formulaire_alimentation.html");
    }
  }
else{
    $nom = key_exists('nom', $_POST)? trim($_POST['nom']): null;
    $marque = key_exists('marque', $_POST)? trim($_POST['marque']): null;
    $puissance = key_exists('puissance', $_POST)? trim($_POST['puissance']): null;
    $norme_80_plus = key_exists('norme_80_plus', $_POST)? trim($_POST['norme_80_plus']): null;
    $modularites = key_exists('modularites', $_POST)? trim($_POST['modularites']): null;
    $format = key_exists('format', $_POST)? trim($_POST['format']): null;
    $prix = key_exists('prix', $_POST)? trim($_POST['prix']): null;

    $erreurs = validerFormulaire($nom,$marque,$puissance,$norme_80_plus,$modularites,$format,$prix);
    if (empty($erreurs)) {
        $connection =connecter();
        $corps = "Connection etablie <br>";
		$corps .= "Il faut maintenant insérer les données du formulaire dans la base <br>";
        $rq = "INSERT INTO ALIMENTATION (id,nom,marque,puissance,norme_80_plus,modularites,format,prix)
            VALUES (:id,:nom,:marque,:puissance,:norme_80_plus,:modularites,:format,:prix)";
		$stmt = $connection->prepare($rq);
		$data = array(
            ":id" => $id , ":nom" => $nom,
            ":marque" => $marque,":puissance" => $puissance,
            ":norme_80_plus"=>$norme_80_plus,":modularites"=>$modularites,
            ":format"=>$format,":prix"=>$prix
        );
		$stmt->execute($data);
		$id = $connection->lastInsertId();
		$corps .= "et récupérer l'identifiant ". $id. "<br>";
        $alim = new ALIMENTATION($id,$nom,$marque,$puissance,$norme_80_plus,$modularites,$format,$prix);
        $corps = "Insertion de : <br>". $alim;
        $zonePrincipale=$corps ;
        $zoneAjouter="";
        $connection = null;
    }
    else {
        // Afficher les messages d'erreur
        foreach ($erreurs as $key => $message) {
            $erreur[$key] = $message;
        }
        include("formulaire_alimentation.html");
      }
}
?>
