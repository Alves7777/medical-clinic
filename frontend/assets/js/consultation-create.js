document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('consultation-form').addEventListener('submit', async (e) => {
        e.preventDefault();

        const consultationData = {
            patient_name: document.getElementById('patientName').value,
            patient_age: document.getElementById('patientAge').value,
            doctor_id: localStorage.getItem("doctor_id"),
            consultation_date: document.getElementById('consultationDate').value,
        };

        try {
            const response = await fetch(`${localStorage.getItem("API_URL")}/consultations`, {
                method: 'POST',
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify(consultationData),
            });

            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message);
            }

            alert('Consulta cadastrada com sucesso!');
            window.location.href = 'exams.html';
        } catch (error) {
            console.error('Erro ao salvar consulta:', error);
            alert('Erro ao salvar consulta: ' + error.message);
        }
    });
});
