
const validNif = nif => /\d{8}[A-Z]/.test(nif.toUpperCase()) && nif.length == 9 && nif.slice(-1).toUpperCase() == "TRWAGMYFPDXBNJZSQVHLCKE"[parseInt(nif.match(/\d{8}/)[0]) % 23]

const validSelect = select => select.value != select.options[0].value;

function setInvalidForm(formEvent){
    formEvent.preventDefault()
    formEvent.stopPropagation()
}

function validateInput(input, validation, formEvent, errorMessage = null, eventValidate = 'change', addEventListener = true){

    if(addEventListener) input.addEventListener(eventValidate, () => validateInput(input, validation, formEvent, errorMessage, eventValidate, false))

    if(input.hasAttribute("disabled")) return;

    if(!validation(input)){
        setInvalidForm(formEvent)
        input.classList.add("is-invalid")
        input.classList.remove("is-valid")

        if(errorMessage != null) input.parentElement.querySelector(".invalid-feedback").innerHTML = errorMessage

    }else{
        input.classList.remove("is-invalid");
        input.classList.add("is-valid");
    }

}

function validateForm(formEvent){

    let userSelect = document.getElementById("user");
    
    if(userSelect != null) validateInput(userSelect, validSelect, formEvent);

    validateInput(document.getElementById("name"), n => n.value.trim(), formEvent, null, "keyup")
    validateInput(document.getElementById("backname"), n => n.value.trim(), formEvent, null, "keyup")

    let nif = document.getElementById("nif")
    validateInput(nif, n => validNif(n.value), formEvent, nif.value == "" ? null : "El NIF és incorrecte", "keyup")

    validateInput(document.getElementById("sex"), validSelect, formEvent)
    validateInput(document.getElementById("state"), validSelect, formEvent)

}

function updateDataSelect(){
    document.querySelectorAll("form select:not([data-selected=''])").forEach(n => {
    
        let options = Array.from(n.options)
    
        let newSelected = options.filter(x => x.value == n.dataset.selected)
        
        if(newSelected.length > 0){
            options.filter(x => x.selected)[0].selected = false
            newSelected[0].selected = true
        }
    
    });
}

updateDataSelect();
