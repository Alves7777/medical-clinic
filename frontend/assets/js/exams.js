document.addEventListener("DOMContentLoaded", () => {
    fetchConsultations();
});

function fetchConsultations() {
    fetch(`${localStorage.getItem("API_URL")}/doctors/${localStorage.getItem("doctor_id")}/consultations`, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "Success") {
                populateConsultationsTable(data.data);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Erro ao buscar consultas:", error));
}

function populateConsultationsTable(consultations) {
    const tableBody = document.querySelector("#consultationsTable tbody");
    tableBody.innerHTML = "";

    consultations.forEach(consultation => {
        const row = document.createElement("tr");
        const finalizeButtonDisabled = consultation.status === "completed" ? "disabled" : "";

        row.innerHTML = `
            <td>${consultation.id}</td>
            <td>${consultation.patient_name}</td>
            <td>${consultation.patient_age}</td>
            <td>${new Date(consultation.consultation_date).toLocaleString()}</td>
            <td>${consultation.status}</td>
            <td style="display: flex; flex-wrap: nowrap; flex-direction: row">
                <button class="btn btn-primary btn-sm ${finalizeButtonDisabled}" onclick="openAddExamModal(${consultation.id})">Adicionar Exames</button>
                <button class="btn btn-info btn-sm" onclick="fetchPrescriptions(${consultation.id})">Listar Prescrições</button>
                <button class="btn btn-success btn-sm" onclick="openAddPrescriptionModal(${consultation.id})">Adicionar Prescrição</button>
            </td>
        `;

        tableBody.appendChild(row);
    });
}

function openAddExamModal(consultationId) {
    const modalContainer = document.getElementById("modalContainer");

    modalContainer.innerHTML = `
        <div class="modal fade" id="addExamModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Exame</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="examName" class="form-label">Nome do Exame</label>
                            <input type="text" class="form-control" id="examName" placeholder="Nome do Exame">
                        </div>
                        <div class="mb-3">
                            <label for="examDate" class="form-label">Data do Exame</label>
                            <input type="date" class="form-control" id="examDate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="addExam(${consultationId})">Adicionar</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const modal = new bootstrap.Modal(document.getElementById("addExamModal"));
    modal.show();
}

function addExam(consultationId) {
    const examName = document.getElementById("examName").value;
    const examDate = document.getElementById("examDate").value;

    if (!examName || !examDate) {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    const requestData = {
        consultation_id: consultationId,
        exam_name: examName,
        exam_date: examDate,
    };

    fetch(`${localStorage.getItem("API_URL")}/consultations/${consultationId}/exams`, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        body: JSON.stringify(requestData),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "Success") {
                alert("Exame adicionado com sucesso.");
                const modal = bootstrap.Modal.getInstance(document.getElementById("addExamModal"));
                modal.hide();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Erro ao adicionar exame:", error));
}

function fetchPrescriptions(consultationId) {
    fetch(`${localStorage.getItem("API_URL")}/prescriptions/${consultationId}`, {
        headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "Success") {
                listPrescriptions(data.data);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Erro ao buscar prescrições:", error));
}

function listPrescriptions(prescriptions) {
    const modalContainer = document.getElementById("modalContainer");

    let prescriptionListHTML = prescriptions.map(prescription => `
        <tr>
            <td>${prescription.medication}</td>
            <td>${prescription.instructions}</td>
            <td>${new Date(prescription.created_at).toLocaleString()}</td>
        </tr>
    `).join("");

    modalContainer.innerHTML = `
        <div class="modal fade" id="listPrescriptionsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Prescrições</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Medicação</th>
                                    <th>Instruções</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${prescriptionListHTML}
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const modal = new bootstrap.Modal(document.getElementById("listPrescriptionsModal"));
    modal.show();
}

function openAddPrescriptionModal(consultationId) {
    const modalContainer = document.getElementById("modalContainer");

    modalContainer.innerHTML = `
        <div class="modal fade" id="addPrescriptionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Prescrição</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="medication" class="form-label">Medicação</label>
                            <input type="text" class="form-control" id="medication" placeholder="Ex: Paracetamol">
                        </div>
                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instruções</label>
                            <input type="text" class="form-control" id="instructions" placeholder="Ex: Tomar 1 comprimido 3 vezes ao dia">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="addPrescription(${consultationId})">Adicionar</button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const modal = new bootstrap.Modal(document.getElementById("addPrescriptionModal"));
    modal.show();
}

function addPrescription(consultationId) {
    const medication = document.getElementById("medication").value;
    const instructions = document.getElementById("instructions").value;

    if (!medication || !instructions) {
        alert("Por favor, preencha todos os campos.");
        return;
    }

    const requestData = {
        consultation_id: consultationId,
        medication: medication,
        instructions: instructions,
    };

    fetch(`${localStorage.getItem("API_URL")}/prescriptions`, {
        method: "POST",
        headers: {
            Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            "Content-Type": "application/json",
            "Accept": "application/json",
        },
        body: JSON.stringify(requestData),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === "Success") {
                alert("Prescrição adicionada com sucesso.");
                const modal = bootstrap.Modal.getInstance(document.getElementById("addPrescriptionModal"));
                modal.hide();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error("Erro ao adicionar prescrição:", error));
}
