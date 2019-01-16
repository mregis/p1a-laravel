@extends('layout')

@section('title',  __('Upload de arquivos'))

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

			<div class="m-portlet__body">
				<div class="form-group m-form__group row upp">
					<label class="col-form-label col-lg-2 col-sm-12">Importação de arquivos com códigos dos envelopes em trânsito</label>
					<div class="col-lg-4 col-md-9 col-sm-12">
						<div class="m-dropzone dropzone m-dropzone--primary" action="/api/upload/{{Auth::user()->id}}" id="m-dropzone-two">
							<div class="m-dropzone__msg dz-message needsclick">
							    <h3 class="m-dropzone__msg-title">Arraste os arquivos ou clique para fazer o upload.</h3>
							    <span class="m-dropzone__msg-desc">Faça upload de até 10 arquivos</span>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
@stop
