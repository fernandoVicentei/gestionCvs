<form class="row g-3  " onsubmit="managementCvs(event)">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="titleModal">Nuevo Curriculo</h5>
        </div>
        <div class="modal-body">
            <div class="container">

                <div class="col-md-12">
                    <label for="validationServer01" class="form-label">Título *</label>
                    <input type="text" class="form-control " placeholder="Ej: Ingenieria de Sistemas"
                        maxlength="255" id="title" value="" aria-describedby="validationFirstName"
                        required>
                </div>
                <div class="col-md-6">
                    <label for="validationServer02" class="form-label">Pretención Salarial *</label>
                    <input type="number" class="form-control " placeholder="Ingresa tu pretencion salarial"
                        minlength="50" min="2362" id="salary" value="" required>
                </div>
                <div class="col-md-12">
                    <label for="validationServer01" class="form-label">Presentacion *</label>
                    <textarea class="form-control " value=" " placeholder="Ingresa tu presentación" rows="5" minlength="100"
                        maxlength="3000" id="biography" required>
                    </textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="btnClose"
                data-bs-dismiss="modal">Cerrar</button>
            <button class="btn btn-primary" type="submit" id="btnSubmit">Guardar</button>
        </div>
    </div>
</form>
