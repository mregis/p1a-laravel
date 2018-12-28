<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 27/12/2018
 * Time: 18:42
 */
?>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="nome">{{__('labels.name')}}</label>
    </div>
    <div class="col-6">
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da Agência"
               required="required" value="{{$unidade->nome}}"{{$unidade->nome != null ? ' readonly="readonly"':''}}>
    </div>
</div>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="descricao">{{__('labels.description')}}</label>
    </div>
    <div class="col-6">
        <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descritivo da Unidade"
               required="required" value="{{$unidade->descricao}}">
    </div>
</div>
