<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 27/12/2018
 * Time: 18:42
 */
?>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="nome">{{__('labels.name')}}</label>
    </div>
    <div class="col-6" title="Nome do Utilizador" data-toggle="tooltip">
        <input type="text" class="form-control{{$errors->has('name') ? ' is-invalid' : ''}}"
               id="name" name="name" placeholder="Nome do Utilizador"
               required="required" value="{{old('name') ? old('name') : $usuario->name }}">
    </div>
</div>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="email">{{__('labels.email')}}</label>
    </div>
    <div class="col-6" title="Endereço eletrônico de mensagens" data-toggle="tooltip">
        <input type="text" class="form-control{{$errors->has('email') ? ' is-invalid' : ''}}"
               id="email" name="email" required="required"{{$usuario->email != null ? ' disabled="disabled"':''}}
               placeholder="Endereço eletrônico de mensagens" value="{{old('email') ? old('email') : $usuario->email }}">
    </div>
</div>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="password">{{__('labels.password')}}</label>
    </div>
    <div class="col-3" title="Senha de Acesso" data-toggle="tooltip">
        <input type="password" class="form-control{{$errors->has('password') ? ' is-invalid' : ''}}"
               id="password" name="password"{{$usuario->password == null ? ' required="required"' : ''}}
               placeholder="Senha de Acesso" value="">
    </div>
    <div class="col-2 text-right">
        <label for="repassword">{{__('labels.confirm_password')}}</label>
    </div>
    <div class="col-3" title="Redigite a Senha" data-toggle="tooltip">
        <input type="password" class="form-control{{$errors->has('password_confirmation') ? ' is-invalid' : ''}}"
               id="repassword" name="password_confirmation" {{$usuario->password == null ? ' required="required"' : ''}}
               placeholder="Redigite a Senha">
    </div>
</div>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="perfil">{{__('labels.profile')}}</label>
    </div>
    <div class="col-3" title="Perfil" data-toggle="tooltip">
        <select class="form-control m-input m-input--square{{$errors->has('profile') ? ' is-invalid' : ''}}"
                name="profile" id="profile" data-validation="notempty($(this))"
                data-label="{{__('labels.profile')}}" data-error="{{__('labels.profile')}}"
                required="required">
            <option>{{__('labels.select')}}</option>
            <?php foreach( $perfis as $p ) : ?>
            <option value="{{$p->nome}}"{{ old('profile') == $p->nome || $p->nome == $usuario->profile ? ' selected="selected"' : ''}}>{{$p->nome}}</option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group post-profile hidden" id="agencia-block">
    <div class="col-2 text-right">
        <label for="agencia">{{__('labels.agencia')}}</label>
    </div>
    <div class="col-5" title="Agencia" data-toggle="tooltip">
        <div id="remote">
            <input type="text" class="form-control{{$errors->has('juncao') ? ' is-invalid' : ''}}"
                   id="juncao" name="juncao" data-rule="typeahead"
               placeholder="Agencia vinculada" value="{{old('juncao') ? old('juncao') : $usuario->juncao }}">
        </div>
    </div>
</div>

<div class="form-group hidden post-profile" id="unidade-block">
    <div class="col-2 text-right">
        <label for="unidade">{{__('labels.unidade')}}</label>
    </div>
    <div class="col-5" title="Unidade" data-toggle="tooltip">
        <select class="form-control m-input m-input--square{{$errors->has('unidade') ? ' is-invalid' : ''}}"
                name="unidade" id="unidade" data-validation="notempty($(this))"
                data-label="{{__('labels.unidade')}}" data-error="{{__('labels.unidade')}}">
            <option>{{__('labels.select')}}</option>
            <?php foreach( $unidades as $u ) : ?>
            <option value="{{$u->nome}}"{{old('unidade') == $u->nome || $u->nome == $usuario->unidade ? ' selected="selected"' : ''}}>{{$u->nome}}</option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

@section('scripts')
    <script type="text/javascript">
        $(function() {
            $('#profile').bind('change',function() {
                $('.post-profile').hide().removeClass('row');
                $('#juncao').removeAttr('required');
                $('#unidade').removeAttr('required');
                if ($(this).val() == 'AGÊNCIA'){
                    $('#juncao').attr('required', 'required');
                    $('#agencia-block').addClass('row').show();
                }
                if ($(this).val() == 'OPERADOR') {
                    $('#unidade').attr('required', 'required');
                    $('#unidade-block').addClass('row').show();
                }
            });

            var agencias = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.obj.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                remote: {
                    url: '{{route('agencias.api-buscar')}}?q=%QUERY&l=10',
                    wildcard: '%QUERY'
                }
            });

            $('#remote [data-rule="typeahead"]').typeahead(null, {
                name: 'agencias',
                display: function(obj) { return obj.codigo + ': ' + obj.nome; },
                source: agencias,
                minLength: 3,
                limit: 5,
                templates: {
                    empty: '<div class="empty-message">Nenhuma agência atende ao critério informado</div>',
                    suggestion: Handlebars.compile('<div><strong>@{{codigo}}</strong> – @{{nome}}</div>')
                }
            });
            $('#profile').change();
        });

    </script>
@stop