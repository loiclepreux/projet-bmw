<?php
session_start();
require_once 'config.php';

$evenements = $pdo->query("SELECT * FROM evenement ORDER BY date DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EVA Concession BMW</title>
    <link rel="stylesheet" href="../css/evenement.css" />
    <link rel="stylesheet" href="../css/responsive.css" />
</head>
<body>

<header>
    <nav id="nav-bar">
        <img class="logoM" src="../img/logo-M.png" width="15%" alt="Logo BMW Motorsport" />
        <div id="enseigne">EVA Concession</div>
        <img class="logoM" src="../img/logo-M.png" width="15%" alt="Logo BMW Motorsport" />
    </nav>
</header>

<main>

    <nav id="onglet">
        <a href="personnalisation.php" class="onglet-btn customisation">Customisation</a>
        <a href="../index.php" class="onglet-btn acceuil">Accueil</a>
        <a href="modele.php" class="onglet-btn nos-modele">Nos modéles</a>
        <a href="organigramme.php" class="onglet-btn notre-equipe">Nôtre équipe</a>
    </nav>

    <div class="titre">
        <h2>EVENEMENTS</h2>
    </div>

    <section id="evenement-section">

        <?php if (empty($evenements)): ?>
            <p style="text-align:center; color: cyan;">Aucun événement pour le moment.</p>
        <?php endif; ?>

        <?php foreach ($evenements as $e): ?>
            <div class="evenement">
                <h3><?= htmlspecialchars($e['titre']) ?></h3>
                <p>Date : <?= htmlspecialchars(date('d/m/Y', strtotime($e['date']))) ?></p>
                <p><?= nl2br(htmlspecialchars($e['description'])) ?></p>
                <p>Lieu : <?= htmlspecialchars($e['lieu']) ?></p>
                <?php if (!empty($e['video'])): ?>
                    <div class="evenement-video">
                        <iframe src="<?= htmlspecialchars($e['video']) ?>"
                            style="border: 2px solid cyan; border-radius: 10px"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

    </section>

</main>

<footer id="footer">
    <div class="footer-contenu">
    <p>© 2025 EVA Concession BMW — Tous droits réservés</p>
    <p>
        <a href="mention.php">Mentions légales</a> |
        <a href="politique.php">Politique de confidentialité</a> |
        <a href="#">Espace Admin</a>
    </p>
    <p>
        <a href="mailto:contact@evaconcession.fr">contact@evaconcession.fr</a> —
        📞 03 87 00 00 00
    </p>
    <div class="social">
        <a href="#"><img src="../img/facebook.png" alt="Facebook" /></a>
        <a href="#"><img src="../img/instagram.png" alt="Instagram" /></a>
        <a href="#"><img src="../img/youtube.png" alt="YouTube" /></a>
    </div>
    </div>
</footer>

</body>
</html>
