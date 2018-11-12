@extends('layout')

@section('title',  __('Upload de arquivos'))
@section('content')
<style type="text/css">
.m-body .m-content {background-color:#f0f0f0}
</style>
<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
	<li class="m-nav__item m-nav__item--home">
		<a href="/dashboard" class="m-nav__link m-nav__link--icon">
			<i class="m-nav__link-icon la la-home"></i>
		</a>
	</li>
	<li class="m-nav__separator">-</li>
	<li class="m-nav__item">
		<a href="javascript:void(0)" class="m-nav__link">
			<span class="m-nav__link-text">{{__('Upload de Arquivos')}}</span>
		</a>
	</li>
</ul>

<div class="row">
	<div class="col-md-12">
		<div class="m-portlet m-portlet--tabs">
			<div class="m-portlet__head"><br><h3>Arquivos</h3></div>
			<div class="m-portlet__body">
				<div class="form-group m-form__group row upp">
					<label class="col-form-label col-lg-2 col-sm-12">Importação de arquivos com códigos dos envelopes em trânsito</label>
					<div class="col-lg-4 col-md-9 col-sm-12">
						<div class="m-dropzone dropzone m-dropzone--primary" action="/api/upload" id="m-dropzone-two">
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
