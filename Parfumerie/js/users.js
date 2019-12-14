function login(){
    var pseudo = document.getElementById('pseudo').value;
    var password = document.getElementById('password').value;
    if (pseudo && password){
        axios.defaults.baseURL='Controller/';
        const params = new URLSearchParams();
        params.append('function', 'getUser');
        params.append('pseudo', pseudo);
        params.append('password', password);
        axios({
            method: 'post',
            url: 'usersController.php',
            data: params
        })
            .then(response => {
                if (response.data[0]=='Error'){
                    if (response.data[1].includes('Identifiants')){
                        alert(response.data[1]);
                        document.getElementById('password').value='';
                    }
                    else {
                        alert('Erreur SQL');
                        console.log('Erreur : ' + response.data[1]);
                        document.getElementById('password').value='';
                    }
                }
                else{
                    window.location.href = 'index.php';
                }
            })
            .catch(error => {
                alert('Erreur Axios');
                console.log(error);
            });
    }
    else{
        alert('null');
    }
}

function addUser(){
    axios.defaults.baseURL='Controller/';
    const params = new URLSearchParams();
    var ps = document.getElementById('modal-pseudo');
    var pw = document.getElementById('modal-password');
    var r = document.getElementById('modal-role');
    var pseudo = document.getElementById('modal-pseudo').value;
    var password = document.getElementById('modal-password').value;
    var sexe = document.getElementById('modal-sexe').value;
    var role = document.getElementById('modal-role').options[r.selectedIndex].text;
    if (role != 'User' && role != 'Admin'){
        role ='0';
    }
    params.append('function', 'setUser');
    params.append('pseudo', pseudo);
    params.append('password', password);
    params.append('role', role);
    params.append('sexe', sexe);
    axios({
        method: 'post',
        url: 'usersController.php',
        data: params
    })
        .then(response => {
            if (response.data[0]=='Error') {
                if (response.data[1].includes("Duplicate entry")) {
                    alert('Ce pseudo n\'est pas disponible :(');
                    console.log('Erreur doublon: ' + response.data[1]);
                }
                else if (response.data[2] == 'vides' ){
                    alert(response.data[1])
                }
                else{
                    alert('Erreur SQL');
                    console.log(response.data[1]);
                }
            }
            else if (response.data[0]== 'true'){
                alert('L\'utilisateur à bien été ajouté !');
            }
            else{
                alert('Erreur SQL');
                console.log(response.data);
            }
            ps.value='';
            pw.value='';
            r.value='';
        })
        .catch(error => {
            alert('Erreur Axios');
            console.log(error);
        });
}

function updateUser(){
    axios.defaults.baseURL='Controller/';
    const params = new URLSearchParams();
    var ps = document.getElementById('modal-pseudo');
    var pw = document.getElementById('modal-password');
    var r = document.getElementById('modal-role');
    var pseudo = document.getElementById('modal-pseudo').value;
    var password = document.getElementById('modal-password').value;
    var role = document.getElementById('modal-role').options[r.selectedIndex].text;
    if (role != 'User' && role != 'Admin'){
        role ='';
    }
    if (pseudo==''){
        alert('Veuillez renseigné un pseudo..')
    }
    else if (password=='' && role=='' ){
        alert('Modifié au moin le password ou le role');
    }
    else{
        params.append('function', 'putUser');
        params.append('pseudo', pseudo);
        params.append('password', password);
        params.append('role', role);
        axios({
            method: 'post',
            url: 'usersController.php',
            data: params
        })
            .then(response => {
                if (response.data[0]=='Error') {
                    if (response.data[1].includes("Duplicate entry")) {
                        alert('Ce pseudo n\'est pas disponible :(');
                        console.log('Erreur doublon: ' + response.data[1]);
                    }
                    else if (response.data[2] == 'vides' ){
                        alert(response.data[1])
                    }
                    else{
                        alert('Erreur SQL '+response.data[1]);
                        console.log(response.data[1]);
                    }
                }
                else if (response.data[0]== 'true'){
                    alert('L\'utilisateur à bien été modifié ! '+response.data[1]);
                }
                else{
                    alert('Erreur SQL');
                    console.log(response);
                }
            })
            .catch(error => {
                alert('Erreur Axios');
                console.log(error);
            });
    }
}

function deleteUser(){
    axios.defaults.baseURL='Controller/';
    const params = new URLSearchParams();
    var pseudo = document.getElementById('modal-pseudo').value;
    params.append('function', 'deleteUser');
    params.append('pseudo', pseudo);
    if (pseudo==''){
        alert('Veuillez renseigné un pseudo..')
    }
    else {
        axios({
            method: 'post',
            url: 'usersController.php',
            data: params
        })
            .then(response => {
                if (response.data[0] == 'Error') {
                    if (response.data[1].includes("Duplicate entry")) {
                        alert('Ce pseudo n\'est pas disponible :(');
                        console.log('Erreur doublon: ' + response.data[1]);
                    } else {
                        alert('Erreur SQL '+response.data[1]);
                        console.log(response.data[1]);
                    }
                } else if (response.data[0] == 'true') {
                    alert('L\'utilisateur à bien été ajouté !');
                } else {
                    alert('Erreur SQL '+response.data[1]);
                    console.log(response);
                }
            })
            .catch(error => {
                alert('Erreur Axios');
                console.log(error);
            });
    }
}

function logout() {
    axios.defaults.baseURL='Controller/';
    const params = new URLSearchParams();
    params.append('function', 'logout');
    axios({
        method: 'post',
        url: 'usersController.php',
        data: params
    })
        .then(response => {
            if (response.data[0]=='true') {
                window.location.href = 'login.php';
            }
            else{
                alert('Erreur');
            }
        })
        .catch(error => {
            alert('Erreur Axios');
            console.log(error);
        });
}