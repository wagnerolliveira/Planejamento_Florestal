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
            <button type="button" class="btn btn-primary light" data-bs-toggle="modal" data-bs-target="#taskAddModal" id="btnAddtask">Nova Análise</button>
        </header>
        <div class="row">
            <hr>
            <div class="table-responsive">
                <table id="tab" class="table table-striped table-hover" style="font-size: 12px">
                    <thead>
                        <tr class="table-primary">
                            <th class="taCentro" onclick="ordernaTAB(0)"> 
                                Nome <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>
                            <th class="taCentro" onclick="ordernaTAB(1)"> 
                                Data da Análise <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>
                            <th class="taCentro" onclick="ordernaTAB(2)"> 
                                Status <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>

                            <th class="taCentro" onclick="ordernaTAB(3)"> 
                                Mínimo <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>
                            
                            <th class="taCentro" onclick="ordernaTAB(3)"> 
                                Máximo <i style="padding-left: 5px;" class="fa fa-sort"></i>
                            </th>

                            <th class="taCentro"> 
                                Ações<i style="padding-left: 5px;" ></i>
                            </th>
                        </tr>
                    </thead>
                    
                    <tbody>    
                        @foreach ($analises as $analise)
                            <tr>                            
                                <td style="text-align: center;">{{$analise['nome']}}</td>
                                <td style="text-align: center;">{{$analise['data']}}</td>
                                <td style="text-align: center;">{{$analise['status']}}</td> 
                                <td style="text-align: center;">{{$analise['valor_minimo']}}</td> 
                                <td style="text-align: center;">{{$analise['valor_maximo']}}</td> 
                                <td style="text-align: center;">
                                    
                                </td>
                            </tr>
                        @endforeach
            
                        @if (empty($analises[0]))
                            <tr>
                                <td colspan="7" style="text-align: center;" ><b>Não há nenhuma medição informada</b></td>
                            </tr>
                        @endif                
                    </tbody>
                </table>
                {{-- @if (!empty($analises[0]))
                    <div>
                        {{$analises->appends(request()->except('page'))->links('vendor.pagination.CustomPagination')}}
                    </div>
                @endif --}}
            </div>
            
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="taskAddModal" tabindex="-1" role="dialog" aria-labelledby="taskAddModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header pb-0">
                    <h3 id="taskAddModalTitle" class="modal-title">Adicionar Nova Medição</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="taskAddTemperature" class="form-label">Temperatura</label>
                                <input type="text" class="form-control addTemperature" id="taskAddTemperature" placeholder="Insira a Temperatura" name="addTemperature">
                                <div class="invalid-feedback">Insira a Temperatura</div>
                            </div>
                            </span>
                            <div class="col-lg">
                                <label for="taskAddHumidity" class="form-label">Umidade</label>
                                <input type="text" class="form-control addHumidity" id="taskAddHumidity" placeholder="Insira a Umidade" name="addHumidity">
                            <div class="invalid-feedback">Insira a Umidade</div>
                        </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label for="taskAddDateMeasurement" class="form-label">Data da Medição</label>
                                <input type="date" class="form-control addDateMeasurement" id="taskAddDateMeasurement" name="addDateMeasurement">
                                <div class="invalid-feedback">Insira a data da Medição</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <label for="taskAddObs" class="form-label">Observações</label>
                        <textarea class="form-control addObs" id="taskAddObs" placeholder="Observações/detalhes da medição" rows="5" name="addObs"></textarea>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary light add_task" id="btnSaveEvent">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->

    <div class="modal fade" id="taskEditModal" tabindex="-1" role="dialog" aria-labelledby="taskEditModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header pb-0">
                    <h3 id="taskEditModalTitle" class="modal-title">Editar Medição</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body">
                    <input type="hidden" name="id_task" id="id_task" value="">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="taskEditTemperature" class="form-label">Temperatura</label>
                                <input type="text" class="form-control EditTemperature" id="taskEditTemperature" placeholder="Insira a Temperatura" name="EditTemperature">
                                <div class="invalid-feedback">Insira a Temperatura</div>
                            </div>
                            </span>
                            <div class="col-lg">
                                <label for="taskEditHumidity" class="form-label">Umidade</label>
                                <input type="text" class="form-control EditHumidity" id="taskEditHumidity" placeholder="Insira a Umidade" name="EditHumidity">
                            <div class="invalid-feedback">Insira a Umidade</div>
                        </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label for="taskEditDateMeasurement" class="form-label">Data da Medição</label>
                                <input type="date" class="form-control EditDateMeasurement" id="taskEditDateMeasurement" value="2018-07-22" name="EditDateMeasurement">
                                <div class="invalid-feedback">Insira a data da Medição</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <label for="taskEditObs" class="form-label">Observações</label>
                        <textarea class="form-control EditObs" id="taskEditObs" placeholder="Observações/detalhes da medição" rows="5" name="EditObs"></textarea>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary light edit_task" id="btnSaveEvent">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="taskDeleteModal" tabindex="-1" aria-labelledby="taskDeleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskDeleteModal">Apagar Ciclo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Deseja apagar este registro?</h4>
                    <input type="hidden" id="deleteing_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary delete_task">Sim, apagar</button>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('scripts')

@endsection