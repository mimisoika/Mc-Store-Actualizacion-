document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".btn-remove-fav").forEach(btn => {
        btn.addEventListener("click", function () {

            let productId = this.getAttribute("data-id");
            let card = this.closest(".col-lg-4"); // la tarjeta a eliminar visualmente

            fetch("functions/quitar_favoritos.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + productId
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    card.remove(); // elimina visualmente la tarjeta sin recargar
                }
            });
        });
    });

});

