<?php

$idP=$_GET["idP"];
$connection =connecter();
$sql="DELETE FROM CARTE_MERE where idP like '$idP'";
$tab='
   <form action="Carte_mere.php?action=sauvegarde" method="post">
       <input type="hidden" name="type" value="'.'confirmdelete'.'"/>
       <input type="hidden" name="idP" value="'.$idP.'"/>
       <input type="hidden" name="sql" value="'.$sql.'"/>
       <p>Etes vous sûr de vouloir mettre à jour cette Carte Mere ?</p>
       <p>
           <input type="submit" value="Enregistrer" class="btn btn-danger">
           <a href="Carte_mere.php?action=liste" class="btn btn-secondary">Annuler</a>
       </p>
   </form>';
$corps = $tab;
$zonePrincipale=$corps ;
$connection = null;



 ?>
