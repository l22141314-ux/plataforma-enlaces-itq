// assets/js/main.js
document.addEventListener('DOMContentLoaded', () => {
    console.log('Plataforma de Enlaces ITQ cargada correctamente.');

    // Scroll suave para los enlaces del menú
    document.querySelectorAll('.nav a[href^="#"]').forEach(enlace => {
        enlace.addEventListener('click', (e) => {
            e.preventDefault();
            const destino = document.querySelector(enlace.getAttribute('href'));
            if (destino) {
                destino.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});