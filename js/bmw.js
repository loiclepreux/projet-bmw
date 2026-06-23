// fonction d'un son qui se lance en cliquant sur l'image.

function jouerSonM2(){
    let audio = document.getElementById('son-m2');
    audio.volume = 1; // on met le son au maximum
    audio.play(); // on lance le son
}
function jouerSonM4(){
    let audio = document.getElementById('son-m4');
    audio.volume = 1; // on met le son au maximum
    audio.play(); // on lance le son
}

// fonction d'un bouton qui affiche le formulaire de projet.
const btnProjet = document.querySelector('.btn-contact');
const projets = document.querySelector('.projets');
const btnClose = document.querySelector('.close');

btnProjet.addEventListener("click" , () =>{
    projets.style.display = "flex";
})
// fonction d'un bouton qui ferme le formulaire de projet.
btnClose.addEventListener("click" , () =>{
    projets.style.display = "none";
})


// fonction d'un carousel qui défile.
document.addEventListener("DOMContentLoaded", () => {
  const bandeau = document.querySelector(".panoramique-bandeau");
  const images = Array.from(bandeau.querySelectorAll("img"));
  const itemWidth = 460; // image width + gap (450 + 10)

  // On clone les images 2 fois pour former une grande boucle continue
  images.forEach(img => bandeau.appendChild(img.cloneNode(true)));
  images.forEach(img => bandeau.appendChild(img.cloneNode(true)));

  const totalWidth = itemWidth * images.length * 3;
  let offset = 0;
  let frame = 0;

  function updateStyle() {
    const centerX = window.innerWidth / 2;
    bandeau.querySelectorAll("img").forEach(img => {
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

  function loop() {
    offset += 1.5;
    if (offset >= totalWidth / 3) {
      // Repositionnement discret : on revient à 1/3 du total
      offset = 0;
      bandeau.style.transform = `translateX(0px)`;
    } else {
      bandeau.style.transform = `translateX(${-offset}px)`;
    }

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
    const loginForm = document.getElementById("admin-login");
    const registerForm = document.getElementById("admin-register");
    const showLoginBtn = document.getElementById("show-login");
    const showRegisterBtn = document.getElementById("show-register");

    openBtn.addEventListener("click", e => {
        e.preventDefault();
        modal.style.display = "flex";
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", e => {
        if (e.target === modal) modal.style.display = "none";
    });

    showLoginBtn.addEventListener("click", () => {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        showLoginBtn.classList.add("active");
        showRegisterBtn.classList.remove("active");
    });

    showRegisterBtn.addEventListener("click", () => {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        showLoginBtn.classList.remove("active");
        showRegisterBtn.classList.add("active");
    });
});
