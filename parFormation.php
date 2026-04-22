<?php
session_start();
$title = "Par formation - Cfitech";
$nav = "parFormation";

require "./functions/authentification.php";


if (!is_connected()) {
    header("Location: ./login.php");
    exit;
}

require "bd.php";
require "classes/Stagiaire.php";
require "classes/Formation.php";
require "header.php";

// Récupérer l'id de la formation depuis l'URL
$idFormation = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$formation = null;
$stagiaires = [];

if ($idFormation > 0) {
    try {
        $req = $pdo->prepare('SELECT * FROM formations WHERE id = :id');
        $req->execute(['id' => $idFormation]);
        $f = $req->fetch(PDO::FETCH_OBJ);
        if ($f) {
            $formation = new Formation($f->id, $f->intitule, $f->nb_mois, $f->date_debut);
        }
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }

    // Récupérer les stagiaires inscrits à cette formation
    try {
        $req = $pdo->prepare('
            SELECT stagiaires.*
            FROM stagiaires
            INNER JOIN participe ON stagiaires.id = participe.id_stagiaire
            WHERE participe.id_formation = :id_formation
            ORDER BY stagiaires.nom ASC, stagiaires.prenom ASC
        ');
        $req->execute(['id_formation' => $idFormation]);
        $tabStagiaires = $req->fetchAll(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

try {
    $stmt = $pdo->query('SELECT * FROM formations ORDER BY intitule');
    $toutesFormations = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<h1>Par formation</h1>

<!-- Sous-onglets : un par formation -->
<div style="text-align: center; margin: 20px 0;">
    <?php foreach ($toutesFormations as $f):
        $bgColor = ($idFormation == $f->id)
            ? "background-color: #883823; color: #F6D695; border: 2px solid #F6D695;"
            : "background-color: #F5EEDD; color: #883823; border: 2px solid #883823;";
    ?>
        <a href="./parFormation.php?id=<?= $f->id ?>"
            style="margin: 5px; font-size: 1.1rem; padding: 10px 25px; border-radius: 50px; <?= $bgColor ?>">
            <?= htmlspecialchars($f->intitule) ?>
        </a>
    <?php endforeach; ?>
</div>

<?php if ($formation !== null): ?>
    <section class="yellow">
        <h2>Stagiaires inscrits à : <?= htmlspecialchars($formation->getIntitule()) ?></h2>
        <p style="text-align: center; color: #883823; font-size: 1.1rem;">
            Durée : <?= $formation->getNbMois() ?> mois — Début : <?= $formation->getDateDebutFormatee() ?>
        </p>

        <?php if (count($tabStagiaires) === 0): ?>
            <p style="text-align: center; color: #883823; margin-top: 30px;">
                Aucun stagiaire inscrit à cette formation.
            </p>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Date de naissance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tabStagiaires as $s):
                            $stagiaire = new Stagiaire($s->id, $s->nom, $s->prenom, $s->email, $s->date_naissance);
                        ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($stagiaire->getNom()) ?></strong></td>
                                <td><?= htmlspecialchars($stagiaire->getPrenom()) ?></td>
                                <td><?= htmlspecialchars($stagiaire->getEmail()) ?></td>
                                <td><?= $stagiaire->getDateNaissanceFormatee() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
<?php else: ?>
    <p style="text-align: center; color: #883823; font-size: 1.2rem; margin: 50px;">
        👆 Sélectionnez une formation ci-dessus pour voir ses stagiaires.
    </p>
<?php endif; ?>

<?php require "footer.php"; ?>