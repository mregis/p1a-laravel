@extends('layout')
@section('title', __('Recebimento'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                                <li class="m-nav__item m-nav__item--home">
                                    <a href="{{route('home')}}" class="m-nav__link m-nav__link--icon">
                                        <i class="m-nav__link-icon la la-home"></i>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <span class="m-nav__link-text">Recebimento</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Receber Envelopes</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <div class="tab-content">
                        <input type="hidden" id="columns"
                               value="action,content,constante,from_agency,to_agency,movimento,status,view">

                        <input type="hidden" id="baseurl"
                               value="{{ route('capalote.get-not-received', Auth::user()->id)}}"/>

                        <input type="hidden" id="check_url" value="{{URL::to('/arquivo/recebe')}}">

                            <table class="table table-striped table-hover table-responsive compact nowrap text-center"
                                   id="datatable"
                                   data-column-defs='[{"targets":[0,6,7],"orderable":false}]'
                                   data-order='[[5,"asc"]]'>
                                <thead class="thead-dark form-group">
                                <tr>
                                    <th><input type="checkbox" name="all_lote" style="width: 20px"
                                               class="form-control form-control-sm"
                                               onclick="allCheck(this);" id="all_lote"></th>
                                    <th>{{__('Capa Lote')}}</th>
                                    <th>{{__('Tipo')}}</th>
                                    <th>{{__('Origem')}}</th>
                                    <th>{{__('Destino')}}</th>
                                    <th>{{__('tables.movimento')}}</th>
                                    <th>{{__('labels.status')}}</th>
                                    <th>{{__('tables.action')}}</th>
                                </tr>
                                </thead>
                                <tbody class="form-group"></tbody>
                            </table>
                        </div>
                        <div class="m-form__actions">
                            <button class="btn btn-success btn-lg" onclick="save();">
                                <i class="fas fa-file-download"></i> Receber
                            </button>
                        </div>
                </div>
            </div>
        </div>
    </div>

    @component('dochistory')
    @endcomponent
@stop

@section('scripts')
    <script type="text/javascript">
        function allCheck(elem) {
            var t = $('#all_lote').prop('checked') == true;
            $('.input-doc').prop('checked', t);
        }
        function save() {
            var _l = $('.input-doc:checked').length
            if (_l > 0) {
                if (confirm('Confirmar o recebimento de ' + _l + ' capa' + (_l > 1 ? 's' : '') +' de lote?')) {
                    var doc = [];
                    var c = 0;
                    var user = '{{ Auth::user()->id }}';

                    $('.input-doc').each(function () {
                        if ($(this).prop('checked') == true) {
                            doc[c++] = $(this).val();
                        }
                    });

                    $.post('/api/receber/registrar', {doc: doc, user: user}, function (r) {
                        // Close all opened modals
                        $('.modal').modal('hide');
                        var successmodal = $("#on_done_data").modal();
                        successmodal.find('.modal-body').find('p').text(r);
                        successmodal.show();
                        $('#datatable').DataTable().ajax.reload();
                    }).fail(function (f) {
                        // Close all opened modals
                        $('.modal').modal('hide');
                        var errormodal = $("#on_error").modal();
                        errormodal.find('.modal-body').find('p').text(f.responseText);
                        errormodal.show();
                    });
                }
            }  else {
                // Close all opened modals
                $('.modal').modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body')
                        .find('p')
                        .text('É necessário selecionar ao menos um registro para efetuar o Recebimento');
                errormodal.show();
            }
        }

    </script>
@stop
