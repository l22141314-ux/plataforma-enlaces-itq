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

    // Validación del formulario de agregar/editar enlace
    const formEnlace = document.querySelector('form[method="POST"]');
    if (formEnlace) {
        formEnlace.addEventListener('submit', (e) => {
            const titulo = formEnlace.querySelector('input[name="titulo"]');
            const url = formEnlace.querySelector('input[name="url"]');
            const categoria = formEnlace.querySelector('select[name="categoria_id"]');

            let errores = [];

            if (titulo && titulo.value.trim() === '') {
                errores.push('El título es obligatorio.');
                titulo.style.borderColor = '#c0392b';
            } else if (titulo) {
                titulo.style.borderColor = '#ccc';
            }

            if (url && url.value.trim() === '') {
                errores.push('La URL es obligatoria.');
                url.style.borderColor = '#c0392b';
            } else if (url) {
                const patron = /^https?:\/\/.+\..+/;
                if (!patron.test(url.value.trim())) {
                    errores.push('La URL debe comenzar con http:// o https:// y tener un dominio válido.');
                    url.style.borderColor = '#c0392b';
                } else {
                    url.style.borderColor = '#ccc';
                }
            }

            if (categoria && categoria.value === '') {
                errores.push('Debes seleccionar una categoría.');
                categoria.style.borderColor = '#c0392b';
            } else if (categoria) {
                categoria.style.borderColor = '#ccc';
            }

            if (errores.length > 0) {
                e.preventDefault();
                alert('Corrige los siguientes errores:\n\n- ' + errores.join('\n- '));
            }
        });
    }

    // Confirmación antes de eliminar (refuerzo del onclick)
    document.querySelectorAll('a[href*="eliminar.php"]').forEach(enlace => {
        enlace.addEventListener('click', (e) => {
            if (!confirm('¿Seguro que deseas eliminar este enlace? Esta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });
});