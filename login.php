<?php
session_start();
$title = "Login - Cfitech";
$nav = "login";
$erreur = null;

require "bd.php";
require "./functions/authentification.php";

if (is_connected()) {
    header("Location: ./listStagiaires.php");
    exit;
}

if (!empty($_POST['pseudo']) && !empty($_POST['password'])) {
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    try {
        $req = $pdo->prepare('SELECT * FROM personnel WHERE pseudo = :pseudo');
        $req->execute(['pseudo' => $pseudo]);
        $user = $req->fetch(PDO::FETCH_OBJ);
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }

    if ($user && $password === $user->mot_de_passe) {
        $_SESSION['pseudo'] = $user->pseudo;
        $_SESSION['prenom'] = $user->prenom;
        $_SESSION['nom'] = $user->nom;
        $_SESSION['connected'] = true;


        header("Location: ./listStagiaires.php");
        exit;
    } else {
        $erreur = "❌ Pseudo ou mot de passe incorrect !";
    }
}

require "header.php";
?>

<div class="login">
    <h1>Connexion</h1>

    <?php if ($erreur): ?>
        <p class="textError"><?= $erreur ?></p>
    <?php endif; ?>

    <form action="./login.php" method="POST">
        <input type="text" name="pseudo" placeholder="Entrez votre pseudo" required>
        <br>
        <input type="password" name="password" placeholder="Entrez votre mot de passe" required>
        <br>
        <button type="submit" class="btn-form-log">Se connecter</button>
    </form>

    <p style="margin-top: 20px; color: #883823; font-size: 0.9rem;">
        💡 Identifiants de test : (<strong>doeking</strong> / <strong>cfitech</strong>)
    </p>
</div>

<?php require "footer.php"; ?>