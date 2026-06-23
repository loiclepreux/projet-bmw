document.addEventListener("DOMContentLoaded", () => {

    // Fonction générique de suppression avec fetch
    function supprimer(url, id, carte) {
        fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                carte.remove();
            } else {
                alert("Erreur lors de la suppression !");
            }
        })
        .catch(err => console.error(err));
    }

    // Customisations
    document.querySelectorAll(".btn-supprimer[data-type='custom']").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            if (confirm("Confirmer la suppression ?")) {
                const id = btn.dataset.id;
                const carte = btn.closest('.carte');
                supprimer("suppression_custom.php", id, carte);
            }
        });
    });

    // Reservations
    document.querySelectorAll(".btn-supprimer[data-type='reservation']").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            if (confirm("Confirmer la suppression ?")) {
                const id = btn.dataset.id;
                const carte = btn.closest('.carte');
                supprimer("suppression_reservation.php", id, carte);
            }
        });
    });

    // Essais
    document.querySelectorAll(".btn-supprimer[data-type='essai']").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            if (confirm("Confirmer la suppression ?")) {
                const id = btn.dataset.id;
                const carte = btn.closest('.carte');
                supprimer("suppression_essai.php", id, carte);
            }
        });
    });

    // Projets
    document.querySelectorAll(".btn-supprimer[data-type='projet']").forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();
            if (confirm("Confirmer la suppression ?")) {
                const id = btn.dataset.id;
                const carte = btn.closest('.carte');
                supprimer("suppression_projet.php", id, carte);
            }
        });
    });

      // AJOUT VEHICULE
    document.querySelector('.ajouter_vehicule form').addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('action', 'ajout_vehicule');

        fetch('admin-actions.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Véhicule ajouté !");
                    e.target.reset();
                } else {
                    alert("Erreur lors de l'ajout.");
                }
            });
    });

    // MODIFIER VEHICULE
    document.querySelector('.modifier_vehicule form').addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(e.target);
        formData.append('action', 'modifier_vehicule');

        fetch('admin-actions.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Véhicule modifié !");
                    e.target.reset();
                } else {
                    alert("Erreur lors de la modification.");
                }
            });
    });

    // SUPPRIMER VEHICULE
    document.querySelector('.supprimer_vehicule form').addEventListener('submit', e => {
        e.preventDefault();
        if (!confirm("Confirmer la suppression ?")) return;

        const formData = new FormData(e.target);
        formData.append('action', 'supprimer_vehicule');

        fetch('admin-actions.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("Véhicule supprimé !");
                    e.target.reset();
                } else {
                    alert("Erreur lors de la suppression.");
                }
            });
    });

    // AJOUT EMPLOYE
document.querySelector('.ajouter_employe form').addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'ajout_employe');

    fetch('admin-actions.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Employé ajouté !");
                e.target.reset();
            } else {
                alert("Erreur lors de l'ajout.");
            }
        });
});

// MODIFIER EMPLOYE
document.querySelector('.modifier_employe form').addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'modifier_employe');

    fetch('admin-actions.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Employé modifié !");
                e.target.reset();
            } else {
                alert("Erreur lors de la modification.");
            }
        });
});

// SUPPRIMER EMPLOYE
document.querySelector('.supprimer_employe form').addEventListener('submit', e => {
    e.preventDefault();
    if (!confirm("Confirmer la suppression ?")) return;
    const formData = new FormData(e.target);
    formData.append('action', 'supprimer_employe');

    fetch('admin-actions.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Employé supprimé !");
                e.target.reset();
            } else {
                alert("Erreur lors de la suppression.");
            }
        });
    });

    // AJOUT EVENEMENT
document.querySelector('.ajouter_evenement form').addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'ajout_evenement');

    fetch('admin-actions.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Événement ajouté !");
                e.target.reset();
            } else {
                alert("Erreur lors de l'ajout.");
            }
        });
});

// MODIFIER EVENEMENT
document.querySelector('.modifier_evenment form').addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('action', 'modifier_evenement');

    fetch('admin-actions.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Événement modifié !");
                e.target.reset();
            } else {
                alert("Erreur lors de la modification.");
            }
        });
});

// SUPPRIMER EVENEMENT
document.querySelector('.supprimer_evenement form').addEventListener('submit', e => {
    e.preventDefault();
    if (!confirm("Confirmer la suppression ?")) return;
    const formData = new FormData(e.target);
    formData.append('action', 'supprimer_evenement');

    fetch('admin-actions.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Événement supprimé !");
                e.target.reset();
            } else {
                alert("Erreur lors de la suppression.");
            }
        });
    });
});