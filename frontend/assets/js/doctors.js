document.addEventListener('DOMContentLoaded', () => {
    loadDoctors();

    document.getElementById('doctor-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const doctorId = document.getElementById('doctor-id').value;
        const doctorData = {
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
        };

        try {
            let response;
            if (doctorId) {
                response = await fetch(`${localStorage.getItem("API_URL")}/admin/doctors/${doctorId}`, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(doctorData),
                });
            } else {
                response = await fetch(`${localStorage.getItem("API_URL")}/admin/doctors`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(doctorData),
                });
            }

            if (!response.ok) {
                throw new Error('Erro ao salvar os dados do médico.');
            }

            const modal = document.getElementById('doctorModal');
            const modalInstance = new bootstrap.Modal(modal);
            modalInstance.hide();
            window.location.reload();
            loadDoctors();
        } catch (error) {
            alert('Erro ao salvar médico: ' + error.message);
        }
    });
});

async function loadDoctors() {
    try {
        const response = await fetch(`${localStorage.getItem("API_URL")}/admin/doctors`);
        const doctors = await response.json();

        const tableBody = document.getElementById('doctor-table').getElementsByTagName('tbody')[0];
        tableBody.innerHTML = '';

        doctors.data.forEach(doctor => {
            const row = tableBody.insertRow();
            row.innerHTML = `
                <td>${doctor.id}</td>
                <td>${doctor.name}</td>
                <td>${doctor.email}</td>
                <td>${new Date(doctor.created_at).toLocaleDateString()}</td>
                <td>
                    <button class="btn btn-warning btn-sm" onclick="editDoctor(${doctor.id})">Editar</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteDoctor(${doctor.id})">Excluir</button>
                </td>
            `;
        });
    } catch (error) {
        console.error('Erro ao carregar médicos:', error);
    }
}

function editDoctor(id) {
    const apiUrl = `${localStorage.getItem("API_URL")}/admin/doctors/${id}`;

    fetch(apiUrl)
        .then(response => response.json())
        .then(doctor => {
            if (doctor && doctor.data) {
                const doctorData = doctor.data;
                document.getElementById('doctor-id').value = doctorData.id;
                document.getElementById('name').value = doctorData.name;
                document.getElementById('email').value = doctorData.email;
                document.getElementById('password').value = '';  // Senha vazia para edição
                document.getElementById('doctorModalLabel').textContent = 'Editar Médico';

                const modal = document.getElementById('doctorModal');
                const modalInstance = new bootstrap.Modal(modal);
                modalInstance.show();
            } else {
                alert('Erro: Dados do médico não encontrados.');
            }
        })
        .catch(error => {
            console.error('Erro ao buscar os dados do médico:', error);
            alert('Erro ao buscar os dados do médico.');
        });
}

async function deleteDoctor(id) {
    if (confirm('Tem certeza que deseja excluir este médico?')) {
        try {
            const response = await fetch(`${localStorage.getItem("API_URL")}/admin/doctors/${id}`, {
                method: 'DELETE',
            });

            if (response.ok) {
                alert('Médico excluído com sucesso!');
                loadDoctors();
            } else {
                throw new Error('Erro ao excluir médico.');
            }
        } catch (error) {
            alert(`Erro ao excluir médico. ${error}`);
        }
    }
}
