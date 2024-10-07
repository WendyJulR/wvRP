document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("popup");
    const openPopup = document.getElementById("open-popup");
    const closePopup = document.getElementById("close-popup");

    // Abrir el popup al cargar la página después de 2 segundos
    setTimeout(() => {
        popup.style.display = "flex";
    }, 2000);

    // Abrir el popup al hacer clic en el botón
    openPopup.addEventListener("click", function () {
        popup.style.display = "flex";
    });

    // Cerrar el popup al hacer clic en el botón de cerrar
    closePopup.addEventListener("click", function () {
        popup.style.display = "none";
    });

    // Cerrar el popup al hacer clic fuera del contenido del popup
    window.addEventListener("click", function (event) {
        if (event.target === popup) {
            popup.style.display = "none";
        }
    });
});
