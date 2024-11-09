<?php

$idP=$_GET["idP"];
$connection =connecter();
$sql="DELETE FROM PROCESSEUR where idP like '$idP'";
$tab='
   <form action="Processeur.php?action=sauvegarde" method="post">
       <input type="hidden" name="type" value="'.'confirmdelete'.'"/>
       <input type="hidden" name="idP" value="'.$idP.'"/>
       <input type="hidden" name="sql" value="'.$sql.'"/>
       <p>Etes vous sûr de vouloir mettre à jour ce Processeur ?</p>
       <p>
           <input type="submit" value="Enregistrer" class="btn btn-danger">
           <a href="Processeur.php?action=liste" class="btn btn-secondary">Annuler</a>
       </p>
   </form>';
$corps = $tab;
$zonePrincipale=$corps ;
$connection = null;

 ?>
