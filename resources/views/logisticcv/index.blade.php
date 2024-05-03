@extends('welcome')
@section('title', 'Management CV')
@section('content')
<div class="container-fluid">
    @section('subtitle', 'Gestion de CVs')
    <div class="row container-fluid">
        <div class="col-12 col-sm-5 col-md-4 col-lg-4  ">
            <label for="searchJobseeker" class="h3">Buscar Candidato</label>
            <form class="d-flex mt-3 mb-3">
                <input class="form-control me-2" id="searchJobseeker" type="search"
                    placeholder="Ingresa el nombre, telefono o email" aria-label="Search">
                <button class="btn btn-secondary text-light" disabled>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="white" viewBox="0 0 512 512">
                        <path
                            d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                    </svg>
                </button>
            </form>
            <div class="overflow-auto h-50">
                <div class="list-group" id="listJobseeker">
                    <strong class="text-center">Sin resultados.</strong>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-7 col-md-8 col-lg-8">
            <div class="container-fluid">
                <label for="searchJobseeker" class="h3">Curriculos de :</label><br>
                <span class="h4" id="jobseeker"></span>
                <div class="row  align-items-start mt-4 mb-4" id="listCvs">

                </div>
            </div>
        </div>
    </div>
</div>

@section('modalForm')
    @include('logisticcv.form')
@endsection

@section('modalConfirmation')
    @include('logisticcv.confirmation')
@endsection

@section('modalSkills')
    @include('logisticcv.skillform')
@endsection

@section('modalCurriculo')
    @include('logisticcv.curriculo')
@endsection

