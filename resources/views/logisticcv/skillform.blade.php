<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="titleModal">Gestionar Aptitudes</h5>
    </div>
    <div class="modal-body">
        <div class="container">
            <div class="col-md-12">
                <label for="validationServer01" class="form-label">Añade aptitudes</label>
                <div class="container-fluid mt-2 mb-2">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 row">
                            <form onsubmit="managementSkill(event)" class="col-12 row" >
                                <div class="alert alert-success d-none" id="alertSkill" role="alert">
                                    Registro guardado correctamente.
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-6">
                                    <label for="exampleFormControlInput1" class="form-label">Ingresa una
                                        habilidad</label>
                                    <input type="text" class="form-control" minlength="1" maxlength="255"
                                        id="name" placeholder="Ej: Proactividad en el trabajo" required>
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-6">
                                    <label for="exampleFormControlInput1" class="form-label">Selecciona el nivel</label>
                                    <select class="form-select" id="level" aria-label="Default select example"
                                        required>
                                        <option selected disabled>Selecciona una opción</option>
                                        <option value="BEGINNER">PRINCIPIANTE</option>
                                        <option value="INTERMEDIATE">INTERMEDIO</option>
                                        <option value="ADVANCED">AVANZADO</option>
                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 col-lg-6 mt-3 mb-3">
                                    <button type="submit" class="btn btn-primary" id="btnSkill">Agregar</button>
                                    <button type="button" class="btn btn-secondary d-none"
                                        id="btnCloseSkill" onclick="clearFormSkill()" >Cancelar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 col-sm-12 pt-2">
                            <strong>Mis aptitudes</strong>
                            <ul id="sectionSkills" class="list-group list-group-horizontal d-flex align-content-start flex-wrap mt-3 mb-3 ">

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnClose" data-bs-dismiss="modal">Cerrar</button>
    </div>
</div>
