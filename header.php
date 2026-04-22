<!doctype html>
<html lang="fr">

<?php
require_once "./functions/authentification.php";
require_once "bd.php";

try {
  $stmtMenu = $pdo->query('SELECT id, intitule FROM formations ORDER BY intitule');
  $formationsMenu = $stmtMenu->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
  die('Erreur : ' . $e->getMessage());
}
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="author" content="Mariam Omri">
  <meta name="description" content="Cfitech - Centre de formation IT">
  <title>
    <?php
    if (isset($title)):
      echo $title;
    else:
      echo "Cfitech";
    endif
    ?>
  </title>

  <link rel="stylesheet" href="assets/css/style.css">

  <script src="https://kit.fontawesome.com/8e9b05eb90.js" crossorigin="anonymous"></script>
</head>

<body>

  <div class="wrapper">

    <header>
      <a href="./index.php">
        <img src="assets/img/logo.png" alt="logo Cfitech" class="logo">
      </a>

      <nav>
        <a href="./index.php" class="<?php if (isset($nav) && $nav === "index"): ?>active<?php endif ?>">Accueil</a>

        <?php if (is_connected()): ?>
          <a href="./listStagiaires.php" class="<?php if (isset($nav) && $nav === "listStagiaires"): ?>active<?php endif ?>">Stagiaires</a>

          <a href="./addStagiaire.php" class="<?php if (isset($nav) && $nav === "addStagiaire"): ?>active<?php endif ?>">Ajouter</a>

          <!-- Dropdown -->
          <div class="dropdown">
            <a href="#" class="<?php if (isset($nav) && $nav === "parFormation"): ?>active<?php endif ?>">Par formation ▾</a>
            <div class="dropdown-menu">
              <?php foreach ($formationsMenu as $f): ?>
                <a href="./parFormation.php?id=<?= $f->id ?>"><?= htmlspecialchars($f->intitule) ?></a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      </nav>

      <nav class="nav-right">
        <?php if (!is_connected()): ?>
          <a href="./login.php" class="<?php if (isset($nav) && $nav === "login"): ?>active<?php endif ?>">Login</a>
        <?php else: ?>
          <span class="user-info">👤 <?= htmlspecialchars($_SESSION['pseudo'] ?? '') ?></span>
          <a href="./logout.php">Logout</a>
        <?php endif; ?>
      </nav>
    </header>

    <main>