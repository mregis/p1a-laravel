@extends('layout')

@section('title',  __('titles.users'))
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
                                {{__('titles.edit_user')}}
                            </h3>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="inputs" id="inputs"
                       value="name,phone,email,profile,rg,cpf,position,zipcode,state,city,number,address,complement,district">
                {{ Form::model($user, array ('url' => url('users/update',$user->id),'method' => 'PUT', 'class'=>'m-form m-form--fit m-form--label-align-right ajax-form')) }}
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-md-4">
                            <label for="name">{{__('labels.name')}}</label>
                            <input type="text" class="form-control m-input" name="name" id="name"
                                   data-validation="notempty($(this))" data-label="{{__('labels.name')}}"
                                   data-error="{{__('labels.field_not_empty')}}"
                                   placeholder="{{__('labels.name')}}"
                                   value="{{$user->name}}">
                        </div>

                        <div class="col-md-4">
                            <label for="email">{{__('labels.email')}}</label>
                            <input type="email" class="form-control m-input" name="email" id="email"
                                   data-validation="validEmail($(this))" data-label="{{__('labels.email')}}"
                                   data-error="{{__('labels.field_not_valid')}}" aria-describedby="emailHelp"
                                   placeholder="{{__('labels.email')}}"
                                   value="{{$user->email}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="profile">{{__('labels.profile')}}</label>
                            <input type="hidden" name="name_profile" value="{{$user->profile}}">
                            <select class="form-control m-input m-input--square" name="profile"
                                    id="profile"
                                    data-validation="notempty($(this))"
                                    data-label="{{__('labels.profile')}}"
                                    data-error="{{__('labels.profile')}}"
                                    onchange="hide_show(this)">
                                <option disabled selected>{{__('labels.select')}}</option>
                                <?php foreach( $permissao as $p ) : ?>
                                    <option <?php if($user->profile == $p) echo 'selected'?>><?=$p?></option>
                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>
                    <div class="m-form__group row">
                        <div class="form-group col-md-4 inputGroupContainer">
                            <label class="control-label" for="password">{{__('labels.password')}}</label>
                            <input type="password" class="form-control m-input" name="password" id="password" required
                                   data-minlength="6"
                                   {{--data-validation="notempty($(this))"--}}
                                   data-label="{{__('labels.password')}}"
                                   placeholder="{{__('labels.password')}}">
                            <div class="help-block with-errors">Mínimo de 6 caracteres</div>
                        </div>
                        <div class="form-group col-md-4 inputGroupContainer">
                            <label class="control-label"
                                   for="confirm_password">{{__('labels.confirm_password')}}</label>
                            <input type="password" class="form-control m-input" name="confirm_password"
                                   id="confirm_password"
                                   data-match="#password"
                                   {{--data-validation="notempty($(this))"--}}
                                   data-label="{{__('labels.confirm_password')}}"
                                   data-error="{{__('labels.field_not_valid')}}"
                                   placeholder="{{__('labels.confirm_password')}}"
                                   data-match-error="Atenção! As senhas não estão iguais.">
                            <div class="help-block with-errors"></div>
                        </div>

                    </div>
                    <div class="m-form__group row">
                        <div class="form-group col-md-4 inputGroupContainer" id="juncao" @if(strlen($user->juncao) == 0) style="display:none" @endif>
                            <label class="control-label" for="juncao">Junção</label>
                            <input type="text" class="form-control m-input" name="juncao" value="{{$user->juncao}}">
                        </div>
                        <div class="form-group col-md-4 inputGroupContainer" id="unidade" @if(strlen($user->unidade) == 0) style="display:none" @endif>
                            <label class="control-label" for="unidade">Unidade</label>
                            <input type="text" class="form-control m-input" name="unidade" value="{{$user->unidade}}">
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions">
                            {{ Form::submit(__('buttons.submit'), array('class' => 'btn btn-success')) }}
                            <button type="reset" class="btn btn-secondary"
                                    onclick="window.history.back()">{{__('buttons.cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            {{ csrf_field() }}
            {{ Form::close() }}
        </div>
    </div>
<script type="text/javascript">
window.onload = function(e){
        $('#profile').bind('change',function(){
                if($(this).val() == 'AGÊNCIA'){
                        $('#juncao').show();
                }else{
                        $('#juncao').hide();
                }
                if($(this).val() == 'OPERADOR'){
                        $('#unidade').show();
                }else{
                        $('#unidade').hide();
                }
        });
}
</script>
@stop
