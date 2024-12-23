localStorage.setItem("API_URL", "http://localhost:8000/api")
document.addEventListener("DOMContentLoaded", function() {
    const path = window.location.pathname;
    if (path.includes("login.html")) {
        import("./login.js");
    }
    if (path.includes("register.html")) {
        import("./register.js");
    }
    if (path.includes("dashboard.html")) {
        import("./dashboard.js");
    }
    if (path.includes("profile.html")) {
        import("./profile.js");
    }
    if (path.includes("consultation-create.html")) {
        import("./consultation-create.js");
    }
    if (path.includes("consultations-history.html")) {
        import("./consultations-history.js");
    }
});

