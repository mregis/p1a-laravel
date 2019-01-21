@extends('layout')

@section('title',  'Capas de Lotes')
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
                                        <span class="m-nav__link-text">Capa de Lote</span>
                                    </a>
                                </li>
                                <li class="m-nav__separator">-</li>
                                <li class="m-nav__item">
                                    <a href="javascript:void(0)" class="m-nav__link">
                                        <h3 class="m-portlet__head-text">Listagem</h3>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="tab-content">
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="di" class="text-right mr-1 ml-2">Período de</label>
                                    <div class="input-group input-daterange">
                                        <input type="text" class="form-control" readonly="readonly" id="di">
                                        <div class="input-group-addon">Até</div>
                                        <input type="text" class="form-control" readonly="readonly" id="df">
                                    </div>
                                </div>
                            </div>
                            <table class="table table-striped _auto-dt table-bordered table-responsive nowrap compact text-center">
                                <thead class="thead-dark">
                                <tr>                                    
                                    <th>{{__('Capa Lote')}}</th>
                                    <th>{{__('Origem')}}</th>
                                    <th>{{__('Destino')}}</th>
                                    <th>{{__('Movimento')}}</th>
                                    <th>{{__('labels.status')}}</th>
                                    <th>{{__('tables.action')}}</th>
                                </tr>
                                </thead>
                            </table>                            
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
        var _autodt = null; // Automatic Datatables
        $(function () {
            $('#formprint-capalote').on('submit', function () {
                if ($('[name="capalote[]"]:checked').length < 1) {
                    alert('É necessário marcar ao menos 1 capa de lote para impressão.');
                    return false;
                }
                ;
            });


            if (typeof(_autodt) == "undefined" || _autodt == null) {
                _autodt = $('table._auto-dt').DataTable({
                    dom: "<'row'<'col-10'r>><'row'<'col-5'l><'col-7 text-right'f>>" +
                    "<'row'<'col-sm-12't>><'row'<'col-5'i><'col-7'p>>",
                    language: lang,
                    order: [[4,"desc" ]],
                    serverSide: "true",
                    columns: [{"data":"content"},{"data":"from_agency"},{"data":"to_agency"},{"data":"movimento"},{"data":"status"},{"data":"view"}],
                    columnDefs: [{"targets":[5],"orderable":false,"searchable":false}],
                    ajax:{
                        "url" : "{{ route('capalote.list', Auth::user()->id) }}",
                        "data":function(data){
                            var _i = jQuery("#di").val();
                            data.di = _i.replace(/\D/g,'-');
                            _i = jQuery("#df").val();
                            data.df = _i.replace(/\D/g,'-');
                        }
                    }

                });
            }

            $('.input-daterange input').each(function() {
                $(this).datepicker({format: "dd/mm/yyyy", language:"pt-BR"});
            });
        });
        // Impressão de Capa de Lote
        function view(docid) {
            $('[name="capalote[]"]').attr('checked', false);
            $('#capalote-' + docid).attr('checked', true);
            $('#formprint-capalote').submit();
        };
        function allCheck(elem) {
            var t = $('#all_capalote').prop('checked') == true;
            $('.input-doc').prop('checked', t);
        }
        $('#di, #df').change( function() {
            _autodt.ajax.reload();
        });
    </script>
@stop