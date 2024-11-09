<?php

$idP=$_GET["idP"];
$connection =connecter();
$sql="DELETE FROM STOCKAGE where idP like '$idP'";
$tab='
   <form action="Stockage.php?action=sauvegarde" method="post">
       <input type="hidden" name="types" value="'.'confirmdelete'.'"/>
       <input type="hidden" name="idP" value="'.$idP.'"/>
       <input type="hidden" name="sql" value="'.$sql.'"/>
       <p>Etes vous sûr de vouloir mettre à jour ce stockage ?</p>
       <p>
           <input type="submit" value="Enregistrer" class="btn btn-danger">
           <a href="Stockage.php?action=liste" class="btn btn-secondary">Annuler</a>
       </p>
   </form>';
$corps = $tab;
$zonePrincipale=$corps ;
$connection = null;





 ?>
