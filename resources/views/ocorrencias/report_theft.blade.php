@extends('layout')

@section('title',  __('titles.report_theft'))
@section('content')

<div class="row">
    <div class="col">
        <div class="m-portlet m-portlet--tabs">
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
                                <a href="{{route('ocorrencias.index')}}" class="m-nav__link">
                                    <span class="m-nav__link-text">Ocorrências</span>
                                </a>
                            </li>
                            <li class="m-nav__separator">-</li>
                            <li class="m-nav__item">
                                <a href="javascript:void(0)" class="m-nav__link">
                                    <h3 class="m-portlet__head-text">Reportar Roubo</h3>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="form-inline m-2">
                    <div class="form-group">
                        <label for="di" class="text-right mr-1 ml-2">Data Movimento:</label>

                        <input type="text" class="form-control datepicker" readonly="readonly" id="dt_movimento"
                                   data-date-end-date="0d" data-date-autoclose="true"
                                   value="{{date('d/m/Y', strtotime('-2 days'))}}">
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover nowrap
                                table-responsive compact"
                       id="datatable-nao-recebido">
                    <thead class="thead-dark">
                        <tr>
                            <th><input type="checkbox" class="form-control m-input"
                                       onclick="allCheck(this);" style="width: 20px"></th>
                            <th>Capa Lote</th>
                            <th>Tipo Arquivo</th>
                            <th>Origem</th>
                            <th>Destino</th>
                            <th>{{__('tables.status')}}</th>
                            <th>{{__('tables.updated_at')}}</th>
                            <th>Atraso</th>
                            <th>{{__('tables.details')}}</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
                <div class="row">
                    <div class="m-form__actions">
                        <button class="btn btn-lg btn-success" onclick="go()">
                            <i class="fas fa-broadcast-tower"></i> Reportar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@component('dochistory')
@endcomponent

@endsection

@section('scripts')
    <script type="text/javascript">
        function allCheck(elem) {
            var t = $(elem).prop('checked') == true;
            $('.input-doc').prop('checked', t);
        }
        function go() {
            var _l = $('.input-doc:checked').length

            if (_l > 0) {
                if (confirm('Confirmar reportar ' + _l + ' capa' + (_l > 1 ? 's' : '') +' de lote?')) {
                    var docs = [];
                    var user = "{{ Auth::user()->id }}";
                    $('.input-doc').each(function () {
                        if ($(this).prop('checked') == true) {
                            docs.push($(this).val());
                        }
                    });
                    $.post('{{route('alerts.report_theft')}}', {docs: docs, _u: user}, function (r) {
                        $('.modal').modal('hide');
                        if (r.message != null) {
                            var successmodal = $("#on_done_data").modal();
                            successmodal.find('.modal-body')
                                    .find('p')
                                    .text(r.message);
                            successmodal.show();
                        }
                        report.ajax.reload();
                    }).fail(function(xhr) {
                        var errormodal = $("#on_error").modal();
                        errormodal.find('.modal-body')
                                .find('p')
                                .text(xhr.responseJSON.message || xhr.responseText || xhr.message);
                        errormodal.show();
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

        var report = null; // Automatic Datatables
        $(function () {
            var DataTablesLocalOptions = {
                serverSide: true,processing: true,responsive: true,language: lang,
                order: [[6, "desc"]],
                ajax: {
                    url: "{{ route('capalote.get_not_received_by_movimento') }}",
                    type: "POST",
                    data: function (data) {
                        var _i = jQuery("#dt_movimento").val();
                        data.movimento = _i.replace(/\D/g, '-');
                        data._u = '{{Auth::id()}}';
                    }
                },
                columns: [
                    {"data":"action", "orderable":false, "searchable":false},
                    {"data":"content"},
                    {"data":"constante"},
                    {"data":"from_agency"},
                    {"data":"to_agency"},
                    {"data":"status"},
                    {"data":"updated_at"},
                    {"data":"atraso", "searchable":false},
                    {"data":"view", "orderable":false, "searchable":false}
                ]
            };

            if (typeof(report) == "undefined" || report == null) {
                report = $('#datatable-nao-recebido').DataTable(DataTablesLocalOptions);
                $('#dt_movimento').change(function () {
                    report.ajax.reload();
                });
            }

        });
    </script>

@stop