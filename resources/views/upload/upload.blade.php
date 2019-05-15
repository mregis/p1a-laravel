@extends('layout')

@section('title',  __('Upload de arquivos'))
@section('styles')
    <link href="{{ mix('css/dropzone.css')}}" rel="stylesheet" type="text/css">
    <style type="text/css">
        .dz-success-mark svg g, .dz-success-mark svg g g {
            fill: green;
        }
    </style>
@endsection
@section('content')

<div class="row">
	<div class="col-12">
		<div class="m-portlet m-portlet--tab">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                            <li class="m-nav__item m-nav__item--home">
                                <a href="{{ route('home') }}" class="m-nav__link m-nav__link--icon">
                                    <i class="m-nav__link-icon la la-home"></i>
                                </a>
                            </li>
                            <li class="m-nav__separator">-</li>
                            <li class="m-nav__item">
                                <a href="javascript:void(0)" class="m-nav__link">
                                    <span class="m-nav__link-text">Remessa (Envio)</span>
                                </a>
                            </li>
                            <li class="m-nav__separator">-</li>
                            <li class="m-nav__item">
                                <a href="javascript:void(0)" class="m-nav__link">
                                    <h4 class="m-portlet__head-text">Carregamento de Arquivos</h4>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            <i class="far fa-file-alt"></i> Carregar Arquivo de Capas de Lotes
                        </h3>
                    </div>
                </div>
            </div>
			<div class="m-portlet__body">
                <div class="row">
					<h5 class="col-form-label">Importação de arquivos com códigos dos envelopes em trânsito</h5>
                </div>
                <div class="form-group m-form__group row upp">
                    <form action="{{route('upload.upload')}}" id="m-dropzone-two"
                          class="dropzone m-dropzone m-dropzone--primary">
                        <input type="hidden" name="_u" value="{{Auth::id()}}">
                        <div class="m-dropzone__msg dz-message needsclick">
                            <h3 class="m-dropzone__msg-title">Arraste os arquivos ou clique para fazer o upload.</h3>
                            <span class="m-dropzone__msg-desc">Faça upload de até 10 arquivos</span>
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Loading Content -->
<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="loadMeLabel">Carregando Arquivos</h5>
            </div>
            <div class="modal-body text-center">
                <div class="loader"></div>
                <div>
                    <p>Efetuando o registro de Capas de Lotes dos arquivos</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
    <script src="{{ mix('/js/dropzone.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;

        var myDropzone = null;

        $(function () {
            myDropzone = new Dropzone("#m-dropzone-two");
            myDropzone.on("sending", function (file, response) {
                $("#loadMe").modal({
                    backdrop: "static", //remove ability to close modal with click
                    keyboard: false, //remove option to close with keyboard
                    show: true //Display loader!
                });
            });
            myDropzone.on("complete", function (file, response) {
                // Arquivo carregado e validado
                $("#loadMe").modal('hide');
            });
            myDropzone.on("error", function (file, response, xhr) {
                // Arquivo carregado e validado
                $(file.previewElement).find('.dz-error-message')
                        .text(response.message || xhr.responseJSON.message || xhr.responseText);
                $("#loadMe").modal('hide');
                var errormodal = $("#on_error").modal();
                errormodal.find('.modal-body').find('p')
                        .text(response.message || xhr.responseJSON.message || xhr.responseText);
                errormodal.show();
            });
            myDropzone.on("success", function (file, response) {
                // Arquivo carregado e validado
                var successmodal = $("#on_done_data").modal();
                successmodal.find('.modal-body').find('p')
                        .text(response.message || response.responseJSON.message || response.responseText);
                successmodal.show();
            });
        });
    </script>
@endsection