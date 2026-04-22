<?php
session_start();
$title = "Liste des stagiaires - Cfitech";
$nav = "listStagiaires";

require "./functions/authentification.php";


if (!is_connected()) {
    header("Location: ./login.php");
    exit;
}

require "bd.php";
require "classes/Stagiaire.php";
require "classes/Formation.php";
require "header.php";


try {
    $resultat = $pdo->query('
        SELECT stagiaires.*, formations.intitule AS formation_intitule, formations.id AS formation_id
        FROM stagiaires
        LEFT JOIN participe ON stagiaires.id = participe.id_stagiaire
        LEFT JOIN formations ON participe.id_formation = formations.id
        ORDER BY stagiaires.nom ASC, stagiaires.prenom ASC
    ');
    $tabStagiaires = $resultat->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<h1>Liste des stagiaires</h1>
<p class="text"><?= count($tabStagiaires) ?> stagiaire(s) inscrit(s)</p>

<section class="yellow">
    <?php if (count($tabStagiaires) === 0): ?>
        <p style="text-align: center; color: #883823;">Aucun stagiaire inscrit pour le moment.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Formation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tabStagiaires as $s):
                        $stagiaire = new Stagiaire($s->id, $s->nom, $s->prenom, $s->email, $s->date_naissance);
                    ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($stagiaire->getNom()) ?></strong></td>
                            <td><?= htmlspecialchars($stagiaire->getPrenom()) ?></td>
                            <td><a href="mailto:<?= htmlspecialchars($stagiaire->getEmail()) ?>" style="margin:0; padding:0; font-size:1rem; color:#883823;"><?= htmlspecialchars($stagiaire->getEmail()) ?></a></td>
                            <td>
                                <?php if ($s->formation_intitule): ?>
                                    <em><?= htmlspecialchars($s->formation_intitule) ?></em>
                                <?php else: ?>
                                    <span style="color:#999;">— Aucune —</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 30px;">
        <a href="./addStagiaire.php" class="btn-form-log" style="display:inline-block; margin:0; border:2px solid #F6D695;">➕ Ajouter un stagiaire</a>
    </div>
</section>

<?php require "footer.php"; ?>