<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$vehicules = $pdo->query("SELECT * FROM vehicules ORDER BY id")->fetchAll();

$messages = [
    'reservation' => ['ok'     => ['Votre réservation a bien été envoyée ! Nous vous contacterons rapidement.', 'success']],
    'essai'       => ['ok'     => ['Votre demande d\'essai a bien été enregistrée !', 'success']],
    'erreur'      => [
        'champs'  => ['Veuillez remplir tous les champs obligatoires.', 'error'],
        'email'   => ['Adresse email invalide.', 'error'],
        'bdd'     => ['Une erreur est survenue. Réessayez plus tard.', 'error'],
        'csrf'    => ['Formulaire expiré. Veuillez réessayer.', 'error'],
    ],
];
$flash = null;
if (isset($_GET['reservation'])) $flash = $messages['reservation'][$_GET['reservation']] ?? null;
elseif (isset($_GET['essai']))   $flash = $messages['essai'][$_GET['essai']] ?? null;
elseif (isset($_GET['erreur']))  $flash = $messages['erreur'][$_GET['erreur']] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EVA Concession BMW</title>
    <link rel="stylesheet" href="../css/modele.css" />
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
            <a href="../index.php" class="onglet-btn acceuil">Accueil</a>
            <a href="personnalisation.php" class="onglet-btn customisation">Customisation</a>
            <a href="organigramme.php" class="onglet-btn notre-equipe">Notre équipe</a>
        </nav>

        <section id="galerie">
            <h2>Modèles disponibles</h2>
            <div class="voiture">
                <?php foreach ($vehicules as $v): ?>
                    <div class="modele">
                        <img src="../img/<?= htmlspecialchars($v['image']) ?>" alt="<?= htmlspecialchars($v['nom']) ?>">
                        <p><?= htmlspecialchars($v['marque']) . ' ' . htmlspecialchars($v['nom']) ?></p>
                        <button class="voir-fiche-technique" data-fichier="<?= htmlspecialchars($v['fiche_technique']) ?>"
                            data-image="../img/<?= htmlspecialchars($v['image']) ?>">Voir la fiche technique</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if ($flash): ?>
            <div class="flash flash-<?= $flash[1] ?>">
                <?= htmlspecialchars($flash[0]) ?>
            </div>
        <?php endif; ?>

        <section id="reservation">
            <h2>Reservez votre BMW</h2>
            <form id="form-reservation" action="/php/traitement-reservation.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" />
                <div class="form-group">
                    <label for="nom">Nom complet</label>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom complet" required />
                </div>

                <div class="form-group">
                    <label for="email">Adresse email</label>
                    <input type="email" id="email" name="email" placeholder="exemple@domaine.com" required />
                </div>

                <div class="form-group">
                    <label for="tel">Téléphone</label>
                    <input type="tel" id="tel" name="tel" placeholder="06 00 00 00 00" required />
                </div>

                <div class="form-group">
                    <label for="modele">Modèle BMW</label>
                    <select id="modele" name="modele" required>
                        <option value="">-- Choisissez un modèle --</option>
                        <option value="M2">BMW M2</option>
                        <option value="M3">BMW M3</option>
                        <option value="M4">BMW M4</option>
                        <option value="M5">BMW M5</option>
                        <option value="M6">BMW M6</option>
                        <option value="M7">BMW M7</option>
                        <option value="M8">BMW M8</option>
                        <option value="x3M">BMW X3 M</option>
                        <option value="x5M">BMW X5 M</option>
                        <option value="X6M">BMW X6 M</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="couleur">Couleur souhaitée</label>
                    <input type="text" id="couleur" name="couleur" placeholder="Ex: Noir Saphir métallisé" required />
                </div>

                <div class="form-group">
                    <label for="options">Options supplémentaires</label>
                    <textarea id="options" name="options" rows="4" placeholder="Intérieur cuir, jantes 20 pouces, échappement sport, etc."></textarea>
                </div>

                <div class="form-group">
                    <label for="date">Date souhaitée</label>
                    <input type="date" id="date" name="date" required />
                </div>

                <button type="submit" class="btn-envoyer">Envoyer la réservation</button>
            </form>
        </section>

        <section class="essai">
            <h2>Réservez un essai</h2>
            <form id="form-essai" action="/php/traitement-essai.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" />
                <div class="form-group">
                    <label for="nom-essai">Nom complet</label>
                    <input type="text" id="nom-essai" name="nom-essai" placeholder="Votre nom complet" required />
                </div>

                <div class="form-group">
                    <label for="email-essai">Adresse email</label>
                    <input type="email" id="email-essai" name="email-essai" placeholder="exemple@domaine.com" required />
                </div>

                <div class="form-group">
                    <label for="tel-essai">Téléphone</label>
                    <input type="tel" id="tel-essai" name="tel-essai" placeholder="06 00 00 00 00" required />
                </div>

                <div class="form-group">
                    <label for="modele-essai">Modèle à essayer</label>
                    <select id="modele-essai" name="modele-essai" required>
                        <option value="">-- Choisissez un modèle --</option>
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

                <div class="form-group">
                    <label for="date-essai">Date souhaitée</label>
                    <input type="date" id="date-essai" name="date-essai" required />
                </div>

                <div class="form-group">
                    <label for="heure-essai">Heure souhaitée</label>
                    <input type="time" id="heure-essai" name="heure-essai" required />
                </div>

                <button type="submit" class="btn-envoyer">Envoyer la demande</button>
            </form>
        </section>

    </main>
    <div id="modale-fichier" class="modale">
        <div class="modale-content">
            <span class="close-fichier">&times;</span>
            <img id="img-fichier" src="" alt="Image véhicule" style="max-width: 100%; max-height: 250px; margin-bottom: 20px;" />
            <pre id="contenu-fichier" style="white-space: pre-wrap; color: white; text-align: left; max-height: 400px; overflow-y: auto;"></pre>
        </div>
    </div>

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
    <script src="../js/modele.js"></script>
    <script src="../js/nav.js"></script>
</body>

</html>