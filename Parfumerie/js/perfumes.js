function Perfume(){
    if (confirm('Confirmation ?')) {
        axios.defaults.baseURL = 'Controller/';
        const params = new URLSearchParams();
        var nom = document.getElementById('modal-name').value;
        var description = document.getElementById('modal-description').value;
        var image = document.getElementById('modal-file').files[0];
        var prix = document.getElementById('modal-price').value;
        var id = document.getElementById('modal-id').value;
        var fct = document.getElementById('modal-function').value;
        var formData = new FormData();
        if (fct == 'setPerfume' && nom == '' || fct == 'setPerfume' && description == '' || fct == 'setPerfume' && prix == '') {
            alert("Veuillez saisir les champs requis");
        } else if (fct == 'putPerfume' && nom == '' && description == '' && prix == '') {
            alert("Veuillez renseigné au moin un champs");
        } else {
            formData.append('fct', fct);
            formData.append('nom', nom);
            formData.append('description', description);
            formData.append('prix', prix);
            formData.append('id', id);
            if (image != null) {
                formData.append('image', image);
            }
            axios.post('perfumesController.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(response => {
                    if (response.data[0] == 'Error') {
                        // if (response.data[1].includes("Duplicate entry")) {
                        //     console.log('Erreur doublon: ' + response.data[1]);
                        // } else {
                        console.log('Erreur : ' + response.data[1]);
                        // }
                    } else if (response.data[0] == 'true') {
                        alert(response.data[1]);
                        console.log(response);
                        location.reload();

                    } else {
                        alert('Erreur SQL');
                        console.log(response.data);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}