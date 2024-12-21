const API_URL = "http://localhost:8000/api";

document.getElementById("fetchData").addEventListener("click", async () => {
    const output = document.getElementById("output");
    output.innerHTML = "Carregando...";

    try {
        const response = await fetch(`${API_URL}/test`);
        const data = await response.json();
        output.innerHTML = `<pre>${JSON.stringify(data, null, 2)}</pre>`;
    } catch (error) {
        output.innerHTML = `Error: ${error.message}`;
    }
});
