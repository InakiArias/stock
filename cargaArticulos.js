function sumarArticulo() {

    const articulo = document.getElementById("articulo");

    const option = articulo[articulo.selectedIndex];

    const cantidadInput = document.getElementById("cantidad");

    if (option.value !== "" && cantidadInput.checkValidity()) {
        const cantidadElem = document.getElementById("cantidadAgregados");
        cantidadElem.valueAsNumber++;
        cantidadElem.attributes["max-numero"].value = Number(cantidadElem.attributes["max-numero"].value) + 1;

        const indiceAgregado = cantidadElem.attributes["max-numero"].value;

        const cantidadArticulo = cantidadInput.value;
        const precioArticulo = document.getElementById("precio").value;

        const html = `
        <div class="col-6 text-center agregado${indiceAgregado}">
            <select class="form-select" id="articulo${indiceAgregado}" disabled >
                <option value="${option.value}">${option.text}</option>
                <input value="${option.value}" name="articulo${indiceAgregado}" type="hidden">
            </select>
        </div>
        <div class="col-2 text-center agregado${indiceAgregado}">
            <input class="form-control w-75 m-auto" type="number" value="${cantidadArticulo}" min="1" id="cantidad${indiceAgregado}" name="cantidad${indiceAgregado}" readonly >
        </div>
        <div class="col-3 text-center agregado${indiceAgregado}">
            <input class="form-control w-75 m-auto" value="${precioArticulo}" id="precio${indiceAgregado}" name="precio${indiceAgregado}" readonly ></input>
        </div>
        <div class="col-1 text-center agregado${indiceAgregado}">
            <button type="button" onclick="eliminarArticulo(${indiceAgregado})" class="btn btn-danger px-4 py-1 h-100 text-center border-0" role="button"><i class="fas fa-times"></i></button>
        </div>
        `
        const agregados = document.getElementById("agregados");
        agregados.insertAdjacentHTML("beforeend", html);
    }

}

function actualizarPrecio() {

    const articulo = document.getElementById("articulo");

    const option = articulo[articulo.selectedIndex];

    document.getElementById("precio").valueAsNumber = Number(option.attributes.precio.value);

}

function eliminarArticulo(numeroAgregado) {
    const agregados = document.querySelectorAll(".agregado" + numeroAgregado);

    for (const agregado of agregados) {
        agregado.remove();
    }

    const cantidadElem = document.getElementById("cantidadAgregados");
    cantidadElem.valueAsNumber--;
}

function validar() {
    const cantidadElem = document.getElementById("cantidadAgregados");

    if (cantidadElem.valueAsNumber === 0)
        return false;

    return true;
}
