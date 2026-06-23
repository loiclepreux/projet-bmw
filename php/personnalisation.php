<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = '';
if (isset($_GET['envoi']) && $_GET['envoi'] === 'ok') {
    $message = 'Votre demande de personnalisation a bien été envoyée !';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EVA Concession BMW</title>
    <link rel="stylesheet" href="../css/personnalisation.css" />
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
        <a href="evenement.php" class="onglet-btn events-m">Events M</a>
        <a href="../index.php" class="onglet-btn acceuil">accueil</a>
        <a href="modele.php" class="onglet-btn nos-modele">Nos modéles</a>
        <a href="organigramme.php" class="onglet-btn notre-equipe">Nôtre équipe</a>
    </nav>

    <?php if ($message): ?>
        <p style="color: cyan; text-align: center; padding: 1rem;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <section id="formulaire-customisation">
        <h2>Personnalisez votre BMW</h2>
    <form id="form-bmw" action="/php/traitement-customisation.php" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

    <!-- 1. Infos personnelles -->
    <div class="form-section">
        <h3>Informations personnelles</h3>
        <div class="form-group">
            <label for="nom">Nom complet</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" required>
        </div>
    </div>

    <!-- 2. Modèle choisi -->
    <div class="form-section">
        <h3>Modèle BMW</h3>
        <div class="form-group">
            <label for="modele">Choisissez un modèle</label>
            <select id="modele" name="modele" required>
                <option value="">-- Choisissez --</option>
                <option value="M2">BMW M2</option>
                <option value="M3">BMW M3</option>
                <option value="M4">BMW M4</option>
                <option value="M5">BMW M5</option>
                <option value="M6">BMW M6</option>
                <option value="M7">BMW M7</option>
                <option value="M8">BMW M8</option>
                <option value="X3M">BMW X3 M</option>
                <option value="X5M">BMW X5 M</option>
                <option value="X6M">BMW X6 M</option>
            </select>
        </div>
    </div>

    <!-- 3. Personnalisation basique -->
    <div class="form-section">
        <h3>Personnalisation basique</h3>
        <div class="form-group">
            <label for="couleur">Couleur de peinture</label>
            <select id="couleur" name="couleur">
                <option>Blanc Alpine</option>
                <option>Noir Saphir</option>
                <option>Bleu Misano</option>
                <option>Gris Brooklyn</option>
            </select>
        </div>
        <div class="form-group">
            <label for="jantes">Type de jantes</label>
            <select id="jantes" name="jantes">
                <option>Jantes 18" standard</option>
                <option>Jantes 19" M Sport</option>
                <option>Jantes 20" Performance</option>
            </select>
        </div>
        <div class="form-group">
            <label for="sellerie">Sellerie intérieure</label>
            <select id="sellerie" name="sellerie">
                <option>Cuir noir</option>
                <option>Cuir beige</option>
                <option>Alcantara</option>
            </select>
        </div>
    </div>

    <!-- 4. Personnalisation avancée -->
    <div class="form-section">
    <h3>Personnalisation Extrême</h3>

    <label for="stage1">Préparation moteur Stage 1 :</label>
    <select id="stage1" name="stage1">
        <option value="">-- Choisir --</option>
        <option>+50ch (ECU reprogrammé)</option>
        <option>+80ch (ECU + admission sport)</option>
    </select>

    <label for="stage2">Préparation moteur Stage 2 :</label>
    <select id="stage2" name="stage2">
        <option value="">-- Choisir --</option>
        <option>+100ch (échappement sport)</option>
        <option>+130ch (turbo hybride)</option>
    </select>

    <h4>Kit carrosserie</h4>
    <label><input type="radio" name="kit" value="complet"> Kit complet</label>
    <label><input type="radio" name="kit" value="personnalise"> Choix des éléments</label>

    <div class="sous-options">
        <label><input type="checkbox" name="elements[]" value="splitter"> Splitter avant</label>
        <label><input type="checkbox" name="elements[]" value="diffuseur"> Diffuseur arrière</label>
        <label><input type="checkbox" name="elements[]" value="aileron"> Aileron</label>
        <label><input type="checkbox" name="elements[]" value="jupes"> Jupes latérales</label>
    </div>

    <h4>Peinture personnalisée</h4>
    <label for="finition">Finition :</label>
    <select id="finition" name="finition">
        <option>Mat</option>
        <option>Perlée</option>
        <option>Chromée</option>
        <option>Caméléon</option>
    </select>

    <label for="motif">Motif :</label>
    <select id="motif" name="motif">
        <option>Aucun</option>
        <option>Bandes sport</option>
        <option>Carbone</option>
        <option>Dégradé racing</option>
    </select>

    <h4>Intérieur sur mesure</h4>
    <label for="sellerie-extreme">Sellerie :</label>
    <select id="sellerie-extreme" name="sellerie-extreme">
        <option>Cuir sur mesure</option>
        <option>Alcantara bi-ton</option>
        <option>Finition carbone & cuir</option>
    </select>

    <label for="volant">Volant :</label>
    <select id="volant" name="volant">
        <option>Sport LED</option>
        <option>Carbone</option>
        <option>M chauffant</option>
    </select>

    <h4>Éléments de sous-châssis</h4>
    <label><input type="checkbox" name="neons" value="oui"> Néons RGB</label>
    <label><input type="checkbox" name="diffuseur" value="sonore"> Diffuseur sonore</label>
    </div>
    <button type="submit">Envoyer ma demande</button>
    </form>
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

<script src="../js/nav.js"></script>
</body>
</html>
