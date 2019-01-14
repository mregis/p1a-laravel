@extends('layout')
@section('title', __('Recebimento'))

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-envelope"></i>
						    </span>
                            <h3 class="m-portlet__head-text">{{__('Receber Envelopes')}}</h3>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="columns"
                       value="action,content,constante,from_agency,to_agency,created_at,updated_at,status,view">

                    <input type="hidden" id="baseurl" value="{{ route('capalote.get-not-received', Auth::user()->id)}}" />

                <input type="hidden" id="check_url" value="{{URL::to('/arquivo/recebe')}}">

                <div class="m-portlet__body">
                        <table class="table table-striped table-bordered hasdetails table-hover
                            table-responsive compact nowrap text-center"
                                   id="datatable"
                               data-column-defs='[{"targets":[1,8,9],"orderable":false}]'
                               data-order='[[ 4, "asc" ], [ 5, "asc"]]'>
                            <thead class="thead-dark form-group">
                            <tr>
                                <th></th>
                                <th><input type="checkbox" name="all_lote" class="form-control form-control-md m-input"
                                           onclick="allCheck(this);" id="all_lote"></th>
                                <th>{{__('Capa Lote')}}</th>
                                <th>{{__('Tipo')}}</th>
                                <th>{{__('Origem')}}</th>
                                <th>{{__('Destino')}}</th>
                                <th>{{__('Movimento')}}</th>
                                <th>{{__('Ultima Atualização')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('tables.action')}}</th>
                            </tr>
                            </thead>
                            <tbody class="form-group"></tbody>
                        </table>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td>@{{confirm}}</td>
                                    <td>@{{content}}</td>
                                </tr>
                            </table>
                        </script>
                        <div class="m-form__actions">
                            <button class="btn btn-success btn-lg" onclick="save();">
                                <i class="fas fa-file-download"></i> Receber</button>
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
            if (confirm('Deseja receber ' + $('.input-doc:checked').length + ' capas de lote?')) {
                var doc = [];
                var c = 0;
                var user = '{{ Auth::user()->id }}';
            }
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
            }).fail(function(f) {
                // Close all opened modals
                $('.modal').modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p').text(f.responseText);
                errormodal.show();
            });
        }

    </script>
@stop
