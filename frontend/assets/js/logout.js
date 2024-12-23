function logout() {
    const token = localStorage.getItem("auth_token");

    fetch(`${localStorage.getItem("API_URL")}/auth/logout`, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                throw new Error(data.message);
            }

            localStorage.removeItem("auth_token");
            localStorage.removeItem("doctor_info");
        })
        .catch(error => {
            alert(`"Erro ao realizar logout:", ${error.message}`)
        }).finally(() => {
            window.location.href = "login.html";
        });
}
