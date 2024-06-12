@extends('layouts.layout_dashboard')

@section('styles')
    @vite(['resources/css/zones.css'])
@endsection

@section('content')
<div>
    <div id="success_message"></div>
    <div class="container-fluid main_content p-3 m-3">
        <header class="d-flex justify-content-between align-items-center bg-light p-3 header_zones">
            <h2 class="h3 mb-3">Áreas</h2>
            <button type="button" class="btn btn-primary light" data-bs-toggle="modal" data-bs-target="#restrictionAddModal" id="btnAddrestriction">Nova Área</button>
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
                        {{-- @foreach ($analises as $analise)
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
                        @endif                 --}}
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
    <div class="modal fade" id="restrictionAddModal" tabindex="-1" role="dialog" aria-labelledby="restrictionAddModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header pb-0">
                    <h3 id="restrictionAddModalTitle" class="modal-title">Adicionar Nova Medição</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="restrictionAddTemperature" class="form-label">Temperatura</label>
                                <input type="text" class="form-control addTemperature" id="restrictionAddTemperature" placeholder="Insira a Temperatura" name="addTemperature">
                                <div class="invalid-feedback">Insira a Temperatura</div>
                            </div>
                            </span>
                            <div class="col-lg">
                                <label for="restrictionAddHumidity" class="form-label">Umidade</label>
                                <input type="text" class="form-control addHumidity" id="restrictionAddHumidity" placeholder="Insira a Umidade" name="addHumidity">
                            <div class="invalid-feedback">Insira a Umidade</div>
                        </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label for="restrictionAddDateMeasurement" class="form-label">Data da Medição</label>
                                <input type="date" class="form-control addDateMeasurement" id="restrictionAddDateMeasurement" name="addDateMeasurement">
                                <div class="invalid-feedback">Insira a data da Medição</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <label for="restrictionAddObs" class="form-label">Observações</label>
                        <textarea class="form-control addObs" id="restrictionAddObs" placeholder="Observações/detalhes da medição" rows="5" name="addObs"></textarea>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary light add_restriction" id="btnSaveEvent">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->

    <div class="modal fade" id="restrictionEditModal" tabindex="-1" role="dialog" aria-labelledby="restrictionEditModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header pb-0">
                    <h3 id="restrictionEditModalTitle" class="modal-title">Editar Medição</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Body -->
                <div class="modal-body">
                    <input type="hidden" name="id_restriction" id="id_restriction" value="">
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-lg">
                                <label for="restrictionEditTemperature" class="form-label">Temperatura</label>
                                <input type="text" class="form-control EditTemperature" id="restrictionEditTemperature" placeholder="Insira a Temperatura" name="EditTemperature">
                                <div class="invalid-feedback">Insira a Temperatura</div>
                            </div>
                            </span>
                            <div class="col-lg">
                                <label for="restrictionEditHumidity" class="form-label">Umidade</label>
                                <input type="text" class="form-control EditHumidity" id="restrictionEditHumidity" placeholder="Insira a Umidade" name="EditHumidity">
                            <div class="invalid-feedback">Insira a Umidade</div>
                        </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label for="restrictionEditDateMeasurement" class="form-label">Data da Medição</label>
                                <input type="date" class="form-control EditDateMeasurement" id="restrictionEditDateMeasurement" value="2018-07-22" name="EditDateMeasurement">
                                <div class="invalid-feedback">Insira a data da Medição</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <label for="restrictionEditObs" class="form-label">Observações</label>
                        <textarea class="form-control EditObs" id="restrictionEditObs" placeholder="Observações/detalhes da medição" rows="5" name="EditObs"></textarea>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary light edit_restriction" id="btnSaveEvent">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="restrictionDeleteModal" tabindex="-1" aria-labelledby="restrictionDeleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="restrictionDeleteModal">Apagar Ciclo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Deseja apagar este registro?</h4>
                    <input type="hidden" id="deleteing_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary delete_restriction">Sim, apagar</button>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('scripts')

@endsection