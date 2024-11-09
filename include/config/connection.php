<?php
function connecter(){
    try {

        $dns = "mysql:host=127.0.0.1;dbname=thomas";
        $utilisateur ="utilisateur_local";
        $motDePasse="thomas";

        // Options de connexion
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        $connection = new PDO($dns, $utilisateur, $motDePasse, $options);
        return $connection;

    } catch (Exception $e) {
        echo "Connection à MySQL impossible : ", $e->getMessage(), "\n";
        die();
    }
}

//cette fonction créer une liste de composant en fonction des paraemetre mit en entrer
//elle a était créer pour eviter la répétition et pour améliorer la visibilité du code
function listeduComposant($requete,$nomPackage,$nomClasse,$phraseListe,$phraseAjout) {
    $corps="<h1>".$phraseListe."</h1>";
    $connection = connecter();
    $query = $connection->query($requete);
    $query->setFetchMode(PDO::FETCH_OBJ);

    $corps.= "<h4><span class='c1'><b><u>id</u></b></span> <span class='c1'><b>Nom</b> </span><span class='c1'><b>marque</b></span><span class='c1'><b>prix</b></span><span class='c1'><b>Action</b></span></h4>";

    while( $enregistrement = $query->fetch() ){
        $corps.= "<span class='c1'><u><b>".$enregistrement->id."</b></u></span> <span class='c1'>".$enregistrement->nom." </span><span class='c1'>". $enregistrement->marque."</span><span class='c1'>". $enregistrement->prix."</span>";
        $corps.=  '<span class=\'c1\'><a href="'.$nomClasse.'.php?action=select&id='. $enregistrement->id.'"><span class="glyphicon glyphicon-eye-open"></span></a>';
        $corps.=  '<a href="'.$nomClasse.'.php?action=update&id='. $enregistrement->id.'"><span class="glyphicon glyphicon-pencil"></span></a>';
        $corps.=  '<a href="'.$nomClasse.'.php?action=delete&id='. $enregistrement->id.'"><span class="glyphicon glyphicon-trash"></span></a></span>';
        $corps.="<br>";
    }

    $zonePrincipale=$corps;
    $zoneAjouter="<td><br><p><a href='/include/$nomPackage/$nomClasse.php?action=insert'>Ajouter $phraseAjout</a><br></p>" ;
    $zoneAjouter.="<p><a href='/include/$nomPackage/$nomClasse.php?action=trieMarque'>Trier en fonction de la marque</a><br></p>";
    $zoneAjouter.="<p><a href='/include/$nomPackage/$nomClasse.php?action=triePrixASC'>Du moins chers au plus chers</a><br></p>";
    $zoneAjouter.="<p><a href='/include/$nomPackage/$nomClasse.php?action=triePrixDESC'>Du plus chers au moins chers</a><br></p></td>";
    $query = null;
    $connection = null;

    return array($zonePrincipale, $zoneAjouter);
}

//version differente de ListeComposant qui est essentiellement fait pour la liste de Composant afficher dans l'index
//Je l'ai créer pour avoir une meilleur visibilité mais également pour eviter de l'ecrire 2 fois donc dans la case liste et recherche du switch
function Composant($requete,$nomClasse,$phraseListe){
        $corps="<h1>".$phraseListe."</h1>";
        $connection = connecter();
        // On envois la requète
        $query = $connection->query($requete);
        // On indique que nous utiliserons les résultats en tant qu'objet
        $query->setFetchMode(PDO::FETCH_OBJ);

		// Nous traitons les résultats en boucle
		$corps.= "<h4><span class='c1'><b><u>Id</u></b></span> <span class='c1'><b>Type de Composant</b> </span><span class='c1'><b>Action</b></span></h4>";
		while( $enregistrement = $query->fetch() ){
			// Affichage des enregistrements
            $corps.= "<span class='c1'><u><b>".$enregistrement->id."</b></u></span> <span class='c1'>".$enregistrement->type." </span>";
			$corps.=  '<a href="'.$nomClasse.'.php?action=select&id='. $enregistrement->id.'"><span class="glyphicon glyphicon-eye-open"></span></a>';
			$corps.="<br>";
		}
		$zonePrincipale=$corps ;
        $zoneAjouter="";
		$query = null;
		$connection = null;

    return array($zonePrincipale, $zoneAjouter);
}

//c'est fonction sert à éviter de créer un fichier delete pour chaque base de données
function supprimer_base($nomBase,$classeName,$phraseMAJ){
    $id = key_exists('id', $_GET)? trim($_GET['id']): null;
    $sql = "DELETE FROM $nomBase WHERE id = :id";

    $tab = '
        <form action="'.$classeName.'.php?action=sauvegarde" method="post">
            <input type="hidden" name="type" value="'.'confirmdelete'.'"/>
            <input type="hidden" name="id" value="'.$id.'"/>
            <input type="hidden" name="sql" value="'.$sql.'"/>
            <p>Etes vous sûr de vouloir mettre à jour '.$phraseMAJ.' ?</p>
            <p>
                <input type="submit" value="Enregistrer" class="btn btn-danger">
                <a href="'.$classeName.'.php?action=liste" class="btn btn-secondary">Annuler</a>
            </p>
        </form>
    ';
    return $tab;
}
?>
