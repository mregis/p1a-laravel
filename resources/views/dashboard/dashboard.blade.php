
@extends('layout')

@section('title', 'DashBoard')
@section('content')
<div class="m-content">

<div class="m-portlet">
	<div class="m-portlet__body  m-portlet__body--no-padding">
		@if(Auth::user()->profile == "AGÊNCIA")
		<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-xl-6">
				<div class="m-widget14">
					<div class="m-widget14__header m--margin-bottom-30">
						<h3 class="m-widget14__title">Envio para outra Agência</h3>
					</div>
					<div class="m-widget14__chart" style="height:120px;">
                                            <table class="table table-bordered">
                                                <thead class="table-dark"><th>Data</th><th>Pendente(s)</th><th>Confirmado(s)</th></thead>
                                                <tbody>
                                                    @foreach($da as $k=>&$a)
                                                       <tr><td align="center">{{$k}}</td><td align="center"><?=$a['pendentes']?></td><td align="center"><?=$a['concluidos']?></td></tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            
                                            
					</div>
				</div>
			</div>
			<div class="col-xl-6">
				<div class="m-widget14">
					<div class="m-widget14__header m--margin-bottom-30">
						<h3 class="m-widget14__title">Recebimento de outra Agência</h3>
					</div>
					<div class="m-widget14__chart" style="height:120px;">
                                            <table class="table table-bordered">
                                                <thead class="table-dark"><th>Data</th><th>Pendente(s)</th><th>Confirmado(s)</th></thead>
                                                <tbody>
                                                    @foreach($dm as $k=>&$a)
                                                       <tr><td align="center">{{$k}}</td><td align="center"><?=$a['pendentes']?></td><td align="center"><?=$a['concluidos']?></td></tr>
                                                    @endforeach                                                    
                                                </tbody>
                                            </table>

                                            <?php
                                            ?>
					</div>
				</div>
			</div>
		</div>
		@endif
		</div>
	</div>
</div>
<script type="text/javascript">
</script>
@stop
