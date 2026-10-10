<?php
session_start();

require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM employes ORDER BY niveau, concession, nom");
$employes = $stmt->fetchAll();

$groupes = [
    1 => [],
    2 => [],
    3 => []
];
foreach ($employes as $e) {
    $groupes[$e['niveau']][] = $e;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Organigramme - EVA Concession</title>
    <link rel="stylesheet" href="../css/organigramme.css" />
    <link rel="stylesheet" href="../css/responsive.css?v=3" />
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
            <a href="evenement.php" class="onglet-btn events-m">Events M</a>
            <a href="personnalisation.php" class="onglet-btn customisation">Customisation</a>
            <a href="modele.php" class="onglet-btn nos-modele">Nos modèles</a>
            <a href="../index.php" class="onglet-btn acceuil">Accueil</a>
        </nav>

        <section class="organigramme">

            <h1>Organigramme de la Concession EVA</h1>

            <div class="niveau">
                <h2>Direction</h2>
                <div class="employes niveau-1">
                    <?php foreach ($groupes[1] as $e): ?>
                        <div class="carte">
                            <img loading="lazy" src="../photo/<?= htmlspecialchars($e['photo']) ?>" alt="<?= htmlspecialchars($e['prenom']) ?>">
                            <h3><?= htmlspecialchars($e['prenom']) . ' ' . htmlspecialchars($e['nom']) ?></h3>
                            <p><?= htmlspecialchars($e['fonction']) ?></p>
                            <p class="concession"><?= htmlspecialchars($e['concession']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="niveau">
                <h2>Responsables Commerciaux</h2>
                <div class="employes niveau-2">
                    <?php foreach ($groupes[2] as $e): ?>
                        <div class="carte">
                            <img loading="lazy" src="../photo/<?= htmlspecialchars($e['photo']) ?>" alt="<?= htmlspecialchars($e['prenom']) ?>">
                            <h3><?= htmlspecialchars($e['prenom']) . ' ' . htmlspecialchars($e['nom']) ?></h3>
                            <p><?= htmlspecialchars($e['fonction']) ?></p>
                            <p class="concession"><?= htmlspecialchars($e['concession']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="niveau">
                <h2>Personnel Technique</h2>
                <div class="employes niveau-3">
                    <?php foreach ($groupes[3] as $e): ?>
                        <div class="carte">
                            <img loading="lazy" src="../photo/<?= htmlspecialchars($e['photo']) ?>" alt="<?= htmlspecialchars($e['prenom']) ?>">
                            <h3><?= htmlspecialchars($e['prenom']) . ' ' . htmlspecialchars($e['nom']) ?></h3>
                            <p><?= htmlspecialchars($e['fonction']) ?></p>
                            <p class="concession"><?= htmlspecialchars($e['concession']) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </section>
    </main>

    <footer id="footer">
        <div class="footer-contenu">
            <p>© 2025 EVA Concession — Site fictif réalisé dans le cadre d'une formation, non affilié à BMW</p>
            <p>
                <a href="../php/mention.php">Mentions légales</a> |
                <a href="../php/politique.php">Politique de confidentialité</a> |
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

    <script src="../js/nav.js?v=2"></script>

</body>

</html>