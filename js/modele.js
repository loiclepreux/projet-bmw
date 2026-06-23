// fonction d'une modale qui s'ouvre au clic sur une image et affiche les détails de la voiture.

document.addEventListener("DOMContentLoaded", () => {
    const modaleFichier = document.getElementById("modale-fichier");
    const contenuFichier = document.getElementById("contenu-fichier");
    const closeFichier = document.querySelector(".close-fichier");
    const imgFichier = document.getElementById("img-fichier");

function afficherFichier(fichier, imageSrc) {
    fetch(`../txt/${fichier}`)
        .then(response => {
        if (!response.ok) throw new Error("Fichier introuvable");
        return response.text();
    })
        .then(texte => {
        contenuFichier.textContent = texte;
        imgFichier.src = imageSrc;
        modaleFichier.style.display = "flex";
    })
        .catch(error => {
        contenuFichier.textContent = "Erreur : " + error.message;
        imgFichier.src = "";
        modaleFichier.style.display = "flex";
    });
}

    closeFichier.addEventListener("click", () => modaleFichier.style.display = "none");

    window.addEventListener("click", e => {
    if (e.target === modaleFichier) modaleFichier.style.display = "none";
});

  // Clic sur les boutons
document.querySelectorAll(".voir-fiche-technique").forEach(btn => {
    btn.addEventListener("click", () => {
        const fichier = btn.dataset.fichier;
        const image = btn.dataset.image;
        afficherFichier(fichier, image);
    });
});

    // FORMULAIRES
    const formResa = document.querySelector("#form-reservation");
    const formEssai = document.querySelector("#form-essai");

    if (formResa) {
        formResa.addEventListener("submit", e => {
            if (!confirm("Confirmer votre réservation ?")) e.preventDefault();
        });
    }

    if (formEssai) {
        formEssai.addEventListener("submit", e => {
            if (!confirm("Confirmer votre essai ?")) e.preventDefault();
        });
    }
});