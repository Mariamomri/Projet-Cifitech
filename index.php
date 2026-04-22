<?php
session_start();

$title = "Accueil - Cfitech";
$nav = "index";
require "./functions/authentification.php";
require "bd.php";
require "classes/Formation.php";
require "header.php";

try {
    $resultat = $pdo->query('
        SELECT formations.*, COUNT(participe.id_stagiaire) AS nb_stagiaires
        FROM formations
        LEFT JOIN participe ON formations.id = participe.id_formation
        GROUP BY formations.id
        ORDER BY formations.intitule
    ');
    $tabFormations = $resultat->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}


$icons = [
    "Web Dev"    => "💻",
    "Technicien" => "🔧",
    "Java Dev"   => "☕"
];
?>

<p class="text">Centre de formation — Bruxelles</p>

<h1>Bienvenue chez Cfitech</h1>

<div class="banner-wrap">
    <img src="assets/img/WhatsApp Image 2026-03-05 at 11.50.05.jpeg" alt="Bienvenue chez Cfitech">
</div>

<h2>Nos formations</h2>


<div class="yellow">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Intitulé</th>
                    <th>Durée (mois)</th>
                    <th>Date de début</th>
                    <th>Nombre de stagiaires</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tabFormations as $f):
                    $formation = new Formation($f->id, $f->intitule, $f->nb_mois, $f->date_debut);
                ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($formation->getIntitule()) ?></strong></td>
                        <td><?= $formation->getNbMois() ?> mois</td>
                        <td><?= $formation->getDateDebutFormatee() ?></td>
                        <td><?= $f->nb_stagiaires ?> stagiaire(s)</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<h2>Découvrez nos formations</h2>
<div class="listCard">
    <?php foreach ($tabFormations as $f):
        $formation = new Formation($f->id, $f->intitule, $f->nb_mois, $f->date_debut);
        $icon = isset($icons[$f->intitule]) ? $icons[$f->intitule] : "📚";
    ?>
        <div class="card">
            <div class="formation-icon"><?= $icon ?></div>
            <div class="textCard">
                <h3><?= htmlspecialchars($formation->getIntitule()) ?></h3>
                <p><strong>Durée :</strong> <?= $formation->getNbMois() ?> mois</p>
                <p><strong>Début :</strong> <?= $formation->getDateDebutFormatee() ?></p>
                <p class="nb-stagiaires"><?= $f->nb_stagiaires ?> stagiaire(s) inscrit(s)</p>
                <?php if (is_connected()): ?>
                    <a href="./parFormation.php?id=<?= $formation->getId() ?>">Voir la liste</a>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require "footer.php"; ?>