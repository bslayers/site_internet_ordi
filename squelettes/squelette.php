<!doctype html>
<html lang="fr">
<head>
  <title>Composant PC</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="/style/form.css"  type="text/css" >
</head>
<body>
  <h1>Composant PC</h1>
  <br>
  <table class="Menu">
  <tr class="Menu">
    <td class="Menutd"><p><a class="c2" href="/index.php?action=liste">Liste des composants PC</a><br></p></td>
    <td class="Menutd"><p><a class="c2" href="/include/alimentation/Alimentation.php?action=liste">Alimentations</a><br></p></td>
    <td class="Menutd"><p><a class="c2" href="/include/boitier/Boitier.php?action=liste">Boitiers</a><br></p></td>
    <td class="Menutd"><p><a class="c2" href="/include/carte_graphique/Carte_graphique.php?action=liste">Cartes Graphiques</a><br></p></td>
    <td class="Menutd"><p><a class="c2" href="/include/carte_mere/Carte_mere.php?action=liste">Cartes Mères</a><br></p></td>
    <td class="Menutd"><p><a class="c2" href="/include/processeur/Processeur.php?action=liste">Processeurs</a><br></p></td>
    <td class="Menutd"><p><a class="c2" href="/include/ram/Barrette_de_ram.php?action=liste">Mémoires Ram</a><br></p></td>
    <td class="Menutd"><p><a class="c2" href="/include/stockage/Stockage.php?action=liste">Stockages</a><br></p></td>
  </tr>

  </table>
  <table class="tabM">
  <tr>
    <td class="tdM"><?php  echo $zonePrincipale; ?><br>  </td>
    <?php  echo $zoneAjouter; ?>
  </tr>
  </table>
  <table class="Menu">
  <tr>
    <td class="aPropos"><p><a href="/include/config/apropos.php">Lien vers la page A propos</a><br></p></td>
    <td>
    <form method="get" action="<?php echo $nomClasse ?>.php?action=recherche">
      <label for="recherche">Recherche:</label>
      <input type="text" id="recherche" name="recherche" value="<?php echo $_GET['recherche'] ?? ''; ?>">
      <input type="hidden" name="action" value="recherche">
      <input type="submit" value="Chercher">
    </form>

    </td>
  </tr>

  </table>

</body>
</html>
