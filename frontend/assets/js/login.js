document.getElementById("loginForm")?.addEventListener("submit", async (event) => {
    event.preventDefault();

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    const errorMessage = document.getElementById("error-message");
    errorMessage.style.display = "none";

    try {
        const response = await fetch(`${localStorage.getItem("API_URL")}/auth/login`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message);
        }

        localStorage.setItem("auth_token", data.data.token);
        localStorage.setItem("doctor_id", data.data.data.id);
        window.location.href = "dashboard.html";
    } catch (error) {
        errorMessage.style.display = "block";
        errorMessage.textContent = error.message;
    }
});
