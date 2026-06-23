document.addEventListener('DOMContentLoaded', () => {
    const navBar = document.getElementById('nav-bar');
    const onglet = document.getElementById('onglet');
    if (!navBar || !onglet) return;

    const btn = document.createElement('button');
    btn.className = 'hamburger';
    btn.setAttribute('aria-label', 'Menu');
    btn.innerHTML = '&#9776;';
    navBar.appendChild(btn);

    btn.addEventListener('click', () => {
        const open = onglet.classList.toggle('nav-open');
        btn.innerHTML = open ? '&#10005;' : '&#9776;';
    });

    onglet.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            onglet.classList.remove('nav-open');
            btn.innerHTML = '&#9776;';
        });
    });
});
