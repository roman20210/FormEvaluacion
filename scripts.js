document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("registroForm");
    const responseMessage = document.getElementById("responseMessage");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        if (form.checkValidity() === false) {
            event.stopPropagation();
            form.classList.add("was-validated");
        } else {
            const formData = new FormData(form);

            // Enviar los datos al servidor usando fetch
            fetch("register.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                responseMessage.innerHTML = data;
                responseMessage.style.color = "green";
                form.reset();
                form.classList.remove("was-validated");
            })
            .catch(error => {
                responseMessage.innerHTML = "Ocurrió un error al enviar el formulario.";
                responseMessage.style.color = "red";
            });
        }
    });
});
