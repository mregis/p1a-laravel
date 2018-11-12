
@extends('layout')

@section('title', 'DashBoard')
@section('content')
<div class="m-content">

<div class="m-portlet">
	<div class="m-portlet__body  m-portlet__body--no-padding">
		@if(Auth::user()->profile == "OPERADOR")
		@else
		<div class="row m-row--no-padding m-row--col-separator-xl">
			<div class="col-xl-4">
				<div class="m-widget14">
					<div class="m-widget14__header m--margin-bottom-30">
						<h3 class="m-widget14__title">Enviar para Devolução da Agência</h3>
						<span class="m-widget14__desc"></span>
					</div>
					<div class="m-widget14__chart" style="height:120px;">
                                              <?php
                                                echo 'Documentos enviados: <b>' . count($dr).'</b>';
                                              ?>
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="m-widget14">
					<div class="m-widget14__header m--margin-bottom-30">
						<h3 class="m-widget14__title">Receber para Devolução da Agência</h3>
					</div>
					<div class="m-widget14__chart" style="height:120px;">
                                            <?php
                                            foreach($da as $k=>&$agencia){
                                                 echo $k . " = <b>" . $agencia."</b>";   
                                            }
                                            ?>
					</div>
				</div>
			</div>
			<div class="col-xl-4">
				<div class="m-widget14">
					<div class="m-widget14__header m--margin-bottom-30">
						<h3 class="m-widget14__title">Receber em Devolução Matriz</h3>
						<span class="m-widget14__desc"></span>
					</div>
					<div class="m-widget14__chart" style="height:120px;">
                                            <?php
                                            foreach($dm as $k=>&$matriz){
                                                 echo $k . " = <b>" . $matriz."</b>";   
                                            }
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
