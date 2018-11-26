@extends('layout')
@section('title', __('Receber'))
<style type="text/css">
.m-body .m-content {background-color:#f0f0f0}
.details-control {display:none}
</style>
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
                <input type="hidden" id="columns" value="action,content,origem,destino,status">
                @if(Auth::user()->juncao)
                <input type="hidden" id="baseurl" value="{{URL::to('/api/receive/docs/')}}/{{$id}}/{{Auth::user()->profile}}/{{Auth::user()->juncao}}">
                @else
                <input type="hidden" id="baseurl" value="{{URL::to('/api/receive/docs/')}}/{{$id}}/{{Auth::user()->profile}}">                
                @endif
		<input type="hidden" id="check_url" value="{{URL::to('/arquivo/recebe')}}">
                <div class="m-portlet__body">
                    <div class="table-responsive-xl">
                        <table class="table table-striped"
                               id="datatable">
                            <thead class="thead-dark">
                            <tr>
                                <th></th>
                                <th style="width:20px"></th>
                                <th>{{__('Capa Lote')}}</th>
                                <th>{{__('Origem')}}</th>
                                <th>{{__('Destino')}}</th>
                                <th>{{__('Status')}}</th>
                            </tr>
                            </thead>
                        </table>
                        <script id="details-template" type="text/x-handlebars-template">
                            <table class="table" id="check_details">
                                <tr>
                                    <td>
					@{{confirm}}
				    </td>
                                    <td>
					@{{content}}
				    </td>
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
<script type="text/javascript">
function allCheck(elem){
        if($('#all_lote').prop('checked') == true){
                $('.input-doc').prop('checked',true);
        }else{
                $('.input-doc').prop('checked',false);
        }
}
function save(){
if(confirm('Deseja receber '+$('.input-doc:checked').length+' capas de lote?')){
        var doc = [];
        var c = 0;
        var user = {{{ Auth::user()->id }}};
        $('.input-doc').each(function(){
                if($(this).prop('checked') == true){
                        doc[c++] = $(this).val();
                }
        });
        $.post('/api/receber/registrar',{doc:doc,user:user},function(r){
                location.reload();
        });
}
}
</script>

@stop
