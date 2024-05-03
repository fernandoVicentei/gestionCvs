<form class="row g-3  " onsubmit="checkingForm(event)">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="titleModal">Nuevo Candidato</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="container">

                <div class="col-md-12">
                    <label for="validationServer01" class="form-label">First name</label>
                    <input type="text" class="form-control " maxlength="100" id="firstName"
                        value="" aria-describedby="validationFirstName" required>
                    <div id="validationFirstName" class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationServer02" class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control " maxlength="50" id="lastname1" value=""
                        aria-describedby="validationLastName" required>
                    <div id="validationLastName" class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationServer02" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control " maxlength="50" id="lastname2" value=""
                        aria-describedby="validationLastName2">
                </div>
                <div class="col-md-12">
                    <label for="validationServerUsername" class="form-label">Email</label>
                    <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend3">@</span>
                        <input type="email" class="form-control " maxlength="50" id="email"
                            aria-describedby="inputGroupPrepend3 validationEmail" required>
                        <div id="validationEmail" class="invalid-feedback">
                            Please choose a username.
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="validationServer03" class="form-label">City</label>
                    <input type="text" class="form-control " maxlength="255" id="address"
                        aria-describedby="validationCity " required>
                    <div id="validationCity" class="invalid-feedback">
                        Please provide a valid city.
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="validationServer03" class="form-label">Nro. Telefono</label>
                    <input type="number" min="1" max="99999999999999" class="form-control"
                        id="phone" aria-describedby="validationCity " required>
                    <div id="validationCity" class="invalid-feedback">
                        Please provide a valid city.
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btnClose" data-bs-dismiss="modal">Cerrar</button>
            <button class="btn btn-primary" type="submit" id="btnSubmit" >Guardar cambios</button>
        </div>
    </div>
</form>
