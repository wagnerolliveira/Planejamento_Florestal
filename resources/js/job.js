const URLBase = 'http://samambaia.ppgmcs.com.br:9001'
async function getApiToken() {
    try {
        const response = await axios.get('/api/get-token');
        const token = response.data.token;
        const user_name = response.data.user_name;
        const domain_name = response.data.domain_name;
        return { token, user_name, domain_name };
    } catch (error) {
        console.error('Error retrieving token:', error);
        window.location.href = '/login';
        return null;
    }
}

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

document.addEventListener('DOMContentLoaded', function() {
    const taskAddArea = document.getElementById("taskAddArea");
    const taskAddConfig = document.getElementById("taskAddConfig");
    const configFields = [
        document.getElementById("dataconfig_title"),
        document.getElementById("dataconfig_start_year"),
        document.getElementById("dataconfig_end_year"),
        document.getElementById("dataconfig_runtime"),
        document.getElementById("dataconfig_target_vpl")
    ];

    const restricoesTableBody = document.getElementById('restricoesTableBody');
    const addRowBtn = document.getElementById('addRowBtn');

    const alertAdd = document.getElementById('alertAdd');
    const alertBody = document.getElementById('alertBody');

    const btnAddtask = document.getElementById("btnAddtask");

    btnAddtask.addEventListener("click", function () {
        toggleConfigFields(true);
        getAreas();
    });

    taskAddConfig.addEventListener("change", function () {
        const selectedConfig = taskAddConfig.value;
        loadFieldsConfig(selectedConfig);
    });

    taskAddArea.addEventListener("change", function () {
        const selectedArea = taskAddArea.value;
        if (selectedArea) {
            getConfigs(selectedArea);
        } else {
            taskAddConfig.innerHTML = `
                <option value="">Selecione a configuração</option>
                <option value="create_new">Criar nova configuração</option>
            `;
        }
    });

    document.getElementById('btnSaveEvent').addEventListener('click', function() {
        const saveButton = document.getElementById('btnSaveEvent');
        let formIsValid = true;
    
        const taskAddArea = document.getElementById('taskAddArea');
        const taskAddConfig = document.getElementById('taskAddConfig');
        const configFields = document.querySelectorAll('.dataconfig input');
        configFields.forEach(field => {
            if (field.value.trim() === "") {
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
    
        const restricoesTableBody = document.getElementById('restricoesTableBody');
        const rows = restricoesTableBody.querySelectorAll('tr');
        if (rows.length === 0) {
            showAlert('Adicione pelo menos uma linha na tabela de Restrições.');
        } else {
            rows.forEach(row => {
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    if (input.value.trim() === "") {
                        input.classList.add('is-invalid');
                    }
                });
            });
        }
    
        if (formIsValid) {
            // saveButton.disabled = true;
            // saveButton.textContent = 'Adicionando...';

            const area = taskAddArea.value;
            let config = taskAddConfig.value
            if (config === 'create_new'){
                const data = {
                    title: document.getElementById('dataconfig_title').value,
                    planning_horizon_start_year: document.getElementById('dataconfig_start_year').value,
                    planning_horizon_end_year: document.getElementById('dataconfig_end_year').value,
                    runtime_limit: document.getElementById('dataconfig_runtime').value,
                    target_vpl: document.getElementById('dataconfig_target_vpl').value,
                    production_constraints: [] 
                };
        
                rows.forEach(row => {
                    const rowData = {
                        year: row.querySelector('select[name="ano"]').value,
                        minimum_productivity: row.querySelector('input[name="minimo_producao"]').value,
                        maximum_productivity: row.querySelector('input[name="maximo_producao"]').value,
                        expected_production_per_area: row.querySelector('input[name="expectativa_producao"]').value
                    };
                    data.production_constraints.push(rowData);
                });

                getApiToken().then(({ token, user_name, domain_name }) => {
                    if (token) {
                        console.log(token);
                        axios.post(URLBase + "/zone/"+area+"/settings/validate", data, {
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': `Bearer ${token}`
                            }
                        })
                        .then(response => {
                            console.log(response);
                            if (response.status === 400) {
                                showAlert(alertAdd,'Houve um erro ao validar a configuração. Tente novamente.', 'danger');
                                return;
                            } else {
                                config = response.data.config_id;
                            }
                            
                        })
                        .catch(error => {
                            showAlert(alertAdd,'Erro: ' + error, 'danger');
                            return;
                        });
                    } else {
                        showAlert(alertAdd,'Houve um erro ao validar a configuração.', 'danger');
                        return;
                    }
                });
            }
            
            var body = {
                zone_id : area,
                config_id: config
            }

            getApiToken().then(({ token, user_name, domain_name }) => {
                if (token) {
                    console.log(body)
                    axios.post(URLBase + "/job/create", body , {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    })
                    .then(response => {
                        if (response.status === 400) {
                            showAlert(alertAdd,'Houve um erro ao criar a tarefa. Tente novamente.', 'danger');
                            return;
                        } else {
                            $('#AddModal').modal('hide');
                            showAlert(alertBody,'Tarefa criada com sucesso!!', 'success');
                            reloadTableJobs();
                            
                        }
                        
                    })
                    .catch(error => {
                        showAlert(alertAdd,'Erro: ' + error, 'danger');
                        return;
                    });
                } else {
                    showAlert(alertAdd,'Houve um erro ao criar a tarefa.', 'danger');
                    return;
                }
            }); 
            
        }
    });

    document.getElementById('addRowBtn').addEventListener('click', adicionarLinha);

    function getAreas(){   
        getApiToken().then(({ token, user_name, domain_name }) => {
            if (token) {
                axios.get(URLBase + "/zone/"+domain_name+"/list", {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    if (response.status === 400) {
                        showAlert(alertAdd,'Houve um erro ao carregar  as áreas de plantio. Tente novamente.', 'danger');
                    } else {
                        taskAddArea.innerHTML = `
                            <option value="">Selecione a area</option>
                        `;

                        response.data.forEach(zone => {
                            const option = document.createElement("option");
                            option.value = zone.zone_id;
                            option.text = zone.title;
                            taskAddArea.appendChild(option);
                        });
                    }
                    
                })
                .catch(error => {
                    showAlert(alertAdd,'Erro: ' + error, 'danger');
                });
            } else {
                showAlert(alertAdd,'Houve um erro ao carregar  as áreas de plantio.', 'danger');
            }
        });
    }

    function getConfigs(area){
        
        getApiToken().then(({ token, user_name, domain_name }) => {
            if (token) {
                axios.get(URLBase + "/zone/"+area+"/settings/list", {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    if (response.status === 400) {
                        showAlert(alertAdd,'Houve um erro ao carregar  as configurações da área.', 'danger');
                    } else {
                        taskAddConfig.innerHTML = `
                            <option value="">Selecione a configuração</option>
                            <option value="create_new">Criar nova configuração</option>
                        `;
                        response.data.forEach(config => {
                            const option = document.createElement("option");
                            option.value = config.config_id;
                            option.text = config.config_id;
                            taskAddConfig.appendChild(option);
                        });
                    }
                    
                })
                .catch(error => {
                    showAlert(alertAdd,'Erro: ' + error, 'danger');
                });
            } else {
                showAlert(alertAdd,'Houve um erro ao carregar  as configurações da área.', 'danger');
            }
        });
    }

    function reloadTableJobs() {
        getApiToken().then(({ token, user_name, domain_name }) => {
            if (token) {
                axios.get(URLBase + "/job/"+domain_name+"/list", {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                })
                .then(response => {
                    const tbody = document.querySelector('#tab tbody');
                    tbody.innerHTML = '';
        
                    if (response.data.length > 0) {
                        response.data.forEach(job => {
                            const row = `
                                <tr>
                                    <td style="text-align: center;">${job.job_id}</td>
                                    <td style="text-align: center;">${job.user_id}</td>
                                    <td style="text-align: center;">${job.zone_id}</td>
                                    <td style="text-align: center;">${job.config_id}</td>
                                    <td style="text-align: center;">${job.status}</td>
                                    <td style="text-align: center;">
                                        <button type="button" class="btn btn-sm btn-info" onclick="detalhesJob('${job.job_id}')">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" onclick="pausarJob('${job.job_id}')">
                                            <i class="fa fa-pause"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-success" onclick="continuarJob('${job.job_id}')">
                                            <i class="fa fa-play"></i>
                                        </button>
                                    </td>
                                </tr>
                            `;
                            tbody.innerHTML += row;
                        });
                    } else {
                        tbody.innerHTML = `<tr><td colspan="7" style="text-align: center;"><b>Não há nenhuma tarefa criada</b></td></tr>`;
                    }
                })
                .catch(error => console.error('Erro ao atualizar a tabela:', error));
            } else {
                showAlert(alertAdd,'Houve um erro ao carregar as tarefas. Recarregue a página.', 'danger');
            }
        });
    }

    

    function toggleConfigFields(disabled, nullValue = true) {
        configFields.forEach(field => {
            field.disabled = disabled;
            if (disabled && nullValue){
                field.value = "";
            }
        });

        const rows = restricoesTableBody.querySelectorAll('tr');
        rows.forEach(row => {
            const inputs = row.querySelectorAll('input, select, button');
            inputs.forEach(input => {
                input.disabled = disabled;
                if (disabled && nullValue) {
                    input.value = "";
                }
            });
        });

        addRowBtn.disabled = disabled;
    }

    function loadFieldsConfig(config) {
        if (config === 'create_new') {
            toggleConfigFields(false);
        } else if (config) {
            const area = taskAddArea.value;
            console.log(area,config);
            getApiToken().then(({ token, user_name, domain_name }) => {
                if (token) {
                    axios.get(URLBase + "/zone/"+area+"/settings/"+config, {
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${token}`
                        }
                    })
                    .then(response => {
                        console.log(response)
                        if (response.status === 400) {
                            showAlert(alertAdd,'Houve um erro ao carregar as informações da configuração. Tente novamente.', 'danger');
                        } else {
                            document.getElementById("dataconfig_title").value = response.data.config_id;
                            document.getElementById("dataconfig_start_year").value = response.data.planning_horizon_start_year;
                            document.getElementById("dataconfig_end_year").value = response.data.planning_horizon_end_year;
                            document.getElementById("dataconfig_runtime").value = response.data.runtime_limit;
                            document.getElementById("dataconfig_target_vpl").value = response.data.target_vpl;
                            const productionConstraints = response.data.production_constraints;
                            const tableBody = document.getElementById("restricoesTableBody");

                            tableBody.innerHTML = "";

                            productionConstraints.forEach((constraint) => {
                                adicionarLinha(constraint.year, constraint.minimum_productivity, constraint.maximum_productivity, constraint.expected_production_per_area);
                            });

                            toggleConfigFields(true, false);
                        }
                        
                    })
                    .catch(error => {
                        showAlert(alertAdd,'Erro: ' + error, 'danger');
                    });
                } else {
                    showAlert(alertAdd,'Houve um erro ao carregar as informações da configuração. Tente novamente.', 'danger');
                }
            });
        } else {
            toggleConfigFields(true);
        }
    }

    function gerarOpcoesAno() {
        let opcoes = '<option value="ALL">Todos</option>';
        for (let ano = 1900; ano <= 2999; ano++) {
            opcoes += `<option value="${ano}">${ano}</option>`;
        }
        return opcoes;
    }

    function adicionarLinha(ano = '', minimo = '', maximo = '', expectativa = '') {
        const tableBody = document.getElementById('restricoesTableBody');
        const novaLinha = document.createElement('tr');

        novaLinha.innerHTML = `
            <td>
                <select class="form-select" name="ano" required>
                    ${gerarOpcoesAno(ano)}
                </select>
                <div class="invalid-feedback">Insira o Ano</div>
            </td>
            <td>
                <input type="number" class="form-control" name="minimo_producao" placeholder="Min" value="${minimo}" required>
                <div class="invalid-feedback">Insira o mínimo de produção</div>
            </td>
            <td>
                <input type="number" class="form-control" name="maximo_producao" placeholder="Max" value="${maximo}" required>
                <div class="invalid-feedback">Insira o máximo de produção</div>
            </td>
            <td>
                <input type="number" class="form-control" name="expectativa_producao" placeholder="Expectativa" value="${expectativa}" required>
                <div class="invalid-feedback">Insira expectativa de produção</div>
            </td>
            <td>
                <button type="button" class="btn btn-danger btnExcluir" onclick="removerLinha(this)">Excluir</button>
            </td>
        `;

        tableBody.appendChild(novaLinha);
    }

    

    window.removerLinha = function(botao) {
        const tableBody = document.getElementById('restricoesTableBody');
        if (tableBody.rows.length > 1) {
            const linha = botao.closest('tr');
            linha.remove();
        } else {
            showAlert(alertAdd,'Você deve manter pelo menos uma linha de restrição.', 'warning');
        }
    }

    adicionarLinha();
    reloadTableJobs();

    setInterval(reloadTableJobs, 30000);

    
});

window.detalhesJob = function(job_id) {
    const alertBody = document.getElementById('alertBody');
    getApiToken().then(({ token, user_name, domain_name }) => {
        console.log(token);
        if (token) {
            axios.get(URLBase + "/job/"+job_id+"/details", {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                console.log(response)
                if (response.status === 400) {
                    showAlert(alertBody,'Houve um erro ao carregar os detalhes da tarefa.', 'danger');
                } else {
                    showAlert(alertBody,'Tarefa pausada com sucesso.', 'success');
                }
                
            })
            .catch(error => {
                showAlert(alertBody,'Erro: ' + error, 'danger');
            });
        } else {
            showAlert(alertBody,'Houve um erro ao carregar os detalhes da tarefa.', 'danger');
        }
    });
};

window.pausarJob = function(job_id) {
    const alertBody = document.getElementById('alertBody');
    getApiToken().then(({ token, user_name, domain_name }) => {
        console.log(token);
        if (token) {
            axios.put(URLBase + "/job/"+job_id+"/pause", {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (response.status === 400) {
                    showAlert(alertBody,'Houve um erro ao pausar a tarefa.', 'danger');
                } else {
                    showAlert(alertBody,'Tarefa pausada com sucesso.', 'success');
                }
                
            })
            .catch(error => {
                showAlert(alertBody,'Erro: ' + error, 'danger');
            });
        } else {
            showAlert(alertBody,'Houve um erro ao pausar a tarefa.', 'danger');
        }
    });
};

window.continuarJob = function(job_id) {
    const alertBody = document.getElementById('alertBody');
    getApiToken().then(({ token, user_name, domain_name }) => {
        console.log(token);
        if (token) {
            axios.put(URLBase + "/job/"+job_id+"/resume", {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            })
            .then(response => {
                if (response.status === 400) {
                    showAlert(alertBody,'Houve um erro ao retormar a tarefa.', 'danger');
                } else {
                    showAlert(alertBody,'Tarefa retormada com sucesso.', 'success');
                }
                
            })
            .catch(error => {
                showAlert(alertBody,'Erro: ' + error, 'danger');
            });
        } else {
            showAlert(alertBody,'Houve um erro ao retormar a tarefa.', 'danger');
        }
    });
};