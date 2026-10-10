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
    const panoramique = document.querySelector(".panoramique");
    const bandeau = document.querySelector(".panoramique-bandeau");
    const images = Array.from(bandeau.querySelectorAll("img"));
    const nbImages = images.length;

    // On clone les images 2 fois pour former une grande boucle continue
    images.forEach((img) => bandeau.appendChild(img.cloneNode(true)));
    images.forEach((img) => bandeau.appendChild(img.cloneNode(true)));
    const toutes = Array.from(bandeau.querySelectorAll("img"));

    const vitesse = 90; // pixels par seconde (même vitesse sur tous les écrans)
    let offset = 0;
    let dernierTemps = null;
    let visible = true;

    // On mesure UNE fois (et quand l'écran change de taille) la place de chaque image.
    // Ensuite, à chaque image de l'animation, on calcule sans rien remesurer :
    // c'est ce qui rend le carrousel fluide sur téléphone.
    let largeurSerie = 0;
    let departBandeau = 0;
    let centres = [];
    function mesurer() {
        bandeau.style.transform = "translateX(0px)";
        departBandeau = bandeau.getBoundingClientRect().left;
        // centre de chaque image, compté depuis le début du bandeau
        centres = toutes.map((img) => {
            const r = img.getBoundingClientRect();
            return r.left + r.width / 2 - departBandeau;
        });
        largeurSerie = centres[nbImages] - centres[0];
        bandeau.style.transform = `translateX(${-offset}px)`;
    }
    mesurer();
    window.addEventListener("resize", mesurer);
    window.addEventListener("load", mesurer); // une fois les images chargées

    function updateStyle() {
        const centreEcran = window.innerWidth / 2;
        toutes.forEach((img, i) => {
            const dist = Math.abs(departBandeau + centres[i] - offset - centreEcran);
            if (dist > window.innerWidth) return; // image hors de l'écran : on ne la touche pas

            const scale = Math.max(0.6, 1 - dist / 1000);
            const arc = Math.min(40, dist / 12);
            const opacity = Math.max(0.3, 1 - dist / 700);

            img.style.transform = `translateY(${arc}px) scale(${scale})`;
            img.style.opacity = opacity;
        });
    }

    function loop(temps) {
        if (visible) {
            if (dernierTemps !== null) {
                offset += (vitesse * Math.min(temps - dernierTemps, 100)) / 1000;
            }
            // Quand une série entière est passée, on recule d'exactement une série :
            // les images sont identiques, donc le saut est invisible.
            if (largeurSerie > 0 && offset >= largeurSerie) {
                offset -= largeurSerie;
            }
            bandeau.style.transform = `translateX(${-offset}px)`;
            updateStyle();
        }
        dernierTemps = temps;
        requestAnimationFrame(loop);
    }

    // Le carrousel se met en pause quand il n'est pas à l'écran (moins de travail pour le téléphone)
    new IntersectionObserver((entrees) => {
        visible = entrees[0].isIntersecting;
    }).observe(panoramique);

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