@include('logisticcv.modal', ['idForm' => 'modalCv', 'modalContent' => 'modalForm', 'sizeModal' => 'modal-lg'])
@include('logisticcv.modal', ['idForm' => 'modalRemove', 'modalContent' => 'modalConfirmation', 'sizeModal' => 'modal-sm'])
@include('logisticcv.modal', ['idForm' => 'modalSkill', 'modalContent' => 'modalSkills', 'sizeModal' => 'modal-lg'])
@include('logisticcv.modal', ['idForm' => 'modalCurriculo', 'modalContent' => 'modalCurriculo', 'sizeModal' => 'modal-lg'])
@endsection
<script>
    var listJobseeker = [];
    var listCvsJobseeker = [];
    var idObjJobseeker = 0;
    var idCvJobseeker = 0;

    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('searchJobseeker').addEventListener('input', function() {
            let searchTerm = (this.value + '').trim();
            if (searchTerm.length >= 1) {
                fetch(`/api/searchjobseeker?filter=${searchTerm}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Error al buscar registros');
                        }
                        return response.json();
                    })
                    .then(data => {
                        listJobseeker = data.registers;
                        renderingList()
                    })
                    .catch(error => {
                        console.error('Error al buscar registros:', error);
                    });
            } else {
                document.getElementById('listJobseeker').innerHTML = '';
            }
        });

        document.getElementById('btnClose').addEventListener('click', function() {
            idCvJobseeker = 0;
            clearInputControls();
            document.getElementById('titleModal').innerText = "Nuevo Curriculo";
        });

        clearInputControls()
    });

    function renderingList() {
        let searchResultsElement = document.getElementById('listJobseeker');
        let stringHtmlItems = '';
        searchResultsElement.innerHTML = '';
        if (listJobseeker.length > 0) {
            listJobseeker.forEach(function(result) {
                stringHtmlItems += getItemJobseeker(result);
            });
        } else {
            stringHtmlItems = '<strong class="text-center" >Sin resultados.</strong>';
        }

        searchResultsElement.innerHTML = stringHtmlItems;
    }

    function getItemJobseeker(item) {
        return `
                <a  href="#" class="list-group-item list-group-item-action " onclick="getCvforJobseeker(${item.id})" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">${item.first_name} ${item.last_name}</h5>
                        </div>
                        <p class="mb-1">${item.email}</p>
                        <small>${item.phone_number}</small>
                </a>
        `;
    }

    function getCvforJobseeker(idJobseeker) {
        let textName = document.getElementById('jobseeker');
        let objetoEncontrado = listJobseeker.find(obj => obj.id === idJobseeker);
        textName.innerText = (objetoEncontrado.first_name + ' ' + objetoEncontrado.last_name);
        idObjJobseeker = idJobseeker;
        getListCvs();
    }

    function getListCvs() {
        fetch(`/api/jobseekercvs/${idObjJobseeker}`, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al buscar registros');
                }
                return response.json();
            })
            .then(data => {
                if (data.listCvs.length > 0) {
                    listCvsJobseeker = data.listCvs;
                    if (data.listCvs.length == 1) {
                        renderingNewCv();
                        renderingCvs()
                    } else {
                        document.getElementById('listCvs').innerHTML = '';
                        renderingCvs()
                    }
                } else {
                    renderingNewCv();
                }
            })
            .catch(error => {
                console.error('Error al buscar registros:', error);
            });
    }

    function getCVHtml(item) {
        return `
                <div class="col-12 col-sm-6 col-md-6 col-lg-6" >
                    <div class="card border-secondary"  >
                        <div class="card-body">
                            <h4 class="card-title">${item.title}</h4>
                            <p class="card-text limitText">${item.biography}</p>
                            <span class="badge rounded-pill bg-success">${item.salary} bs.</span>
                        </div>
                        <div class="card-footer" >
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <button type="button" onclick="searchCv(${item.id})" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#modalCurriculo"  >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                                        fill="white"    width="20"
                                    >
                                        <path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg>
                                </button>
                                <button type="button" onclick="openModalCv(${item.id})"  data-bs-toggle="modal" data-bs-target="#modalCv" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white"
                                        width="20" viewBox="0 0 512 512">
                                        <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
                                </button>
                                <button type="button" onclick="openModalSkills(${item.id})"  data-bs-toggle="modal" data-bs-target="#modalSkill" class="btn btn-success d-flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" class="text-center" width="20"
                                        viewBox="0 0 448 512">
                                        <path
                                            d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                    </svg>
                                    Skills
                                </button>
                                <button type="button" onclick="openModalCvRemove(${item.id})" data-bs-toggle="modal" data-bs-target="#modalRemove" class="btn btn-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white"
                                    width="20" viewBox="0 0 448 512"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/></svg>
                                </button>
                            </div>
                        </div>
                        </div>
                </div>
        `;
    }

    function managementCvs(event) {
        event.preventDefault();
        let title = document.getElementById('title');
        let salary = document.getElementById('salary');
        let biography = document.getElementById('biography');
        let actDate = new Date();
        let dateFormater = actDate.toISOString().slice(0, 19).replace('T', ' ');
        let obj = {
            'title': title.value,
            'salary': salary.value,
            'biography': biography.value,
        }
        if (idCvJobseeker == 0) {
            obj['jobseeker_id'] = idObjJobseeker;
            obj['created_on'] = dateFormater;
            saveRegisterCv(obj);
        } else {
            updateRegisterCv(obj);
        }
    }

    function saveRegisterCv(newJobseekerCv) {
        fetch('/api/jobseekercv', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(newJobseekerCv)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al crear el producto');
                }
                return response.json();
            })
            .then(data => {
                getListCvs()
                alert(data.message);
                document.getElementById('btnClose').click();
                clearInputControls()
            })
            .catch(error => {
                console.error('Error al crear el producto:', error.message);
            });
    }

    function updateRegisterCv(jobseekerCv) {
        fetch(`/api/jobseekercv/${idCvJobseeker}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jobseekerCv)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al crear el producto');
                }
                return response.json();
            })
            .then(data => {
                getListCvs()
                alert(data.message);
                document.getElementById('btnClose').click();
                clearInputControls();
                idCvJobseeker = 0;
            })
            .catch(error => {
                console.error('Error al crear el producto:', error.message);
            });
    }

    function deleteRegisterCv() {
        fetch(`/api/jobseekercv/${idCvJobseeker}`, {
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
            getListCvs()
            alert(data.message);
            document.getElementById('btnCloseModal').click();
            idCvJobseeker = 0;
        })
        .catch(error => {
            console.error('Error al crear el producto:', error.message);
        });
    }

    function clearInputControls() {
        document.getElementById('title').value = '';
        document.getElementById('salary').value = '';
        document.getElementById('biography').value = '';
    }

    function openModalCv(idCv) {
        let objetoEncontrado = listCvsJobseeker.find(obj => obj.id === idCv);
        document.getElementById('title').value = objetoEncontrado.title;
        document.getElementById('salary').value = objetoEncontrado.salary;
        document.getElementById('biography').value = objetoEncontrado.biography;
        idCvJobseeker = idCv;

    }

    function openModalCvRemove(idCv) {
        idCvJobseeker = idCv;
    }

    function renderingCvs() {
        let cadenaHTML = '';
        let sectionCvs = document.getElementById('listCvs');
        listCvsJobseeker.forEach(item => {
            cadenaHTML += getCVHtml(item);
        })
        sectionCvs.innerHTML += cadenaHTML;
    }

    function renderingNewCv() {
        let sectionCvs = document.getElementById('listCvs');
        sectionCvs.innerHTML = '';
        sectionCvs.innerHTML = getNewCvHTML();
    }

    function getNewCvHTML() {
        return `
            <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                <div class="card border-secondary" data-bs-toggle="modal" data-bs-target="#modalCv">
                    <div class="card-body text-center cursorPointer ">
                        <div class="container text-center centerSvg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-center" width="70"
                                viewBox="0 0 448 512">
                                <path
                                    d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                            </svg>
                        </div>
                        <strong class="text-center h3 text-dark-emphasis">Agregar Curriculo</strong>
                    </div>
                </div>
            </div>
            `;
    }

    function updateItemActive() {
        const lista = document.getElementById('listJobseeker');
        const items = lista.querySelectorAll('.list-group-item.list-group-item-action')
        lista.querySelectorAll('.list-group-item.list-group-item-action').forEach(item => {
            item.addEventListener('click', function() {
                // Elimina la clase 'active' de todos los elementos de la lista
                lista.querySelectorAll('.list-group-item.list-group-item-action').forEach(el => el
                    .classList.remove('active'));
                // Agrega la clase 'active' solo al elemento clickeado
                item.classList.add('active');
            });
        });
    }
