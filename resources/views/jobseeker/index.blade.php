@extends('welcome')
@section('title', 'Jobseekers')
@section('content')
    <div class="container-fluid">
    @section('subtitle', 'Lista de Candidatos')
    <div class="container-fluid pt-4 pb-4">
        <button type="button" class="btn btn-primary btn-sm" id="openModalForm" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            Agregar Candidato
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="table-jobseeker">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Nro. Celular</th>
                    <th scope="col">Domicilio</th>
                    <th scope="col">Email</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @section('modalForm')
        @include('jobseeker.form')
    @endsection

    @section('modalConfirmation')
        @include('jobseeker.confirmation')
    @endsection

    @include('jobseeker.modal', ['idForm' => 'exampleModal','modalContent' => 'modalForm'])

    @include('jobseeker.modal', ['idForm' => 'modalRemove','modalContent' => 'modalConfirmation'])

</div>
@endsection

<script src="{{ asset('js/jobseeker/index.js') }}"></script>

<script>

var listJobseeker = [];
var tableJobseeker = ''
var idRegisterJobseeker = 0;

function getListJobseeker() {
    fetch('/api/getListJobsekers', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los productos');
            }
            return response.json();
        })
        .then(data => {
            if (data) {
                listJobseeker = data.registers;
                renderingTable();
            } else {
                listJobseeker = [];
            }
        })
        .catch(error => {
            console.error('Error al obtener los productos:', error.message);
        });
}

function renderingTable() {
    let table = document.querySelector('#table-jobseeker tbody');
    let cadenaRows = '';
    table.innerHTML = '';
    listJobseeker.forEach(item => {
        cadenaRows += getRowTable(item);
    })
    table.innerHTML = cadenaRows;
}

function getRowTable(register) {
    return `<tr>
                <th scope="row">${register.id}</th>
                <td>${register.first_name}</td>
                <td>${register.last_name}</td>
                <td>${register.phone_number}</td>
                <td>${register.address}</td>
                <td>${register.email}</td>
                <td>
                    <button type="button" class="btn btn-outline-info" onclick="viewJobseeker(${register.id})" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="blue-sky" width="20" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                    </button>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#modalRemove" onclick="deleteRegisterJobseeker(${register.id})" >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="red" width="20" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                    </button>
                </td>
            </tr>`;
}

function viewJobseeker(idJobseeker) {
    let btnOpenModal = document.getElementById('openModalForm');
    let objetoEncontrado = listJobseeker.find(obj => obj.id === idJobseeker);
    let lastName = objetoEncontrado.last_name.split(' ');
    let firtName = document.getElementById('firstName').value = objetoEncontrado.first_name;
    let lastName1 = document.getElementById('lastname1').value = lastName[0];
    let lastName2 = document.getElementById('lastname2').value = lastName[1] ? lastName[1] : '';
    let email = document.getElementById('email').value = objetoEncontrado.email;
    let address = document.getElementById('address').value = objetoEncontrado.address;
    let phone = document.getElementById('phone').value = objetoEncontrado.phone_number;
    idRegisterJobseeker = idJobseeker;
    let titleModal = document.getElementById('titleModal');
    titleModal.innerText = "Actualizar Candidato";
    btnOpenModal.click();
}

function checkingForm(event) {
    event.preventDefault();
    let firtName = document.getElementById('firstName');
    let lastName1 = document.getElementById('lastname1');
    let lastName2 = document.getElementById('lastname2');
    let email = document.getElementById('email');
    let address = document.getElementById('address');
    let phone = document.getElementById('phone');
    let newJobseeker = {
        'first_name': firtName.value,
        'last_name': (lastName1.value + ' ' + lastName2.value),
        'phone_number': phone.value,
        'address': address.value,
        'email': email.value
    };

    if (idRegisterJobseeker == 0) {
        saveRegister(newJobseeker);

    } else {

        updateRegister(newJobseeker);
    }

}

function deleteRegisterJobseeker(idJobseeker) {
    idRegisterJobseeker = idJobseeker;
}

function deleteRegister() {
    fetch(`/api/jobseeker/${idRegisterJobseeker}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al crear el producto');
            }
            return response.json();
        })
        .then(data => {
            getListJobseeker()
            alert(data.message);
            document.getElementById('btnCloseRemove').click();
        })
        .catch(error => {
            console.error('Error al crear el producto:', error.message);
        });
}

function saveRegister(newJobseeker) {
    fetch('/api/jobseeker', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newJobseeker)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al crear el producto');
            }
            return response.json();
        })
        .then(data => {
            getListJobseeker()
            alert(data.message);
            document.getElementById('btnClose').click();
            clearInputControls()
        })
        .catch(error => {
            console.error('Error al crear el producto:', error.message);
        });
}

function clearInputControls() {
    document.getElementById('firstName').value = '';
    document.getElementById('lastname1').value = '';
    document.getElementById('lastname2').value = '';
    document.getElementById('email').value = '';
    document.getElementById('address').value = '';
    document.getElementById('phone').value = '';
}

function updateRegister(jobseeker) {
    fetch(`/api/jobseeker/${idRegisterJobseeker}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(jobseeker)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al crear el producto');
            }
            return response.json();
        })
        .then(data => {
            getListJobseeker()
            alert(data.message);
            document.getElementById('btnClose').click();
            idRegisterJobseeker = 0;
            clearInputControls()
        })
        .catch(error => {
            console.error('Error al crear el producto:', error.message);
        });
}

document.addEventListener("DOMContentLoaded", function() {

    document.getElementById('btnClose').addEventListener('click', function() {
        idRegisterJobseeker = 0;
        clearInputControls();
        document.getElementById('titleModal').innerText = "Nuevo Candidato";
    });

    document.getElementById('btnCloseRemove').addEventListener('click', function() {
        idRegisterJobseeker = 0;
    });

    getListJobseeker();
});


</script>
