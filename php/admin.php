<?php
session_start();
require_once 'config.php';

$pdo = new PDO($dsn, $username, $password, $options);

// Récupération des données 
$stmt = $pdo->query("SELECT * FROM customisations ORDER BY date_enregistrement DESC");
$customisations = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM reservations ORDER BY date_enregistrement DESC");
$reservations = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM essais ORDER BY date_enregistrement DESC");
$essais = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM projets ORDER BY date_enregistrement DESC");
$projets = $stmt->fetchAll();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: bmw.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Interface Admin - EVA Concession</title>
    <link rel="stylesheet" href="../css/admin.css" />
</head>
<body>
    <header>
        <h1>Interface admin EVA Concession</h1>
    </header>

    <main>
        <h2>Gestion des véhicules</h2>
        <section id="vehicules">
            <div class="ajouter_vehicule">
            <form action="gestion_admin.php?action=ajout&type=vehicule" method="POST">
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
                    <label>Fiche technique (nom du fichier .txt ou .docx) :</label>
                    <input type="text" name="fiche_technique" required>
                </div>
                <button type="submit" class="btn">➕ Ajouter</button>
            </form>
            </div>
            
            <div class="modifier_vehicule">
            <form action="gestion_admin.php?action=modif&type=vehicule" method="POST">
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
                    <label>Nouvelle fiche technique (nouveau fichier) :</label>
                    <input type="text" name="fiche_technique">
                </div>
                <button type="submit" class="btn">✏️ Modifier</button>
            </form>
            </div>

            <div class="supprimer_vehicule">
            <form action="gestion_admin.php?action=suppr&type=vehicule" method="POST">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <div class="form-group">
                    <label>ID du véhicule à supprimer :</label>
                    <input type="number" name="id" required>
                </div>
                <button type="submit" class="btn">🗑️ Supprimer</button>
            </form>
            </div>

        </section>

        <h2>Gestion des employés</h2>
        <section id="employes"> 
            <div class="ajouter_employe">
                <form action="gestion_admin.php?action=ajout&type=employe" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="fonction">Fonction :</label>
                        <input type="text" id="fonction" name="fonction" required>
                    </div>
                    <div class="form-group">
                        <label for="concession">Concession :</label>
                        <input type="text" id="concession" name="concession" required>
                    </div>
                    <div class="form-group">
                        <label for="niveau">Niveau :</label>
                        <select id="niveau" name="niveau" required>
                            <option value="1">Direction</option>
                            <option value="2">Responsables commerciaux</option>
                            <option value="3">Personnel technique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo (nom du fichier, ex: homme1.png) :</label>
                        <input type="text" id="photo" name="photo" required>
                    </div>
                    <button type="submit" class="btn">➕ Ajouter</button>
                </form>
            </div>

            <div class="modifier_employe">
                <form action="gestion_admin.php?action=modif&type=employe" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label for="id">ID de l'employé à modifier :</label>
                        <input type="number" id="id" name="id" required>
                    </div>

                    <div class="form-group">
                        <label for="champ">Champ à modifier :</label>
                        <select id="champ" name="champ" required>
                            <option value="prenom">Prénom</option>
                            <option value="nom">Nom</option>
                            <option value="fonction">Fonction</option>
                            <option value="concession">Concession</option>
                            <option value="niveau">Niveau</option>
                            <option value="photo">Photo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="valeur">Nouvelle valeur :</label>
                        <input type="text" id="valeur" name="valeur" required>
                    </div>

                    <button type="submit" class="btn">✏️ Modifier</button>
                </form>
            </div>

            <div class="supprimer_employe">
                <form action="gestion_admin.php?action=suppr&type=employe" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label for="id">ID de l'employé à supprimer :</label>
                        <input type="number" id="id" name="id" required>
                    </div>
                    <button type="submit" class="btn">🗑️ Supprimer</button>
                </form>
            </div>
        </section>

        <h2>Gestion des évenements</h2>
        <section id="evenement">
            <div class="ajouter_evenement">
                <form action="gestion_admin.php?action=ajout&type=evenement" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label for="titre">Titre de l'événement :</label>
                        <input type="text" id="titre" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date de l'événement :</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="lieu">Lieu :</label>
                        <input type="text" id="lieu" name="lieu" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description :</label>
                        <textarea id="description" name="description" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn">➕ Ajouter l'événement</button>
                </form>
            </div>

            <div class="modifier_evenment">
                <form action="gestion_admin.php?action=modif&type=evenement" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label for="id">ID de l'événement à modifier :</label>
                        <input type="number" id="id" name="id" required>
                    </div>
                    <div class="form-group">
                        <label for="champ">Champ à modifier :</label>
                        <select id="champ" name="champ" required>
                            <option value="titre">Titre</option>
                            <option value="date">Date</option>
                            <option value="lieu">Lieu</option>
                            <option value="description">Description</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="valeur">Nouvelle valeur :</label>
                        <input type="text" id="valeur" name="valeur" required>
                    </div>
                    <button type="submit" class="btn">✏️ Modifier</button>
                </form>
            </div>

            <div class="supprimer_evenement">
                <form action="gestion_admin.php?action=suppr&type=evenement" method="post">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <div class="form-group">
                        <label for="id">ID de l'événement à supprimer :</label>
                        <input type="number" id="id" name="id" required>
                    </div>
                    <button type="submit" class="btn">🗑️ Supprimer l'événement</button>
                </form>
            </div>
        </section>

        <h2>Commandes & Réservations</h2>
        <section id="customisation">
    <div class="liste_custom">
        <?php foreach ($customisations as $c): ?>
            <div class="carte" id="custom-<?= $c['id'] ?>">
                <h3>Customisation</h3>
                <p><strong>nom :</strong> <?= htmlspecialchars($c['nom']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($c['email']) ?></p>
                <p><strong>Téléphone :</strong> <?= htmlspecialchars($c['telephone']) ?></p>
                <hr>
                <p><strong>Modéle :</strong> <?= htmlspecialchars($c['modele']) ?></p>
                <p><strong>Couleur :</strong> <?= htmlspecialchars($c['couleur']) ?></p>
                <p><strong>Jantes :</strong> <?= htmlspecialchars($c['jantes']) ?></p>
                <p><strong>Sellerie :</strong> <?= htmlspecialchars($c['sellerie']) ?></p>
                <hr>
                <p><strong>Préparation moteur :</strong> Stage 1 : <?= htmlspecialchars($c['stage1']) ?> | Stage 2 : <?= htmlspecialchars($c['stage2']) ?></p>
                <p><strong>Kit carrosserie :</strong> <?= htmlspecialchars($c['kit']) ?></p>
                <p><strong>Éléments :</strong> <?= htmlspecialchars($c['elements']) ?></p>
                <hr>
                <p><strong>Peinture perso :</strong> Finition <?= htmlspecialchars($c['finition']) ?>, Motif <?= htmlspecialchars($c['motif']) ?></p>
                <p><strong>Sellerie extrême :</strong> <?= htmlspecialchars($c['sellerie_extreme']) ?></p>
                <p><strong>Volant :</strong> <?= htmlspecialchars($c['volant']) ?></p>
                <p><strong>Néons :</strong> <?= htmlspecialchars($c['neons']) ?> | <strong>Diffuseur :</strong> <?= htmlspecialchars($c['diffuseur']) ?></p>
                <p class="date_enregistrement">Enregistré le : <?= htmlspecialchars($c['date_enregistrement']) ?></p>

                <button type="button" class="btn-supprimer" data-id="<?= $c['id'] ?>" data-type="custom">❌ Supprimer</button>
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
                <p><strong>Modéle :</strong> <?= htmlspecialchars($r['modele']) ?></p>
                <p><strong>Couleur :</strong> <?= htmlspecialchars($r['couleur']) ?></p>
                <p><strong>Options :</strong> <?= nl2br(htmlspecialchars($r['options'])) ?></p>
                <p class="date_enregistrement">Réservé le : <?= htmlspecialchars($r['date_enregistrement']) ?></p>

                <button type="button" class="btn-supprimer" data-id="<?= $r['id'] ?>" data-type="reservation">❌ Supprimer</button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="reservations">
    <div class="liste_reservation">
        <?php foreach ($essais as $e): ?>
            <div class="carte" id="essai-<?= $e['id'] ?>">
                <h3>Reservation</h3>
                <p><strong>Nom :</strong> <?= htmlspecialchars($e['nom']) ?></p>
                <p><strong>Modéle :</strong> <?= htmlspecialchars($e['modele']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($e['email']) ?></p>
                <p><strong>Date :</strong> <?= htmlspecialchars($e['date_essai']) ?> - Heure : <?= htmlspecialchars($e['heure_essai']) ?></p>
                <p class="date_enregistrement">Enregistré le : <?= htmlspecialchars($e['date_enregistrement']) ?></p>

                <button type="button" class="btn-supprimer" data-id="<?= $e['id'] ?>" data-type="essai">❌ Supprimer</button>
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

                <button type="button" class="btn-supprimer" data-id="<?= $p['id'] ?>" data-type="projet">❌ Supprimer</button>
            </div>
        <?php endforeach; ?>
    </div>
</section>
    </main>

    <footer>
        <form method="post" style="display:inline;">
        <button type="submit" name="logout" class="btn-deconnexion">Déconnexion</button>
        </form>
    </footer>
    <script src="../js/admin.js"></script>
</body>
</html>
