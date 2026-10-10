<?php
session_start();
require_once(__DIR__ . '/php/config.php');

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EVA Concession BMW</title>
    <link rel="stylesheet" href="/css/bmw.css" />
    <link rel="stylesheet" href="/css/responsive.css?v=3" />
</head>

<body>

    <header>
        <nav id="nav-bar">
            <img class="logoM" src="/img/logo-M.png" width="15%" alt="Logo BMW Motorsport" />
            <div id="enseigne">EVA Concession</div>
            <img class="logoM" src="/img/logo-M.png" width="15%" alt="Logo BMW Motorsport" />
        </nav>
    </header>

    <main>

        <nav id="onglet">
            <a href="/php/evenement.php" class="onglet-btn events-m">Events M</a>
            <a href="/php/personnalisation.php" class="onglet-btn customisation">Customisation</a>
            <a href="/php/modele.php" class="onglet-btn nos-modele">Nos modèles</a>
            <a href="/php/organigramme.php" class="onglet-btn notre-equipe">Notre équipe</a>
        </nav>

        <section id="presentation">
            <h1>Notre histoire</h1>
            <p>
                Vers les années 70, trois protagonistes allemands (<strong>E</strong>ckart / <strong>V</strong>aleska / <strong>A</strong>nke) se sont associés pour faire naître une idée
                qui changerait le point de vue de l'automobile BMW. C'est depuis ce jour que la lettre « M » est devenue bien plus qu’un simple badge. C’est un cri du cœur, un manifeste de puissance,
                un symbole de la passion mécanique allemande portée à son paroxysme. Née des circuits, la division BMW Motorsport s’est imposée comme la référence ultime pour les puristes...
                mais aussi pour les rêveurs.
            </p>
            <p>
                La personnalisation d’une BMW ne se limite pas à des jantes ou une teinte de carrosserie. C’est une philosophie. Une manière de faire d’un bolide une œuvre d’art unique.
                Des moteurs reprogrammés, des lignes redessinées, des intérieurs cousus main... chaque BMW customisée raconte une histoire.
            </p>
            <p>
                Des légendaires E30 M3 aux M2 et M4 contemporaines, les passionnés du monde entier ont toujours repoussé les limites, mêlant tradition et innovation. Aujourd’hui,
                EVA Concession s’inscrit dans cette lignée : offrir des modèles exclusifs, façonnés selon vos envies, avec un souci du détail digne des ateliers les plus prestigieux.
            </p>
            <p>
                Bien plus qu’une voiture. Une extension de votre personnalité. Une signature sur quatre roues.
            </p>
            <p>
                Bienvenue dans l’univers de la personnalisation BMW, où chaque modèle devient une œuvre d’art sur roues et où votre imagination n'as plus de limite.
            </p>
        </section>

        <section id="carousel-3d">

            <h2>Nos créations</h2>
            <div class="panoramique">
                <div class="panoramique-bandeau">
                    <img src="/img/bmw 3.jpg" alt="BMW 1" />
                    <img src="/img/bmw 4.avif" alt="BMW 2" />
                    <img src="/img/bmw-1.png" alt="BMW 3" />
                    <img src="/img/bmw-10.png" alt="BMW 4" />
                    <img src="/img/bmw-2.png" alt="BMW 5" />
                    <img src="/img/bmw-5.png" alt="BMW 6" />
                    <img src="/img/bmw-6.png" alt="BMW 7" />
                    <img src="/img/bmw-7.png" alt="BMW 8" />
                    <img src="/img/bmw-8.png" alt="BMW 9" />
                    <img src="/img/bmw-9.png" alt="BMW 10" />
                    <!-- Clone pour l'effet de boucle fluide -->
                    <img src="/img/bmw 3.jpg" alt="BMW 1" />
                    <img src="/img/bmw 4.avif" alt="BMW 2" />
                    <img src="/img/bmw-1.png" alt="BMW 3" />
                    <img src="/img/bmw-10.png" alt="BMW 4" />
                    <img src="/img/bmw-2.png" alt="BMW 5" />
                    <img src="/img/bmw-5.png" alt="BMW 6" />
                    <img src="/img/bmw-6.png" alt="BMW 7" />
                    <img src="/img/bmw-7.png" alt="BMW 8" />
                    <img src="/img/bmw-8.png" alt="BMW 9" />
                    <img src="/img/bmw-9.png" alt="BMW 10" />
                </div>
            </div>
        </section>

        <section id="contenu-principal">

            <div class="exposition">
                <audio id="son-m2" preload="none">
                    <source src="/son/Bmw m2.mp3" type="audio/mpeg" />
                </audio>
                <img class="bmw-model" src="/img/bmw-m2-removebg-preview.png" onclick="jouerSonM2();" alt="BMW M2" />
            </div>

            <div class="contenue">
                <h2>Où nous trouver</h2>
                <p>
                    EVA Concession BMW<br>
                    123 Rue des Ingénieurs<br>
                    ZAC Technopôle Auto<br>
                    57000 Metz - France<br>
                    📞 03 87 00 00 00<br>
                    ✉️ contact@evaconcession.fr
                </p>
            </div>
            <div class="exposition">
                <audio id="son-m4" preload="none">
                    <source src="/son/BMW M4.mp3" type="audio/mpeg" />
                </audio>
                <img class="bmw-model" src="/img/bmw-m4-removebg-preview.png" onclick="jouerSonM4();" alt="BMW M4" />
            </div>
        </section>

        <section id="contenu-secondaire">

            <h2>Nos concessions</h2>
            <div class="adresses">
                <div class="adresse">EVA Concession Paris<br>15 Rue de la Mécanique<br>75008 Paris<br>📞 01 82 45 67 89<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Lyon<br>42 Rue du Circuit<br>69006 Lyon<br>📞 04 78 90 12 34<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Marseille<br>8 Boulevard du Piston<br>13008 Marseille<br>📞 04 91 23 45 67<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Bordeaux<br>77 Rue des Motoristes<br>33000 Bordeaux<br>📞 05 56 78 90 12<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Lille<br>11 Rue du Turbo<br>59800 Lille<br>📞 03 20 45 67 89<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Strasbourg<br>90 Rue de l’Allumage<br>67000 Strasbourg<br>📞 03 88 90 12 34<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Toulouse<br>23 Avenue des Bolides<br>31000 Toulouse<br>📞 05 61 23 45 67<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Nice<br>5 Route de l’Accélération<br>06000 Nice<br>📞 04 93 78 90 12<br>✉️ contact@evaconcession.fr</div>
                <div class="adresse">EVA Concession Nantes<br>34 Rue du Moteur<br>44000 Nantes<br>📞 02 40 45 67 89<br>✉️ contact@evaconcession.fr</div>
            </div>
        </section>

        <section id="contenu-tertiaire">

            <h2>Nos services</h2>
            <ul class="services-liste">
                <li><strong>Personnalisation sur mesure</strong> – Choisissez chaque détail de votre BMW : peinture, sellerie, jantes, éclairage, sonorisation, etc.</li>
                <li><strong>Préparation moteur & châssis</strong> – Optimisations de performance pour un comportement routier encore plus affûté.</li>
                <li><strong>Atelier carrosserie & wrapping</strong> – Covering haut de gamme, detailing complet, rénovation peinture.</li>
                <li><strong>Pièces & accessoires officiels</strong> – Large choix de pièces M Performance et accessoires BMW Lifestyle.</li>
                <li><strong>Suivi client dédié</strong> – Service après-vente avec équipe spécialisée BMW M et véhicule de prêt personnalisé.</li>
                <li><strong>Événements & expériences</strong> – Accès à des track days, rallyes, salons privés et essais exclusifs.</li>
                <li><strong>Financement personnalisé</strong> – Solutions sur mesure avec options de leasing et achat flexible.</li>
                <li><strong>Assistance & garantie</strong> – Service premium 24/7 en France et à l’étranger pour rouler l’esprit tranquille.</li>
            </ul>
        </section>

        <section id="pourquoi-nous">

            <h2>Pourquoi choisir EVA Concession ?</h2>
            <ul class="arguments">
                <li><strong>Expertise 100% BMW M</strong></li>
                <li><strong>Personnalisation haut de gamme</strong></li>
                <li><strong>Atelier certifié BMW M</strong></li>
                <li><strong>Pièces et accessoires officiels</strong></li>
                <li><strong>Livraison rapide partout en France</strong></li>
                <li><strong>Service client premium</strong></li>
            </ul>
        </section>

        <section id="temoignages">

            <h2>Ce que nos clients disent</h2>
            <div class="avis">
                <blockquote>"Service parfait, ma M4 est unique. Merci !”<br>- Maxime P. (Perpignan)</blockquote>
                <blockquote>"Livraison rapide, et tuning au top.”<br>- Sarah D. (Lille)</blockquote>
                <blockquote>"Une équipe passionnée, ma M2 Compétition ronronne parfaitement !”<br>- Vincent A. (Strasbourg)</blockquote>
                <blockquote>"Service parfait, secrétaire parfaite 😜 !!!”<br>- André F. (Homécourt)</blockquote>
            </div>
        </section>

        <section id="contact-rapide">
            <h2>Vous avez un projet ?</h2>
            <p>Contactez-nous pour une consultation gratuite et découvrez comment nous pouvons transformer votre rêve en réalité.</p>
            <a href="#" class="btn-contact">Parlez-nous de votre BMW</a>
        </section>

        <form action="/php/traitement-projet.php" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <div class="projets">
                <h2>Décrivez-nous votre projet</h2>
                <span class="close">&times;</span>
                <textarea name="explication" id="texte" required></textarea>
                <input type="email" id="mail" name="mail" placeholder="Inscrivez votre email" required />
                <button type="submit" class="btn-projet" name="ajout_projet">Envoyer</button>
            </div>
        </form>

    </main>

    <div id="admin-modal" class="modal-admin">
        <div class="admin-content">
            <span class="close-admin">&times;</span>

            <!-- Formulaire Connexion -->
            <form id="admin-login" method="post" action="/php/login.php">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="form-group">
                    <label for="nom">Identifiant</label>
                    <input type="text" name="nom" required />
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" required />
                </div>
                <button type="submit">Connexion</button>
            </form>

        </div>
    </div>
    <footer id="footer">
        <div class="footer-contenu">
            <p>© 2025 EVA Concession — Site fictif réalisé dans le cadre d'une formation, non affilié à BMW</p>
            <p>
                <a href="/php/mention.php">Mentions légales</a> |
                <a href="/php/politique.php">Politique de confidentialité</a> |
                <a href="#" id="open-admin">Espace Admin</a>
            </p>
            <p>
                <a href="mailto:contact@evaconcession.fr">contact@evaconcession.fr</a> —
                📞 03 87 00 00 00
            </p>
            <div class="social">
                <a href="#"><img src="/img/facebook.png" alt="Facebook" /></a>
                <a href="#"><img src="/img/instagram.png" alt="Instagram" /></a>
                <a href="#"><img src="/img/youtube.png" alt="YouTube" /></a>
            </div>
        </div>
    </footer>
    <script src="/js/bmw.js?v=3"></script>
    <script src="/js/nav.js?v=2"></script>
</body>

</html>