document.getElementById("registerForm")?.addEventListener("submit", async (event) => {
    event.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
    const passwordConfirmation = document.getElementById("password_confirmation").value;

    const errorMessage = document.getElementById("error-message");
    errorMessage.style.display = "none";

    if (password !== passwordConfirmation) {
        errorMessage.style.display = "block";
        errorMessage.textContent = "As senhas não coincidem!";
        return;
    }

    try {
        const response = await fetch(`${localStorage.getItem("API_URL")}/auth/register`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                name,
                email,
                password,
                password_confirmation: passwordConfirmation
            })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message);
        }

        alert("Usuário registrado com sucesso!");
        window.location.href = "login.html";
    } catch (error) {
        errorMessage.style.display = "block";
        errorMessage.textContent = error.message;
    }
});
