<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DocsExport implements FromQuery, WithColumnFormatting, WithMapping, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'CAPA DE LOTE',
            'MOVIMENTO',
            'TIPO ARQUIVO',
            'AGENCIA ORIGEM',
            'NOME ORIGEM',
            'AGENCIA DESTINO',
            'NOME DESTINO',
            'SITUAÇÃO',
            'CRIADO POR',
            'PERFIL',
            'LOCALIDADE',
            'DATA CRIAÇÃO',
        ];
    }

    /**
     * @param mixed $reg
     * @return array
     */
    public function map($reg): array
    {
        return [
            $reg->content,
            Date::dateTimeToExcel(new \DateTime($reg->movimento)),
            __('labels.' . $reg->constante),
            sprintf("%04d", $reg->from_agency),
            $reg->nome_agencia_origem,
            sprintf("%04d", $reg->to_agency),
            $reg->nome_agencia_destino,
            __('status.' . $reg->descricao_historico),
            $reg->nome_usuario_criador,
            $reg->perfil_usuario_criador,
            ($reg->juncao_usuario_criador != null ? $reg->juncao_usuario_criador : ($reg->unidade_criador != null ? $reg->unidade_criador : '-')),
            Date::dateTimeToExcel(new \DateTime($reg->created_at)),
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
