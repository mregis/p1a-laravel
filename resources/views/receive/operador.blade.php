@extends('layout')
@section('title', __('Recebimento'))

@section('styles')
    <style type="text/css">
        .bootstrap-tagsinput { border: none;}
    </style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tabs">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">{{__('Recebimento')}}</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">{{__('Operador')}}</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet m-portlet--tabs">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <h3 class="m-portlet__head-text"><i class="fas fa-barcode"></i> Registrar Capa de Lote</h3>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="row m-row--no-padding m-row--col-separator-xl mb-4">
                            <div class="col-md-5 col-xl-5">
                                <h3 class="m-portlet__head-text">Capa de Lote #</h3>
                                <div class="form-inline">
                                    <div class="form-group mr-2">
                                        <input type="text" class="form-control form-control-lg m-input input-doc"
                                               id="inputCapaLote" placeholder="Capa de Lote"
                                               data-mask="0000000000000">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg plus" id="btnAddCapaLote"
                                            onclick="addCapaLote();">+</button>
                                </div><br />
                                <h3 class="m-portlet__head-text">Lacre Malote</h3>
                                <div class="form-inline">
                                    <div class="form-group mr-2">
                                        <input type="text" name="lacre"
                                               class="form-control form-control-lg m-input" id="lacre">
                                    </div>
                                    <button class="btn btn-success btn-lg" onclick="registerCapasLote()">Registrar</button>
                                </div>
                            </div>

                            <div class="col-md-7 col-xl-7 mt-4 h3">
                                <select multiple name="capalote[]" id="selectCapaLote"></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#selectCapaLote').tagsinput({
                tagClass: "big badge badge-info p-2 mb-2",
                focusClass: "focus",
                allowDuplicates: false
            });
            $('#selectCapaLote').on('beforeItemAdd', function(event) {
                var tag = event.item;
                if (!event.options || !event.options.preventPost) {
                    $.post('{{ route('receive.check-capa-lote') }}', {capaLote: tag}, function(response) {

                    }).fail(function(f){
                        // Remove tag from taglist
                        $('#selectCapaLote').tagsinput('remove', tag, {preventPost: true});

                        // Close all opened modals
                        $('.modal').modal('hide');
                        var errormodal = $("#on_error").modal();
                        errormodal.find('.modal-body').find('p').text(f.responseText);
                        errormodal.show();
                    });
                }
            });
        });

        $('#inputCapaLote').keypress(function(e) {
            if (e.which == 13) {
                if ($('#inputCapaLote').val().length == 13) {
                    $('#btnAddCapaLote').click();
                } else {
                    return false;
                }
            }
        });

        function addCapaLote() {
            var capaLote = $('#inputCapaLote').val();
            $('#selectCapaLote').tagsinput('add', capaLote);
            $('#inputCapaLote').val("").focus();
        }

        function registerCapasLote() {
            var items = $('#selectCapaLote').tagsinput('items');
            var lacre = $('#lacre').val();
            if (items.length > 0) {
                if (confirm('Registrar as Capas de Lotes indicadas?')) {
                    $.post('{{ route('receive.register-capa-lote') }}',
                            {lacre: lacre, doc: items, user: '{{ Auth::user()->id }}'},
                            function (r) {
                                // Close all opened modals
                                $('.modal').modal('hide');
                                var successmodal = $("#on_done_data").modal();
                                successmodal.find('.modal-body').find('p').text(r);
                                successmodal.show();
                            }
                    ).done(function() {
                                $('#selectCapaLote').tagsinput('removeAll');
                                $('#lacre').val("");
                            }
                    ).fail(function(f) {
                        // Close all opened modals
                        $('.modal').modal('hide');
                        var errormodal = $("#on_error").modal();
                        errormodal.find('.modal-body').find('p').text(f.responseText);
                        errormodal.show();
                    });
                }
            } else {
                alert('Erro! Não há capa de Lote a ser registrada.');
            }
        }
    </script>
@stop
