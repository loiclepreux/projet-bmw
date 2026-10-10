// fonction d'un son qui se lance en cliquant sur l'image.

function jouerSonM2() {
    let audio = document.getElementById("son-m2");
    audio.volume = 1; // on met le son au maximum
    audio.play(); // on lance le son
}
function jouerSonM4() {
    let audio = document.getElementById("son-m4");
    audio.volume = 1; // on met le son au maximum
    audio.play(); // on lance le son
}

// fonction d'un bouton qui affiche le formulaire de projet.
const btnProjet = document.querySelector(".btn-contact");
const projets = document.querySelector(".projets");
const btnClose = document.querySelector(".close");

btnProjet.addEventListener("click", (e) => {
    e.preventDefault(); // sinon le lien "#" renvoie tout en haut de la page
    projets.style.display = "flex";
    projets.scrollIntoView({ behavior: "smooth", block: "center" });
    document.getElementById("texte").focus({ preventScroll: true });
});
// fonction d'un bouton qui ferme le formulaire de projet.
btnClose.addEventListener("click", () => {
    projets.style.display = "none";
});

// fonction d'un carousel qui défile.
document.addEventListener("DOMContentLoaded", () => {
    const bandeau = document.querySelector(".panoramique-bandeau");
    const images = Array.from(bandeau.querySelectorAll("img"));
    const nbImages = images.length;

    // On clone les images 2 fois pour former une grande boucle continue
    images.forEach((img) => bandeau.appendChild(img.cloneNode(true)));
    images.forEach((img) => bandeau.appendChild(img.cloneNode(true)));

    // Largeur réelle d'une série d'images (elle change selon la taille de l'écran)
    let largeurSerie = 0;
    function mesurer() {
        const toutes = bandeau.querySelectorAll("img");
        largeurSerie = toutes[nbImages].offsetLeft - toutes[0].offsetLeft;
    }
    mesurer();
    window.addEventListener("resize", mesurer);
    window.addEventListener("load", mesurer); // une fois les images chargées

    const vitesse = 90; // pixels par seconde (même vitesse sur tous les écrans)
    let offset = 0;
    let dernierTemps = null;
    let frame = 0;

    function updateStyle() {
        const centerX = window.innerWidth / 2;
        bandeau.querySelectorAll("img").forEach((img) => {
            const rect = img.getBoundingClientRect();
            const imgCenter = rect.left + rect.width / 2;
            const dist = Math.abs(centerX - imgCenter);

            const scale = Math.max(0.6, 1 - dist / 1000);
            const arc = Math.min(40, dist / 12);
            const opacity = Math.max(0.3, 1 - dist / 700);

            img.style.transform = `translateY(${arc}px) scale(${scale})`;
            img.style.opacity = opacity;
        });
    }

    function loop(temps) {
        if (dernierTemps !== null) {
            offset += (vitesse * Math.min(temps - dernierTemps, 100)) / 1000;
        }
        dernierTemps = temps;

        // Quand une série entière est passée, on recule d'exactement une série :
        // les images sont identiques, donc le saut est invisible.
        if (largeurSerie > 0 && offset >= largeurSerie) {
            offset -= largeurSerie;
        }
        bandeau.style.transform = `translateX(${-offset}px)`;

        frame++;
        if (frame % 5 === 0) updateStyle();

        requestAnimationFrame(loop);
    }

    updateStyle();
    requestAnimationFrame(loop);

    // fonction d'un modal qui s'affiche en cliquant sur le bouton admin.
    const openBtn = document.getElementById("open-admin");
    const modal = document.getElementById("admin-modal");
    const closeBtn = document.querySelector(".close-admin");

    openBtn.addEventListener("click", (e) => {
        e.preventDefault();
        modal.style.display = "flex";
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) modal.style.display = "none";
    });
});
