<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['user'])) {
    header('Location: /index.php');
    exit;
}

// Session timeout 30 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1800) {
    session_destroy();
    header('Location: /index.php?erreur=timeout');
    exit;
}
$_SESSION['last_activity'] = time();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: /index.php');
    exit;
}

$customisations = $pdo->query("SELECT * FROM customisations ORDER BY date_enregistrement DESC")->fetchAll();
$reservations   = $pdo->query("SELECT * FROM reservations ORDER BY date_enregistrement DESC")->fetchAll();
$essais         = $pdo->query("SELECT * FROM essais ORDER BY date_enregistrement DESC")->fetchAll();
$projets        = $pdo->query("SELECT * FROM projets ORDER BY date_enregistrement DESC")->fetchAll();
$vehiculesRef   = $pdo->query("SELECT id, marque, nom FROM vehicules ORDER BY id")->fetchAll();
$employesRef    = $pdo->query("SELECT id, prenom, nom, fonction FROM employes ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Interface Admin - EVA Concession</title>
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <link rel="stylesheet" href="../css/admin.css" />
    <link rel="stylesheet" href="../css/responsive.css" />
</head>
<body>
    <header>
        <h1>Interface admin EVA Concession</h1>
    </header>

    <main>
        <h2>Gestion des véhicules</h2>
        <section id="ref-vehicules" class="ref-list">
            <h3>Véhicules existants (référence IDs)</h3>
            <table>
                <tr><th>ID</th><th>Marque</th><th>Modèle</th></tr>
                <?php foreach ($vehiculesRef as $v): ?>
                    <tr>
                        <td><?= $v['id'] ?></td>
                        <td><?= htmlspecialchars($v['marque']) ?></td>
                        <td><?= htmlspecialchars($v['nom']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
        <section id="vehicules">
            <div class="ajouter_vehicule">
            <form action="gestion-admin.php?action=ajout&type=vehicule" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="form-group">
                    <label>Marque :</label>
                    <input type="text" name="marque" required>
                </div>
                <div class="form-group">
                    <label>Nom du modèle :</label>
                    <input type="text" name="nom" required>
                </div>
                <div class="form-group">
                    <label>Image (nom du fichier) :</label>
                    <input type="text" name="image" required>
                </div>
                <div class="form-group">
                    <label>Options :</label>
                    <textarea name="options" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Fiche technique (nom du fichier .txt) :</label>
                    <input type="text" name="fiche_technique" required>
                </div>
                <button type="submit" class="btn">Ajouter</button>
            </form>
            </div>

            <div class="modifier_vehicule">
            <form action="gestion-admin.php?action=modif&type=vehicule" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="form-group">
                    <label>ID du véhicule à modifier :</label>
                    <input type="number" name="id" required>
                </div>
                <div class="form-group">
                    <label>Nouvelles options :</label>
                    <textarea name="options" rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Nouvelle fiche technique :</label>
                    <input type="text" name="fiche_technique">
                </div>
                <button type="submit" class="btn">Modifier</button>
            </form>
            </div>

            <div class="supprimer_vehicule">
            <form action="gestion-admin.php?action=suppr&type=vehicule" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="form-group">
                    <label>ID du véhicule à supprimer :</label>
                    <input type="number" name="id" required>
                </div>
                <button type="submit" class="btn">Supprimer</button>
            </form>
            </div>
        </section>

        <h2>Gestion des employés</h2>
        <section id="ref-employes" class="ref-list">
            <h3>Employés existants (référence IDs)</h3>
            <table>
                <tr><th>ID</th><th>Prénom</th><th>Nom</th><th>Fonction</th></tr>
                <?php foreach ($employesRef as $e): ?>
                    <tr>
                        <td><?= $e['id'] ?></td>
                        <td><?= htmlspecialchars($e['prenom']) ?></td>
                        <td><?= htmlspecialchars($e['nom']) ?></td>
                        <td><?= htmlspecialchars($e['fonction']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>
        <section id="employes">
            <div class="ajouter_employe">
                <form action="gestion-admin.php?action=ajout&type=employe" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label>Prénom :</label>
                        <input type="text" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label>Nom :</label>
                        <input type="text" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label>Fonction :</label>
                        <input type="text" name="fonction" required>
                    </div>
                    <div class="form-group">
                        <label>Concession :</label>
                        <input type="text" name="concession" required>
                    </div>
                    <div class="form-group">
                        <label>Niveau :</label>
                        <select name="niveau" required>
                            <option value="1">Direction</option>
                            <option value="2">Responsables commerciaux</option>
                            <option value="3">Personnel technique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Photo (nom du fichier) :</label>
                        <input type="text" name="photo" required>
                    </div>
                    <div class="form-group">
                        <label>Mot de passe :</label>
                        <input type="password" name="password" placeholder="Laisser vide si non-admin">
                    </div>
                    <button type="submit" class="btn">Ajouter</button>
                </form>
            </div>

            <div class="modifier_employe">
                <form action="gestion-admin.php?action=modif&type=employe" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label>ID de l'employé à modifier :</label>
                        <input type="number" name="id" required>
                    </div>
                    <div class="form-group">
                        <label>Champ à modifier :</label>
                        <select name="champ" required>
                            <option value="prenom">Prénom</option>
                            <option value="nom">Nom</option>
                            <option value="fonction">Fonction</option>
                            <option value="concession">Concession</option>
                            <option value="niveau">Niveau</option>
                            <option value="photo">Photo</option>
                            <option value="password">Mot de passe</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nouvelle valeur :</label>
                        <input type="text" name="valeur" required>
                    </div>
                    <button type="submit" class="btn">Modifier</button>
                </form>
            </div>

            <div class="supprimer_employe">
                <form action="gestion-admin.php?action=suppr&type=employe" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label>ID de l'employé à supprimer :</label>
                        <input type="number" name="id" required>
                    </div>
                    <button type="submit" class="btn">Supprimer</button>
                </form>
            </div>
        </section>

        <h2>Gestion des événements</h2>
        <section id="evenement">
            <div class="ajouter_evenement">
                <form action="gestion-admin.php?action=ajout&type=evenement" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label>Titre :</label>
                        <input type="text" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label>Date :</label>
                        <input type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Lieu :</label>
                        <input type="text" name="lieu" required>
                    </div>
                    <div class="form-group">
                        <label>Description :</label>
                        <textarea name="description" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>URL vidéo YouTube (embed) :</label>
                        <input type="text" name="video" placeholder="https://www.youtube.com/embed/...">
                    </div>
                    <button type="submit" class="btn">Ajouter l'événement</button>
                </form>
            </div>

            <div class="modifier_evenment">
                <form action="gestion-admin.php?action=modif&type=evenement" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label>ID de l'événement à modifier :</label>
                        <input type="number" name="id" required>
                    </div>
                    <div class="form-group">
                        <label>Champ à modifier :</label>
                        <select name="champ" required>
                            <option value="titre">Titre</option>
                            <option value="date">Date</option>
                            <option value="lieu">Lieu</option>
                            <option value="description">Description</option>
                            <option value="video">Vidéo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nouvelle valeur :</label>
                        <input type="text" name="valeur" required>
                    </div>
                    <button type="submit" class="btn">Modifier</button>
                </form>
            </div>

            <div class="supprimer_evenement">
                <form action="gestion-admin.php?action=suppr&type=evenement" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label>ID de l'événement à supprimer :</label>
                        <input type="number" name="id" required>
                    </div>
                    <button type="submit" class="btn">Supprimer l'événement</button>
                </form>
            </div>
        </section>

        <h2>Commandes & Réservations</h2>
        <section id="customisation">
            <div class="liste_custom">
                <?php foreach ($customisations as $c): ?>
                    <div class="carte" id="custom-<?= $c['id'] ?>">
                        <h3>Customisation</h3>
                        <p><strong>Nom :</strong> <?= htmlspecialchars($c['nom']) ?></p>
                        <p><strong>Email :</strong> <?= htmlspecialchars($c['email']) ?></p>
                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($c['telephone']) ?></p>
                        <hr>
                        <p><strong>Modèle :</strong> <?= htmlspecialchars($c['modele']) ?></p>
                        <p><strong>Couleur :</strong> <?= htmlspecialchars($c['couleur']) ?></p>
                        <p><strong>Jantes :</strong> <?= htmlspecialchars($c['jantes']) ?></p>
                        <p><strong>Sellerie :</strong> <?= htmlspecialchars($c['sellerie']) ?></p>
                        <hr>
                        <p><strong>Moteur :</strong> Stage 1 : <?= htmlspecialchars($c['stage1']) ?> | Stage 2 : <?= htmlspecialchars($c['stage2']) ?></p>
                        <p><strong>Kit carrosserie :</strong> <?= htmlspecialchars($c['kit']) ?></p>
                        <p><strong>Éléments :</strong> <?= htmlspecialchars($c['elements']) ?></p>
                        <hr>
                        <p><strong>Peinture :</strong> Finition <?= htmlspecialchars($c['finition']) ?>, Motif <?= htmlspecialchars($c['motif']) ?></p>
                        <p><strong>Sellerie extrême :</strong> <?= htmlspecialchars($c['sellerie_extreme']) ?></p>
                        <p><strong>Volant :</strong> <?= htmlspecialchars($c['volant']) ?></p>
                        <p><strong>Néons :</strong> <?= htmlspecialchars($c['neons']) ?> | <strong>Diffuseur :</strong> <?= htmlspecialchars($c['diffuseur']) ?></p>
                        <p class="date_enregistrement">Enregistré le : <?= htmlspecialchars($c['date_enregistrement']) ?></p>
                        <button type="button" class="btn-supprimer" data-id="<?= $c['id'] ?>" data-type="custom">Supprimer</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="commandes">
            <div class="liste_commande">
                <?php foreach ($reservations as $r): ?>
                    <div class="carte" id="reservation-<?= $r['id'] ?>">
                        <h3>Commande</h3>
                        <p><strong>Nom :</strong> <?= htmlspecialchars($r['nom']) ?></p>
                        <p><strong>Email :</strong> <?= htmlspecialchars($r['email']) ?></p>
                        <p><strong>Téléphone :</strong> <?= htmlspecialchars($r['telephone']) ?></p>
                        <p><strong>Modèle :</strong> <?= htmlspecialchars($r['modele']) ?></p>
                        <p><strong>Couleur :</strong> <?= htmlspecialchars($r['couleur']) ?></p>
                        <p><strong>Options :</strong> <?= nl2br(htmlspecialchars($r['options'])) ?></p>
                        <p><strong>Date souhaitée :</strong> <?= htmlspecialchars($r['date_reservation']) ?></p>
                        <p class="date_enregistrement">Réservé le : <?= htmlspecialchars($r['date_enregistrement']) ?></p>
                        <button type="button" class="btn-supprimer" data-id="<?= $r['id'] ?>" data-type="reservation">Supprimer</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="reservations">
            <div class="liste_reservation">
                <?php foreach ($essais as $e): ?>
                    <div class="carte" id="essai-<?= $e['id'] ?>">
                        <h3>Essai</h3>
                        <p><strong>Nom :</strong> <?= htmlspecialchars($e['nom']) ?></p>
                        <p><strong>Email :</strong> <?= htmlspecialchars($e['email']) ?></p>
                        <p><strong>Modèle :</strong> <?= htmlspecialchars($e['modele']) ?></p>
                        <p><strong>Date :</strong> <?= htmlspecialchars($e['date_essai']) ?> à <?= htmlspecialchars($e['heure_essai']) ?></p>
                        <p class="date_enregistrement">Enregistré le : <?= htmlspecialchars($e['date_enregistrement']) ?></p>
                        <button type="button" class="btn-supprimer" data-id="<?= $e['id'] ?>" data-type="essai">Supprimer</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="projets">
            <div class="liste_projet">
                <?php foreach ($projets as $p): ?>
                    <div class="carte" id="projet-<?= $p['id'] ?>">
                        <h3>Projet</h3>
                        <p><strong>Email :</strong> <?= htmlspecialchars($p['email']) ?></p>
                        <p><strong>Projet :</strong> <?= nl2br(htmlspecialchars($p['explication'])) ?></p>
                        <p class="date_enregistrement">Soumis le : <?= htmlspecialchars($p['date_enregistrement']) ?></p>
                        <button type="button" class="btn-supprimer" data-id="<?= $p['id'] ?>" data-type="projet">Supprimer</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <form method="post" style="display:inline;">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
            <button type="submit" name="logout" class="btn-deconnexion">Déconnexion</button>
        </form>
    </footer>
    <script src="../js/admin.js"></script>
</body>
</html>
