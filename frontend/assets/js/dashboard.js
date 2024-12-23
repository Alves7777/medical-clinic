document.addEventListener("DOMContentLoaded", () => {
    const consultationHistory = document.getElementById("consultationHistory");

    function populateConsultationHistory() {
        consultationHistory.innerHTML = `
            <tr>
                <td>Maria Silva</td>
                <td>35</td>
                <td>2024-12-21</td>
                <td>Concluído</td>
            </tr>
            <tr>
                <td>João Santos</td>
                <td>42</td>
                <td>2024-12-20</td>
                <td>Pendente</td>
            </tr>
        `;
    }
    populateConsultationHistory();
});
