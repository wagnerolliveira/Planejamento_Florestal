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
            <button type="button" class="btn btn-primary light" data-bs-toggle="modal" data-bs-target="#AddModal" id="btnAddModal">Nova Área</button>
        </header>
        <div class="row">
            <hr>
            <div id="alertBody"></div> 
            @foreach ($zones as $zone)
            <div class="col-md-2 col-sm-4 col-6 justify-content-around my-2 contentCard">
                <div class="cardZone">
                    <div class="row imgZone justify-content-center">
                        <div class="image-container">
                            <img src={{ Vite::asset('resources/images/planting.png') }} alt="Imagem do card">
                        </div>
                    </div>
                    <div class="row">
                        <div class="infoZone">
                            
                            <h2><b>Título:</b> {{$zone['title']}}</h2>
                            <p><b>Domínio:</b> ADMIN</p>
                            <p><b>Descrição:</b> {{ strlen($zone['description']) > 80 ? substr($zone['description'], 0, 80) . '...' : $zone['description'] }}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col d-flex justify-content-between buttonsZone">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#EditModal" id="btnEditModal" value="{{$zone['zone_id']}}">EDITAR</button>
                            <button type="button" data-bs-toggle="modal" data-bs-target="#DeleteModal" id="btnDeleteModal" value="{{$zone['zone_id']}}">APAGAR</button>
                        </div> 
                    </div>
                </div>
            </div>
            @endforeach
                @if (empty($zones[0]))
                    <h3 style="text-align: center;" ><b>Não há nenhuma área cadastrada para este domínio</b></h3>
                @endif
            </div>            
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered p-3" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="alertAdd"></div> 
                    <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label for="AddTitle" class="form-label">Título</label>
                                <input type="text" class="form-control addTitle" id="AddTitle" placeholder="Insira o título" name="addTitle">
                                <div class="invalid-feedback">Insira o título</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="AddDescription" class="form-label">Descrição</label>
                        <textarea class="form-control AddDescription" id="AddDescription" placeholder="Observações/detalhes da área" rows="5" name="AddDescription"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="AddFile" class="form-label">
                          Arquivo de Dados  <i class="fas fa-question-circle" data-toggle="tooltip" title="O arquivo deve ser do tipo .csv com as colunas 'age' e 'area'"></i>
                        </label>
                        <input type="file" class="form-control AddFile" id="fileUploaded" accept=".csv" />
                        <div class="" id="fileResponse"></div> 
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary add_modal" id="btnSaveEvent">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->

    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered p-3" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="alertEdit"></div> 
                    <div class="row">
                        <div class="col-lg">
                            <div class="mb-3">
                                <label for="EditTitle" class="form-label">Título</label>
                                <input type="text" class="form-control editTitle" id="EditTitle" placeholder="Insira o título" name="EditTitle">
                                <div class="invalid-feedback">Insira o título</div>
                            </div>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <label for="EditDescription" class="form-label">Descrição</label>
                        <textarea class="form-control editDescription" id="EditDescription" placeholder="Observações/detalhes da área" rows="5" name="EditDescription"></textarea>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary edit_modal" id="btnSaveEventEdit">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="DeleteModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModal">Apagar Área</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="alertDelete"></div>
                    <h4>Deseja apagar este registro?</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary delete_modal" id="btnEventDelete">Sim, apagar</button>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('scripts')
    @vite(['resources/js/zone.js'])
@endsection