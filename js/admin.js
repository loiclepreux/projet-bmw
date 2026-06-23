document.addEventListener("DOMContentLoaded", () => {

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    function fetchJson(url, body) {
        body.append('csrf_token', csrfToken);
        body.append('isAjax', '1');
        return fetch(url, { method: 'POST', body })
            .then(res => res.json());
    }

    // ── Suppressions (customisations, réservations, essais, projets) ──────────
    document.querySelectorAll('.btn-supprimer').forEach(btn => {
        btn.addEventListener('click', () => {
            if (!confirm('Confirmer la suppression ?')) return;
            const id   = btn.dataset.id;
            const type = btn.dataset.type;
            const body = new FormData();
            body.append('id',   id);
            body.append('type', type);
            body.append('csrf_token', csrfToken);

            fetch('suppression.php', { method: 'POST', body })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btn.closest('.carte').remove();
                    } else {
                        alert('Erreur lors de la suppression : ' + (data.message ?? ''));
                    }
                })
                .catch(() => alert('Erreur réseau.'));
        });
    });

    // ── Véhicules ─────────────────────────────────────────────────────────────
    document.querySelector('.ajouter_vehicule form').addEventListener('submit', e => {
        e.preventDefault();
        fetchJson('gestion-admin.php?action=ajout&type=vehicule', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Véhicule ajouté !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    document.querySelector('.modifier_vehicule form').addEventListener('submit', e => {
        e.preventDefault();
        fetchJson('gestion-admin.php?action=modif&type=vehicule', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Véhicule modifié !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    document.querySelector('.supprimer_vehicule form').addEventListener('submit', e => {
        e.preventDefault();
        if (!confirm('Confirmer la suppression ?')) return;
        fetchJson('gestion-admin.php?action=suppr&type=vehicule', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Véhicule supprimé !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    // ── Employés ──────────────────────────────────────────────────────────────
    document.querySelector('.ajouter_employe form').addEventListener('submit', e => {
        e.preventDefault();
        fetchJson('gestion-admin.php?action=ajout&type=employe', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Employé ajouté !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    document.querySelector('.modifier_employe form').addEventListener('submit', e => {
        e.preventDefault();
        fetchJson('gestion-admin.php?action=modif&type=employe', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Employé modifié !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    document.querySelector('.supprimer_employe form').addEventListener('submit', e => {
        e.preventDefault();
        if (!confirm('Confirmer la suppression ?')) return;
        fetchJson('gestion-admin.php?action=suppr&type=employe', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Employé supprimé !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    // ── Événements ────────────────────────────────────────────────────────────
    document.querySelector('.ajouter_evenement form').addEventListener('submit', e => {
        e.preventDefault();
        fetchJson('gestion-admin.php?action=ajout&type=evenement', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Événement ajouté !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    document.querySelector('.modifier_evenment form').addEventListener('submit', e => {
        e.preventDefault();
        fetchJson('gestion-admin.php?action=modif&type=evenement', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Événement modifié !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });

    document.querySelector('.supprimer_evenement form').addEventListener('submit', e => {
        e.preventDefault();
        if (!confirm('Confirmer la suppression ?')) return;
        fetchJson('gestion-admin.php?action=suppr&type=evenement', new FormData(e.target))
            .then(data => {
                if (data.success) { alert('Événement supprimé !'); e.target.reset(); }
                else alert('Erreur : ' + (data.message ?? ''));
            });
    });
});
