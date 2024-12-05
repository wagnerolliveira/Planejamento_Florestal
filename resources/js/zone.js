
import Papa from 'papaparse';
import axios from 'axios';
function showAlert(alertContainer,message, type) {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.role = 'alert';
    alert.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    alertContainer.appendChild(alert);

    setTimeout(() => {
        alert.classList.remove('show');
        alert.addEventListener('transitionend', () => alert.remove());
    }, 5000);
}

async function getApiToken() {
    try {
        const response = await axios.get('/api/get-token');
        const token = response.data.token;
        const user_name = response.data.user_name;
        const domain_name = response.data.domain_name;
        return { token, user_name, domain_name };
    } catch (error) {
        console.error('Error retrieving token:', error);
        return null;
    }
}


$(document).ready(function () {

    //var URLBase = 'http://localhost:8080'
    var URLBase = 'http://samambaia.ppgmcs.com.br:9001'
    //setActiveMenuItem();

    $(document).on('click', '#btnAddModal', function (e) {
            const inputs = document.querySelectorAll('#AddModal input');
            inputs.forEach(input => {
                if (input.classList.contains('is-invalid')) {
                    input.classList.remove('is-invalid');
                }
                else if (input.classList.contains('is-valid')) {
                    input.classList.remove('is-valid');
                } 
                input.value = '';  
            });
        }
    );

    $(document).on('change', '#fileUploaded', function (e) {
        var file = this.files[0];
        var inputFile = document.getElementById('fileUploaded');
    
        inputFile.classList.remove('is-invalid', 'is-valid');
    
        var alertFile = document.getElementById('fileResponse');
        alertFile.classList.remove(...alertFile.classList);
    
        if (file.type !== 'text/csv') {
            alertFile.innerHTML = 'Erro: O arquivo deve ser do tipo .csv';
            alertFile.classList.add('invalid-feedback');
            inputFile.classList.add('is-invalid');
            return;
        }

        Papa.parse(file, {
            header: true,
            complete: function(results) {
                var data = results.data;
                var headers = results.meta.fields;

                if (!headers.includes('age') || !headers.includes('area')) {
                    alertFile.innerHTML = 'Erro: O arquivo deve conter as colunas "age" e "area"';
                    alertFile.classList.add('invalid-feedback');
                    inputFile.classList.add('is-invalid');
                    return;
                }
    
                alertFile.innerHTML = 'Arquivo válido!';
                alertFile.classList.add('valid-feedback');
                inputFile.classList.add('is-valid');
            },
            error: function() {
                alertFile.innerHTML = 'Erro: Não foi possível ler o arquivo';
                alertFile.classList.add('invalid-feedback');
                inputFile.classList.add('is-invalid');
            }
        });
    
    });


    $(document).on('click', '.add_modal', function (e) {
        e.preventDefault();
        
        const alertAdd = document.getElementById('alertAdd');
        const alertBody = document.getElementById('alertBody');
        $(this).text('Adicionando..');
        $(this).attr("disabled", true);
    
        const title = $('.addTitle').val();
        const description = $('.AddDescription').val();

        const file = $('#fileUploaded')[0].files[0];
    
        if (!title || !file) {
            showAlert(alertAdd,'Todos os campos são obrigatórios.', 'danger');
            $(this).text('Salvar');
            $(this).attr("disabled", false);
            return;
        }
    
        if (file.type !== 'text/csv') {
            showAlert(alertAdd,'O arquivo deve ser do formato CSV.', 'danger');
            $(this).text('Salvar');
            $(this).attr("disabled", false);
            return;
        }
        
        Papa.parse(file, {
            header: true,
            complete: function (results) {
                var data = results.data;
    
                if (!data.length || !data[0].hasOwnProperty('age') || !data[0].hasOwnProperty('area')) {
                    showAlert(alertAdd,'O arquivo CSV deve conter as colunas "age" e "area".', 'danger');
                    $(this).text('Salvar');
                    $(this).attr("disabled", false);
                    return;
                }
    
                var body = {
                    domain_name: '',
                    title: title,
                    description: description,
                    plots: []
                };
    
                data.forEach((row, index) => {
                    if (row.age !== null && row.age !== undefined && row.area !== null && row.area !== undefined) {
                        body.plots.push({
                            id: index + 1,
                            age: parseFloat(row.age),
                            area: parseFloat(row.area),
                            coords: []
                        });
                    }
                });


                getApiToken().then(({ token, user_name, domain_name }) => {
                    if (token) {
                        body.domain_name=domain_name;
                        axios.post(URLBase + "/zone/create", body, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${token}`
                            }
                        })
                        .then(response => {
                            if (response.status === 400) {
                                showAlert(alertAdd,'Houve um erro ao criar a área.', 'danger');
                            } else {
                                $('#AddModal').modal('hide');
                                location.reload();
                                showAlert(alertBody,'Área criada com sucesso.', 'success');
                            }
                            $(this).text('Salvar');
                            $(this).attr("disabled", false);
                        })
                        .catch(error => {
                            showAlert(alertAdd,'Erro: ' + error, 'danger');
                            $(this).text('Salvar');
                            $(this).attr("disabled", false);
                        });
                    } else {
                        showAlert(alertBody,'Houve um erro ao criar a área.', 'danger');
                        $(this).text('Salvar');
                        $(this).attr("disabled", false);
                    }
                });
            }
        });
    });

    $(document).on('click', '#btnEditModal', function (e) {
        //const alertEdit = document.getElementById('alertContainerEdit');
        const alertBody= document.getElementById('alertBody');
        const inputs = document.querySelectorAll('#EditModal input');
        inputs.forEach(input => {
            if (input.classList.contains('is-invalid')) {
                input.classList.remove('is-invalid');
            }
            else if (input.classList.contains('is-valid')) {
                input.classList.remove('is-valid');
            } 
            input.value = '';  
        });

        var zone_id = $(this).val();

        getApiToken().then(({ token, user_name, domain_name })  => {
            if (token) {
                axios.get(URLBase + "/zone/"+zone_id+"/info", {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    if (response.status === 400) {
                        showAlert(alertBody,'Houve um erro ao criar a área.', 'danger');
                    } else {
                        $('#EditModal').modal('show');
                        $('#EditTitle').val(response.data.title);
                        $('#EditDescription').val(response.data.description);
                        $('#btnSaveEventEdit').val(response.data.zone_id);
                    }
                    $(this).text('Salvar');
                    $(this).attr("disabled", false);
                })
                .catch(error => {
                    showAlert(alertBody,'Erro: ' + error, 'danger');
                    $(this).text('Salvar');
                    $(this).attr("disabled", false);
                });
            } else {
                showAlert(alertBody,'Houve um erro ao criar a área.', 'danger');
                $(this).text('Salvar');
                $(this).attr("disabled", false);
            }
        });}
    );

    $(document).on('click', '.edit_modal', function (e) {
        e.preventDefault();
        const alertEdit = document.getElementById('alertEdit');
        $(this).text('Editando..');
        $(this).attr("disabled", true);
    
        var title = $('#EditTitle').val();
        var description = $('#EditDescription').val();
    
        if (!title) {
            showAlert(alertEdit,'O campo título é obrigatório.', 'danger');
            $(this).text('Salvar');
            $(this).attr("disabled", false);
            return;
        }

        var zone_id = $(this).val();

        var body = {
            title: title,
            description: description
        };

        getApiToken().then(({ token, user_name, domain_name }) => {
            if (token) {
                axios.post(URLBase + "/zone/"+zone_id+"/update", body, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    if (response.status === 400) {
                        showAlert(alertAdd,'Houve um erro ao editar a área.', 'danger');
                    } else {
                        $('#AddModal').modal('hide');
                        showAlert(alertBody,'Área editada com sucesso.', 'success');
                        location.reload();
                    }
                    $(this).text('Salvar');
                    $(this).attr("disabled", false);
                })
                .catch(error => {
                    showAlert(alertAdd,'Erro: ' + error, 'danger');
                    $(this).text('Salvar');
                    $(this).attr("disabled", false);
                });
            } else {
                showAlert(alertBody,'Houve um erro ao editar a área.', 'danger');
            }
        });

    });

    $(document).on('click', '#btnDeleteModal', function () {
        var zone_id = $(this).val();
        $('#DeleteModal').modal('show');
        $('#btnEventDelete').val(zone_id);
    });

    $(document).on('click', '.delete_modal', function (e) {
        e.preventDefault();

        $(this).text('Apagando..');
    
        var zone_id = $(this).val();
        
        getApiToken().then(({ token, user_name, domain_name }) => {
            if (token) {
                console.log(token)
                axios.delete(URLBase + "/zone/"+zone_id+"/delete", {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    console.log(response.data)
                    if (response.status === 400) {
                        showAlert(alertDelete,'Houve um erro ao apagar a área.', 'danger');
                    } else {
                        $('#DeleteModal').modal('hide');
                        showAlert(alertBody,'Área apagada com sucesso.', 'success');
                        location.reload();
                    }
                    $(this).text('Sim, apagar');
                    $(this).attr("disabled", false);
                })
                .catch(error => {
                    showAlert(alertBody,'Erro: ' + error, 'danger');
                    $(this).text('Sim, apagar');
                    $(this).attr("disabled", false);
                });
            } else {
                showAlert(alertBody,'Houve um erro ao apagar a área.', 'danger');
                $(this).text('Sim, apagar');
                $(this).attr("disabled", false);
            }
        });
        
    });



});