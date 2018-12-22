@extends('layout')
@section('title', __('Receber Envelope'))

@section('styles')
<style type="text/css">
    .m-body .m-content {background-color:#f0f0f0;}
    .details-control {display:none}
</style>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
						        <i class="la la-gear"></i>
						    </span>
                            <h3 class="m-portlet__head-text">
                                {{__('Listagem')}}
                            </h3>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="columns" value="action,content,from_agency,to_agency,created_at,status">
                @if(Auth::user()->juncao)
                <input type="hidden" id="baseurl" value="{{URL::to('/api/receive/docs/')}}/{{$id}}/{{Auth::user()->profile}}/{{Auth::user()->juncao}}">
                @else
                <input type="hidden" id="baseurl" value="{{URL::to('/api/receive/docs/')}}/{{$id}}/{{Auth::user()->profile}}">
                @endif
                <div class="m-portlet__body">
                    <div class="table-responsive-xl">
                        <table class="table table-striped table-bordered dt-responsive hasdetails"
                               id="datatable"
                               data-column-defs='[{"targets":[1],"orderable":false}]'
                               data-order='[[5, "desc"],[2, "asc"]]'>
                            <thead class="thead-dark">
                                <tr>
                                    <th></th>
                                    <th><input type="checkbox" name="all_lote" class="form-control m-input"
                                               onclick="allCheck(this);" id="all_lote" style="width: 20px"></th>
                                    <th>{{__('Capa Lote')}}</th>
                                    <th>{{__('Origem')}}</th>
                                    <th>{{__('Destino')}}</th>
                                    <th>{{__('Inserido em')}}</th>
                                    <th>{{__('Status')}}</th>
                                </tr>
                            </thead>
                        </table>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td>@{{confirm}}</td>
                                    <td>@{{content}}</td>
                                </tr>
                            </table>
                        </script>
                    </div>
                    <div class="row">
                        <div class="m-form__actions">
                            <input class="btn btn-success" type="submit" onclick="save()" value="Receber" style="width:100%;max-width:150px;text-transform:uppercase">
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
        if ( $('.input-doc:checked').length > 0) {

            if (confirm('Deseja receber ' + $('.input-doc:checked').length + ' capas de lote?')) {
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
                    .text('É necessário selecionar ao menos 1 capa de malote.');
            errormodal.show();
        }
    }
</script>

@stop
