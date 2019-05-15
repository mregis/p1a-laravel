@section('aftercontent')
    <input type="hidden" value="" id="capaloteSelected">
    <div class="modal fade" id="capaLoteHistoryModal" tabindex="-1" role="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="min-height: 600px">
            <div class="modal-content" style="width: 650px">
                <div class="modal-header">
                    <h4 class="m-widget14__title">Histórico Capa de Lote <span
                                class="bagde badge-primary badge-pill capalote-placeholder">#CAPALOTE#</span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-hover responsive nowrap compact"
                           id="history" width="590">
                        <thead class="table-dark">
                        <tr>
                            <th>CAPA LOTE</th>
                            <th>JUNÇÃO ORIGEM</th>
                            <th>JUNÇÃO DESTINO</th>
                            <th>DATA MOVIMENTO</th>
                            <th>DATA ENVIO</th>
                            <th class="all">REGISTRO</th>
                            <th class="all">DATA</th>
                            <th class="all">USUÁRIO</th>
                            <th class="all">PERFIL</th>
                            <th class="all">LOCAL</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $('#capaLoteHistoryModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipient = button.data('dochistoryId') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            $('#capaloteSelected').val(recipient)
        }).on('shown.bs.modal', function (e) {
            historytable.ajax.reload();
            historytable.responsive.recalc();
        }).on('hidden.bs.modal', function (e) {
            historytable.clear().draw();
        });
        if (typeof historytable == "undefined" || historytable == null) {
            historytable = $('#history').DataTable({
                dom: "<'row'<'col-10'r>><'row'<'col-sm-12'B>><'row'<'col-sm-12't>><'row'<'col-5'i>>" ,
                buttons: {
                    dom: {button: { tag: 'button',className: 'btn btn-sm'}},
                    buttons: [
                        {extend: "print", text: "<i class='fas fa-print'></i> Imprimir", className: 'btn-primary'},
                        {
                            extend: "excelHtml5",
                            text: "<i class='far fa-file-excel'></i> Salvar Excel",
                            title: function(){ return "CapaLote_" + $("span.capalote-placeholder").text();},
                            className: 'btn-primary'
                        },
                        {
                            extend: "pdfHtml5",
                            text: "<i class='far fa-file-pdf'></i> Salvar PDF",
                            title: function(){ return "CapaLote_" + $("span.capalote-placeholder").text();},
                            className: 'btn-primary'
                        },
                    ]
                },
                language: lang,
                ordering: false,
                processing: true,
                responsive: true,
                ajax: {
                    type: "POST",
                    url: "{{route('docshistory.get-doc-history')}}",
                    data: function (d) {
                        d._u = "{{Auth::id()}}";
                        d.id = $("#capaloteSelected").val() || 0;
                    }
                },
                columns:[
                    {"data": "content"},
                    {"data": "origem"},
                    {"data": "destino"},
                    {"data": "movimento"},
                    {"data": "doc_created_at"},
                    {"data": "history_description"},
                    {"data": "created_at"},
                    {"data": "history_user_name"},
                    {"data": "history_user_profile"},
                    {"data": "history_local"}
                ]
//            columnDefs: [ { targets: [0,1,2,3,4], visible: false } ]
            })
            ;
        }

    </script>
@endsection