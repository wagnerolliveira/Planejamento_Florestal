@extends('layouts.layout_dashboard')

@section('styles')
    @vite(['resources/css/job.css'])
@endsection

@section('content')
<div>
    <div id="success_message"></div>
    <div class="container-fluid main_content p-3 m-3">
        <header class="d-flex justify-content-between align-items-center bg-light p-3 header_jobs">
            <h2 class="h3 mb-3">Tarefas</h2>
            <button type="button" class="btn btn-primary light" data-bs-toggle="modal" data-bs-target="#taskAddModal" id="btnAddtask">Nova Tarefa</button>
        </header>
        <div class="row">
            <hr>
            <div id="alertBody"></div> 
            <div class="table-responsive">
                <table id="tab" class="table table-striped table-hover" style="font-size: 12px">
                    <thead>
                        <tr class="table-primary">
                            <th class="taCentro" onclick="ordernaTAB(0)"> 
                                Tarefa <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>
                            <th class="taCentro" onclick="ordernaTAB(1)"> 
                                Usuário <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>
                            <th class="taCentro" onclick="ordernaTAB(2)"> 
                                Aréa de Plantio <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>

                            <th class="taCentro" onclick="ordernaTAB(3)"> 
                                Configuração <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>
                            
                            <th class="taCentro" onclick="ordernaTAB(3)"> 
                                Status <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>

                            <th class="taCentro"> 
                                Ações<i style="padding-left: 5px;" ></i>
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>    
                        @foreach ($jobs as $job)
                            <tr>                            
                                <td style="text-align: center;">{{$job['job_id']}}</td>
                                <td style="text-align: center;">{{$job['user_id']}}</td>
                                <td style="text-align: center;">{{$job['zone_id']}}</td> 
                                <td style="text-align: center;">{{$job['config_id']}}</td> 
                                <td style="text-align: center;">{{$job['status']}}</td> 
                                <td style="text-align: center;">
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Detalhes"
                                        onclick="detalhesJob('{{$job['job_id']}}')">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Pausar"
                                        onclick="pausarJob('{{$job['job_id']}}')">
                                        <i class="fa fa-pause"></i>
                                    </button>                                                    
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Continuar"
                                        onclick="continuarJob('{{$job['job_id']}}')">
                                        <i class="fa fa-play"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
            
                        @if (empty($jobs[0]))
                            <tr>
                                <td colspan="7" style="text-align: center;" ><b>Não há nenhuma tarefa criada</b></td>
                            </tr>
                        @endif                
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="taskAddModal" tabindex="-1" role="dialog" aria-labelledby="taskAddModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header pb-0">
                    <h3 id="taskAddModalTitle" class="modal-title">Criar Nova Tarefa</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body">
                    <div id="alertAdd"></div> 
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="taskAddArea" class="form-label">Área de Plantio</label>
                                <select id="taskAddArea" name="taskAddArea" class="form-select form-control AddArea"> 
                                    <!-- Linhas serão adicionadas dinamicamente -->  
                                </select>
                                <div class="invalid-feedback">Informe a Área de Plantio</div>
                            </div>
                        </div>  
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="taskAddConfig" class="form-label">Configuração</label>
                                <select id="taskAddConfig" name="taskAddConfig" class="form-select form-control taskAddConfig">  
                                    <!-- Linhas serão adicionadas dinamicamente -->
                                </select>
                                <div class="invalid-feedback">Informe a Configuração</div>
                            </div>
                        </div>
                    </div>
                    <div class="dataconfig">
                        <hr>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg">
                                    <label for="dataconfig_title" class="form-label">Título</label>
                                    <input type="text" class="form-control dataconfig_title" id="dataconfig_title" placeholder="Insira o título" name="dataconfig_title">
                                    <div class="invalid-feedback">Insira o título</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg">
                                    <label for="dataconfig_start_year" class="form-label">Ano Inicio
                                        <i class="fas fa-question-circle" data-toggle="tooltip" title="Ano de início do horizonte de planejamento"></i>
                                    </label>
                                    <input type="number"  class="form-control dataconfig_start_year" id="dataconfig_start_year" name="dataconfig_start_year" min="1900" max="2999" step="1" placeholder="Insira o Ano">
                                    <div class="invalid-feedback">Insira o ano de início</div>
                                </div>
                                <div class="col-lg">
                                    <label for="dataconfig_end_year" class="form-label">Ano Final
                                        <i class="fas fa-question-circle" data-toggle="tooltip" title="Ano de fim do horizonte de planejamento"></i>
                                    </label>
                                    <input type="number" class="form-control dataconfig_end_year" id="dataconfig_end_year" name="dataconfig_end_year" min="1900" max="2999" step="1" placeholder="Insira o Ano">
                                    <div class="invalid-feedback">Insira o ano final</div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-lg">
                                    <label for="dataconfig_runtime" class="form-label">Tempo limite
                                        <i class="fas fa-question-circle" data-toggle="tooltip" title="Tempo limite de processamento em segundos"></i>
                                    </label>
                                    <input type="text" class="form-control dataconfig_runtime" id="dataconfig_runtime" placeholder="Insira o tempo limite" name="dataconfig_runtime">
                                    <div class="invalid-feedback">Insira o tempo limite</div>
                                </div>
                                <div class="col-lg">
                                    <label for="dataconfig_target_vpl" class="form-label"> Valor alvo do VPL (R$)
                                        <i class="fas fa-question-circle" data-toggle="tooltip" title="Valor alvo em R$ do VPL da solução"></i>
                                    </label>
                                    <input type="text" class="form-control dataconfig_target_vpl" id="dataconfig_target_vpl" name="dataconfig_target_vpl" placeholder="Insira o valor alvo">
                                    <div class="invalid-feedback">Insira o valor alvo</div>
                                </div>
                            </div>
                        </div>    
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label for="restricoes" class="form-label">Restrições</label>
                                <table class="table table-bordered" id="restricoesTable">
                                    <thead>
                                        <tr>
                                            <th>Ano</th>
                                            <th>Mín. de Produção</th>
                                            <th>Máx. de Produção</th>
                                            <th>Expectativa de Produção/Área</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody id="restricoesTableBody">
                                        <!-- Linhas serão adicionadas dinamicamente -->
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary" id="addRowBtn">Adicionar Linha</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary light add_task" id="btnSaveEvent">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="taskDetailModal" tabindex="-1" role="dialog" aria-labelledby="taskDetailModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header pb-0">
                <h3 id="taskDetailModalTitle" class="modal-title">Detalhes da Tarefa</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg">
                            <label for="details_id_job" class="form-label">Id da Tarefa</label>
                            <input type="text" class="form-control details_id_job" id="details_id_job" placeholder="Id da Tarefa" name="details_id_job">
                        </div>
                        <div class="col-lg">
                            <label for="details_id_config" class="form-label">Id da Configuração</label>
                            <input type="text" class="form-control details_id_config" id="details_id_config" placeholder="Id da Configuração" name="details_id_config">
                        </div>
                    </div>  
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-lg">
                            <label for="details_zone" class="form-label">Id da Area</label>
                            <input type="text" class="form-control details_zone" id="details_zone" placeholder="Id da Area" name="details_zone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg">
                            <label for="details_status" class="form-label">Status</label>
                            <input type="text" class="form-control details_status" id="details_status" placeholder="Status" name="details_status">
                        </div>
                    </div>
                </div>
                <div class="dataconfig">
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="dataconfig_title" class="form-label">Título</label>
                                <input type="text" class="form-control dataconfig_title" id="dataconfig_title" placeholder="Insira o título" name="dataconfig_title">
                                <div class="invalid-feedback">Insira o título</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="dataconfig_start_year" class="form-label">Ano Inicio
                                    <i class="fas fa-question-circle" data-toggle="tooltip" title="Ano de início do horizonte de planejamento"></i>
                                </label>
                                <input type="number"  class="form-control dataconfig_start_year" id="dataconfig_start_year" name="dataconfig_start_year" min="1900" max="2999" step="1" placeholder="Insira o Ano">
                                <div class="invalid-feedback">Insira o ano de início</div>
                            </div>
                            <div class="col-lg">
                                <label for="dataconfig_end_year" class="form-label">Ano Final
                                    <i class="fas fa-question-circle" data-toggle="tooltip" title="Ano de fim do horizonte de planejamento"></i>
                                </label>
                                <input type="number" class="form-control dataconfig_end_year" id="dataconfig_end_year" name="dataconfig_end_year" min="1900" max="2999" step="1" placeholder="Insira o Ano">
                                <div class="invalid-feedback">Insira o ano final</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="dataconfig_runtime" class="form-label">Tempo limite
                                    <i class="fas fa-question-circle" data-toggle="tooltip" title="Tempo limite de processamento em segundos"></i>
                                </label>
                                <input type="text" class="form-control dataconfig_runtime" id="dataconfig_runtime" placeholder="Insira o tempo limite" name="dataconfig_runtime">
                                <div class="invalid-feedback">Insira o tempo limite</div>
                            </div>
                            <div class="col-lg">
                                <label for="dataconfig_target_vpl" class="form-label"> Valor alvo do VPL (R$)
                                    <i class="fas fa-question-circle" data-toggle="tooltip" title="Valor alvo em R$ do VPL da solução"></i>
                                </label>
                                <input type="text" class="form-control dataconfig_target_vpl" id="dataconfig_target_vpl" name="dataconfig_target_vpl" placeholder="Insira o valor alvo">
                                <div class="invalid-feedback">Insira o valor alvo</div>
                            </div>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-lg">
                        <div class="mb-3">
                            <label for="restricoes" class="form-label">Restrições</label>
                            <table class="table table-bordered" id="restricoesTable">
                                <thead>
                                    <tr>
                                        <th>Ano</th>
                                        <th>Mín. de Produção</th>
                                        <th>Máx. de Produção</th>
                                        <th>Expectativa de Produção/Área</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody id="restricoesTableBody">
                                    <!-- Linhas serão adicionadas dinamicamente -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-primary" id="addRowBtn">Adicionar Linha</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
</div>
    
@endsection

@section('scripts')
    @vite(['resources/js/job.js'])
@endsection