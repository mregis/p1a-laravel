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
        <label for="codigo">{{__('labels.code')}}</label>
    </div>
    <div class="col-2" title="Código da Agência ou Junção com 4 dígitos" data-toggle="tooltip">
        <input type="text" class="form-control" id="codigo" name="codigo"
               placeholder="Código" data-mask="0000" required="required"
                value="{{$agencia->codigo}}"{{$agencia->codigo != null ?' readonly="readonly"' : ''}}>
    </div>
    <div class="col-2 text-right">
        <label for="nome">{{__('labels.name')}}</label>
    </div>
    <div class="col-6">
        <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da Agência"
               required="required" value="{{$agencia->nome}}">
    </div>
</div>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="cep">{{__('labels.zipcode')}}</label>
    </div>
    <div class="col-2">
        <input type="text" class="form-control" id="cep" name="cep" placeholder="CEP"
               data-mask="00000-000" value="{{$agencia->cep}}" required="required">
    </div>
    <div class="col-2 text-right">
        <label for="nome">{{__('labels.address')}}</label>
    </div>
    <div class="col-6" title="Nome do Logradouro, número e Complemento" data-toggle="tooltip">
        <input type="text" class="form-control" id="endereco" name="endereco" required="required"
               placeholder="Rua, nº e complemento" value="{{$agencia->endereco}}">
    </div>
</div>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="estado">{{__('labels.state')}}</label>
    </div>
    <div class="col-2" title="Unidade Fiscal da Federação" data-toggle="tooltip">
        <select name="uf" id="uf" required="required" class="form-control">
            <option value="">Selecione...</option>
            @foreach(['Acre (AC)' => 'AC', 'Alagoas (AL)' => 'AL',
                'Amazonas (AM)' => 'AM', 'Amapá (AP)' => 'AP', 'Bahia (BA)' => 'BA',
                'Ceará (CE)' => 'CE', 'Distrito Federal (DF)' => 'DF',
                'Espírito Santo (ES)' => 'ES', 'Goiás (GO)' => 'GO',
                'Maranhão (MA)' => 'MA', 'Mato Grosso (MT)' => 'MT',
                'Mato Grosso do Sul (MS)' => 'MS', 'Minas Gerais (MG)' => 'MG',
                'Pará (PA)' => 'PA', 'Paraíba (PB)' => 'PB',
                'Paraná (PR)' => 'PR', 'Pernambuco (PE)' => 'PE',
                'Piauí (PI)' => 'PI', 'Rio de Janeiro (RJ)' => 'RJ', 'Rio Grande do Norte (RN)' => 'RN',
                'Rio Grande do Sul (RS)' => 'RS', 'Rondônia (RO)' => 'RO',
                'Roraima (RR)' => 'RR', 'Santa Catarina (SC)' => 'SC',
                'São Paulo (SP)' => 'SP', 'Sergipe (SE)' => 'SE', 'Tocantins (TO)' => 'TO'] as $o => $v)
                <option value="{{$v}}"{{$v == $agencia->uf ? ' selected="selected"' : ''}}>{{$o}}</option>
            @endforeach
        </select>

    </div>

    <div class="col-2 text-right">
        <label for="cidade">{{__('labels.city')}}</label>
    </div>
    <div class="col-6" title="Cidade" data-toggle="tooltip">
        <input type="text" class="form-control" id="cidade" name="cidade"
               placeholder="Cidade" value="{{$agencia->cidade}}" required="required">
    </div>

</div>

<div class="form-group row">
    <div class="col-2 text-right">
        <label for="nome">{{__('labels.cd')}}</label>
    </div>
    <div class="col-2" title="Centro de Distribuição" data-toggle="tooltip">
        <input type="text" class="form-control" id="cd" name="cd" placeholder="CD"
               required="required" value="{{$agencia->cd}}">
    </div>

    <div class="col-2 text-right">
        <label for="bairro">{{__('labels.village')}}</label>
    </div>
    <div class="col-4" title="Bairro" data-toggle="tooltip">
        <input type="text" class="form-control" id="bairro" name="bairro"
               placeholder="Bairro" value="{{$agencia->bairro}}">
    </div>

</div>