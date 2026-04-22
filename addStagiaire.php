<?php
session_start();
$title = "Ajouter un stagiaire - Cfitech";
$nav = "addStagiaire";
$message = null;
$messageType = null;

require "./functions/authentification.php";

if (!is_connected()) {
    header("Location: ./login.php");
    exit;
}

require "bd.php";

try {
    $stmt = $pdo->query('SELECT * FROM formations ORDER BY intitule');
    $formations = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}

// formulaire
if (
    !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email'])
    && !empty($_POST['date_naissance']) && !empty($_POST['formation'])
) {

    $nom            = $_POST['nom'];
    $prenom         = $_POST['prenom'];
    $email          = $_POST['email'];
    $date_naissance = $_POST['date_naissance'];
    $id_formation   = $_POST['formation'];

    try {
        $req = $pdo->prepare('INSERT INTO stagiaires (nom, prenom, email, date_naissance) 
        VALUES (:nom, :prenom, :email, :date_naissance)');
        $req->execute([
            'nom'            => $nom,
            'prenom'         => $prenom,
            'email'          => $email,
            'date_naissance' => $date_naissance
        ]);


        $idStagiaire = $pdo->lastInsertId();

        // Étape 2 : associer le stagiaire à la formation dans la table participe
        try {
            $reqP = $pdo->prepare('INSERT INTO participe (id_stagiaire, id_formation) 
                VALUES (:id_stagiaire, :id_formation)');
            $reqP->execute([
                'id_stagiaire' => $idStagiaire,
                'id_formation' => $id_formation
            ]);

            $message = "✅ Le stagiaire $prenom $nom a été ajouté avec succès !";
            $messageType = "success";
        } catch (PDOException $e) {
            $message = "Stagiaire ajouté mais erreur lors de l'inscription à la formation : " . $e->getMessage();
            $messageType = "danger";
        }
    } catch (PDOException $e) {

        if ($e->getCode() == 23000) {
            $message = "❌ Cet email est déjà utilisé par un autre stagiaire !";
        } else {
            $message = "❌ Erreur : " . $e->getMessage();
        }
        $messageType = "danger";
    }
}
require "header.php";
?>

<h1>Ajouter un stagiaire</h1>

<section class="yellow">
    <?php if ($message): ?>
        <p class="<?= $messageType === 'success' ? 'textSuccess' : 'textError' ?>">
            <?= $message ?>
        </p>
    <?php endif; ?>

    <form action="./addStagiaire.php" method="POST">
        <input type="text" name="nom" placeholder="Nom" required>
        <br>
        <input type="text" name="prenom" placeholder="Prénom" required>
        <br>
        <input type="email" name="email" placeholder="Email (doit être unique)" required>
        <br>
        <label>Date de naissance :</label>
        <br>
        <input type="date" name="date_naissance" required>
        <br>
        <select name="formation" required>
            <option value="">-- Sélectionnez une formation --</option>
            <?php foreach ($formations as $f): ?>
                <option value="<?= $f->id ?>">
                    <?= htmlspecialchars($f->intitule) ?> (<?= $f->nb_mois ?> mois)
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit" class="btn-form-log">Ajouter</button>
    </form>
</section>

<?php require "footer.php"; ?>