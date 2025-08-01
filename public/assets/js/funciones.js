function LimpiarMsj() {
    let msj = document.getElementById('msj');
    msj.innerHTML = "";
}

function soloNumeros(event) {
    console.log(event.keyCode);
    if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 8 && event.keyCode !== 9) {
        return false;
    }
}

function soloNumerosPunto(event) {
    if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105) && event.keyCode !== 110 && event.keyCode !== 8 && event.keyCode !== 9) { return false; }
    return true;
}

function soloLetras(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    especiales = [8, 37, 39, 46];

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
