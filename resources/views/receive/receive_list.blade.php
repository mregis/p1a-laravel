@extends('layout')
@section('title', __('Receber Envelope'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
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
                                        <h3 class="m-portlet__head-text">{{__('Receber Lotes')}}</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="row">
                        <input type="hidden" id="columns" value="action,content,origin,destin,movimento,status">
                        <input type="hidden" id="baseurl"
                               value="{{ route('capalote.get-not-received-by-file', [Auth::id(), $id])}}">
                        <table class="table table-striped table-bordered hasdetails table-hover nowrap
                                table-responsive compact text-center"
                               id="datatable"
                               data-column-defs='[{"targets":[1],"orderable":false}]'
                               data-order='[[3, "asc"],[5, "asc"]]'>
                            <thead class="thead-dark form-group">
                            <tr>
                                <th></th>
                                <th><input type="checkbox" name="all_lote" class="form-control m-input" style="width: 20px"
                                           onclick="allCheck(this);" id="all_lote"></th>
                                <th>{{__('Capa Lote')}}</th>
                                <th>{{__('Origem')}}</th>
                                <th>{{__('Destino')}}</th>
                                <th>{{__('Movimento')}}</th>
                                <th>{{__('Status')}}</th>
                            </tr>
                            </thead>
                            <tbody class="form-group"></tbody>
                        </table>
                    </div>
                    <div class="row">
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td>@{{confirm}}</td>
                                    <td>@{{content}}</td>
                                </tr>
                            </table>
                        </script>
                        <div class="m-form__actions">
                            <button class="btn btn-lg btn-success" type="submit" onclick="save()">
                                <i class="fas fa-file-download"></i> Receber
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    var user = {{ Auth::user()->id }};
                    $('.input-doc').each(function () {
                        if ($(this).prop('checked') == true) {
                            doc[c++] = $(this).val();
                        }
                    });
                    $.post('/api/receber/registrar', {doc: doc, user: user}, function (r) {
                        $('#datatable').DataTable().ajax.reload();
                    });
                }
            } else {
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
