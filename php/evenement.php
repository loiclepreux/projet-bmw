<?php
session_start();
require_once 'config.php';

$evenements = $pdo->query("SELECT * FROM evenement ORDER BY date DESC")->fetchAll();

// Transforme n'importe quel lien YouTube en lien "embed" (le seul accepté dans une iframe).
// Marche avec : youtube.com/watch?v=..., youtu.be/..., youtube.com/shorts/...,
// youtube.com/embed/... ou juste l'identifiant de 11 caractères.
// Renvoie null si ce n'est pas une vidéo YouTube.
function lienYoutube(?string $lien): ?string
{
    $lien = trim($lien ?? '');
    if ($lien === '') {
        return null;
    }
    if (preg_match('~^[A-Za-z0-9_-]{11}$~', $lien)) {
        $id = $lien;
    } elseif (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $lien, $m)) {
        $id = $m[1];
    } else {
        return null;
    }
    return 'https://www.youtube-nocookie.com/embed/' . $id;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EVA Concession BMW</title>
    <link rel="stylesheet" href="../css/evenement.css" />
    <link rel="stylesheet" href="../css/responsive.css?v=2" />
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
            <a href="modele.php" class="onglet-btn nos-modele">Nos modèles</a>
            <a href="organigramme.php" class="onglet-btn notre-equipe">Notre équipe</a>
        </nav>

        <div class="titre">
            <h2>ÉVÉNEMENTS</h2>
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
                    <?php $video = lienYoutube($e['video'] ?? null); ?>
                    <?php if ($video): ?>
                        <div class="evenement-video">
                            <iframe src="<?= htmlspecialchars($video) ?>"
                                title="<?= htmlspecialchars($e['titre']) ?>"
                                loading="lazy"
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
            <p>© 2025 EVA Concession — Site fictif réalisé dans le cadre d'une formation, non affilié à BMW</p>
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

    <script src="../js/nav.js?v=2"></script>
</body>

</html>