</script>
<script>
    var listSkillCvs = [];
    var idSkill = 0;

    function openModalSkills(idCv) {
        idCvJobseeker = idCv;
        getSkillForCv();
    }

    function getSkillForCv() {
        fetch(`/api/getcvskills/${idCvJobseeker}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al buscar registros');
            }
            return response.json();
        })
        .then(data => {
            if (data.listSkills.length > 0) {
                listSkillCvs = data.listSkills;
                renderingSkills();
            } else {

            }
        })
        .catch(error => {
            console.error('Error al buscar registros:', error);
        });
    }

    function renderingSkills() {
        let sectionSkill = document.getElementById('sectionSkills');
        let stringSkill = '';
        sectionSkill.innerHTML = '';
        listSkillCvs.forEach(element => {
            stringSkill += getItemSkill(element);
        });
        sectionSkill.innerHTML = stringSkill;
    }

    function managementSkill(event) {
        event.preventDefault();
        let name = document.getElementById('name');
        let level = document.getElementById('level');
        let obj = {
            'name'  : name.value,
            'level' : level.value,
            'cv_id' : idCvJobseeker
        }
        if(idSkill == 0) {
            saveRegisterSkill(obj);
        } else {
            updateRegisterSkill(obj)
        }
    }

    function clearFormSkill() {
        let btnCancel = document.getElementById('btnCloseSkill');
        btnCancel.classList.add('d-none');
        idSkill = 0;
        document.getElementById('name').value = '';
        document.getElementById('level').value = '';
    }

    function saveRegisterSkill(newSkill) {
        fetch('/api/skillcv', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(newSkill)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al crear el producto');
            }
            return response.json();
        })
        .then(data => {
            clearFormSkill()
            getSkillForCv()
            addAlert()
        })
        .catch(error => {
            console.error('Error al crear el producto:', error.message);
        });
    }

    function updateSkillManagement(idSkillParam){
        let btnCancel = document.getElementById('btnCloseSkill');
        let obj = listSkillCvs.find(obj => obj.id === idSkillParam);
        document.getElementById('name').value = obj.name;
        document.getElementById('level').value = obj.level;
        btnCancel.classList.remove('d-none');
        idSkill = idSkillParam;

    }

    function deleteRegisterCvSkill(idSkillParam) {
        fetch(`/api/skillcv/${idSkillParam}`, {
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
            getSkillForCv()
            addAlert()
            idSkill = 0;
        })
        .catch(error => {
            console.error('Error al crear el producto:', error.message);
        });
    }

    function updateRegisterSkill(skills) {
        fetch(`/api/skillcv/${idSkill}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(skills)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al actualizar el registro');
            }
            return response.json();
        })
        .then(data => {
            clearFormSkill()
            getSkillForCv()
            addAlert()
            idSkill = 0;
        })
        .catch(error => {
            console.error('Error al crear el producto:', error.message);
        });
    }

    function searchCv(idCv) {
        fetch(`/api/getcv/${idCv}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al buscar registros');
            }
            return response.json();
        })
        .then(data => {
            let cv = data.cv;
            let jobseeker = data.jobseeker;
            let skills = data.skills;
            renderingCv(cv, jobseeker, skills);
        })
        .catch(error => {
            console.error('Error al buscar registros:', error);
        });
    }

    function renderingCv(cv, jobseeker, skills) {
        let stringItem = '';
        document.getElementById('cvTitle').innerText = cv.title;
        document.getElementById('cvNombre').innerText = jobseeker.first_name+' '+jobseeker.last_name;
        document.getElementById('cvPhone').innerText = jobseeker.phone_number;
        document.getElementById('cvAddress').innerText = jobseeker.address;
        document.getElementById('cvEmail').innerText = jobseeker.email;
        document.getElementById('cvSalary').innerText = cv.salary +' bs.';
        document.getElementById('cvBiopgraphy').innerText = cv.biography;
        skills.forEach(element => {
            stringItem += `<li class="h5">${element.name}  (${element.level})</li>`;
        });
        document.getElementById('cvSkill').innerHTML = stringItem;
    }

    function addAlert() {
        let alerta = document.getElementById('alertSkill');
        alerta.classList.remove('d-none');
        setTimeout(function() {
            alerta.classList.add('d-none');
        }, 5000);
    }

    function getItemSkill(item) {
        return `
            <li class="list-group-item ">
                <button type="button" class="btn btn-danger" onclick="deleteRegisterCvSkill(${item.id})" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="15"
                        viewBox="0 0 448 512">
                        <path
                            d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                    </svg>
                </button>
                <button type="button" class="btn btn-warning" onclick="updateSkillManagement(${item.id})" >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" width="15"
                        viewBox="0 0 512 512">
                        <path
                            d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                    </svg>
                </button>
                <strong> ${item.name} </strong>
            </li>
        `;
    }

</script>
