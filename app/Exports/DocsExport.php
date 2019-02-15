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
            'SITUAÇÃO',
            'MOVIMENTO',
            'NOME ARQUIVO',
            'TIPO ARQUIVO',
            'AGÊNCIA ORIGEM',
            'AGÊNCIA DESTINO',
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
            __('status.' . $reg->status),
            Date::dateTimeToExcel(new \DateTime($reg->movimento)),
            $reg->filename,
            __('labels.' . $reg->constante),
            sprintf("%04d: %s", $reg->from_agency, $reg->origin),
            sprintf("%04d: %s", $reg->to_agency, $reg->destin),
            $reg->username,
            $reg->profile,
            ($reg->juncao != null ? $reg->agencia_usuario : ($reg->unidade != null ? $reg->unidade : '-')),
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
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }
}
