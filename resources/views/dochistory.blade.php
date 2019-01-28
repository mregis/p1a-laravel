@section('aftercontent')
    <div class="modal fade" id="capaLoteHistoryModal" tabindex="-1" role="modal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="m-widget14__title">Histórico Capa de Lote <span
                                class="bagde badge-primary badge-pill capalote-placeholder">#CAPALOTE#</span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped table-hover compact nowrap text-center"
                           id="history">
                        <thead class="table-dark">
                        <tr>
                            <th>CAPA LOTE</th>
                            <th>JUNÇÃO ORIGEM</th>
                            <th>JUNÇÃO DESTINO</th>
                            <th>DATA MOVIMENTO</th>
                            <th>DATA ENVIO</th>
                            <th>REGISTRO</th>
                            <th>DATA</th>
                            <th>USUÁRIO</th>
                            <th>PERFIL</th>
                            <th>LOCAL</th>
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