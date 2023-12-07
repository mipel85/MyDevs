<?php
require_once('./functions/rules.php');
require_once('./classes/connexion.class.php');
require_once('./classes/connexion.class.php');
require_once('./classes/joueurs.class.php');
?>
<section>
    <article class="content">
<?php

$nb_presents = count(joueurs::liste_joueurs_presents());
echo 'Joueurs présents = ' . $nb_presents . ' <br /> composition trouvée = ' . rules($nb_presents) . ' <br /><br />';
?>
<label for="start">Journée du :</label>

<input type="date" id="start" name="trip-start" value="2023-12-01" />
<br />
<br />
<?php

require_once('./functions/creerEquipes.php');

echo '<br /><br />';

require_once('./functions/creerMatchs.php');
?>

</article>
</section>