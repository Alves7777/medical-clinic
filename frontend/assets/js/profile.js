document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("auth_token");
    const profileContainer = document.getElementById("profileContainer");

    if (!token) {
        window.location.href = "login.html";
        return;
    }

    async function fetchDoctorProfile() {
        try {
            const response = await fetch(`${localStorage.getItem("API_URL")}/auth/me`, {
                method: "POST",
                headers: {
                    Authorization: `Bearer ${token}`,
                    "Content-Type": "application/json"
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Erro ao buscar perfil.");
            }

            const doctorInfo = data.data.data;

            profileContainer.innerHTML = `
                <h3>Perfil do Médico</h3>
                <p><strong>Nome:</strong> ${doctorInfo.name}</p>
                <p><strong>Email:</strong> ${doctorInfo.email}</p>
                <p><strong>Registrado em:</strong> ${new Date(doctorInfo.created_at).toLocaleDateString()}</p>
            `;
        } catch (error) {
            alert(`Sessão expirada ou erro ao carregar perfil. Detalhes: ${error.message}`);
            localStorage.removeItem("auth_token");
            window.location.href = "login.html";
        }
    }

    await fetchDoctorProfile();
});
