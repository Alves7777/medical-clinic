document.addEventListener('DOMContentLoaded', () => {
    const doctorId = localStorage.getItem("doctor_id");

    loadConsultations(doctorId);
});

async function loadConsultations(doctorId) {
    try {
        const response = await fetch(`${localStorage.getItem("API_URL")}/consultations/history/${doctorId}`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
        });

        const consultations = await response.json();

        if (consultations.status !== "Success") {
            throw new Error(consultations.message);
        }

        const tableBody = document.getElementById('consultations-table');
        tableBody.innerHTML = '';

        consultations.data.forEach(consultation => {
            const row = tableBody.insertRow();

            const finalizeButtonDisabled = consultation.status === "completed" ? "disabled" : "";

            row.innerHTML = `
                <td>${consultation.patient_name}</td>
                <td>${consultation.patient_age}</td>
                <td>${new Date(consultation.consultation_date).toLocaleString()}</td>
                <td>${consultation.status}</td>
                <td>
                    <button onclick="viewExams(${consultation.id})" class="btn btn-info btn-sm">Ver Exames</button>
                    <button onclick="finalizeConsultation(${consultation.id})" class="btn btn-success btn-sm" ${finalizeButtonDisabled}>Finalizar</button>
                </td>
            `;
        });
    } catch (error) {
        console.error('Erro ao carregar o histórico de consultas:', error);
        alert('Erro ao carregar o histórico de consultas.');
    }
}


function finalizeConsultation(consultationId) {
    fetch(`${localStorage.getItem("API_URL")}/consultation/complete`, {
        method: 'POST',
        headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        body: JSON.stringify({ consultation_id: consultationId }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                alert('Consulta finalizada com sucesso!');
                window.location.reload();
            } else {
                alert(data.message || 'Erro ao finalizar a consulta.');
            }
        })
        .catch(error => {
            alert(`Erro ao finalizar a consulta. ${error}`);
        }).finally(() => {
        window.location.reload();
    });
}

function viewExams(consultationId) {
    fetch(`${localStorage.getItem("API_URL")}/consultations/${consultationId}/exams`, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "Success") {
                const modal = document.createElement('div');
                modal.classList.add('modal', 'fade');
                modal.id = 'examsModal';
                modal.tabIndex = -1;
                modal.setAttribute('aria-labelledby', 'examsModalLabel');
                modal.setAttribute('aria-hidden', 'true');

                modal.innerHTML = `
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="examsModalLabel">Exames da Consulta</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul id="examsList"></ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                `;

                document.body.appendChild(modal);

                const examsList = document.getElementById('examsList');
                examsList.innerHTML = '';

                data.data.forEach(exam => {
                    const li = document.createElement('li');
                    li.textContent = `${exam.exam_name} - Data: ${new Date(exam.exam_date).toLocaleDateString()}`;
                    examsList.appendChild(li);
                });

                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();

                modal.addEventListener('hidden.bs.modal', () => {
                    modal.remove();
                });
            } else {
                alert('Erro ao carregar os exames.');
            }
        })
        .catch(error => {
            alert('Erro ao carregar os exames. ' + error);
        });
}

