
const fields = loadFields("name", "backname", "nif", "sex", "state");

disableFields(fields);

let userSelect = document.getElementById("user");

const form = document.getElementById("form");

let data;

axios.get("/getData").then(res => {
    
    data = res.data.data;
    console.log(data);
    data.forEach(n => {
        const option = document.createElement('OPTION');

        option.value = n.nif;
        option.innerText = `${n.name}(${n.nif})`;

        userSelect.appendChild(option);

    });

    updateDataSelect();

    const user = data.filter(n => n.nif == userSelect.value)[0];

    if(user) enableFields(fields);

});

userSelect.addEventListener("change", e => {

    const user = data.filter(n => n.nif == e.target.value)[0];

    if(!user){
        disableFields(fields);
        return;
    }

    enableFields(fields);

    for(n in fields){
        fields[n].value = user[n];
    }

    fields["sex"].dataset.selected = user["sex"];
    fields["state"].dataset.selected = user["state"];

});


function loadFields(...id) {
    const field = [];
    id.forEach(n => field[n] = document.getElementById(n));
    return field;
}

function disableFields(f){
    for(n in f){
        f[n].setAttribute("disabled", "");
    }
}
function enableFields(f){
    for(n in f){
        f[n].removeAttribute("disabled");
    }
}

const formDelete = document.getElementById("formDelete");


document.getElementById("btnDeleteUser").addEventListener("click", e => {
    
    if(checkUserSelect()){
        formDelete.action="delete/" + userSelect.value;
        formDelete.submit();
    }

});

function checkUserSelect(){
    userSelect.addEventListener("change", e => checkUserSelect())

    if(!validSelect(userSelect)){
        userSelect.classList.add("is-invalid");
        userSelect.classList.remove("is-valid");

        return false;
    }else{
        userSelect.classList.add("is-valid");
        userSelect.classList.remove("is-invalid");

        return true;
    }
}