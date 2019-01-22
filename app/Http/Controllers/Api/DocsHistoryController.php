<?php
/**
 * Created by PhpStorm.
 * User: Marcos Regis
 * Date: 10/12/2018
 * Time: 23:37
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\BaseController;
use App\Models\Agencia;
use App\Models\Docs;
use Symfony\Component\HttpFoundation\Request;


class DocsHistoryController extends BaseController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDocsHistory(Request $request)
    {
        $id = $request->get('id');
        try {

            if (!$doc = Docs::find($id)) {
                throw new \Exception('Capa de Lote inexistente');
            }
            if (!$file = $doc->file) {
                throw new \Exception('Arquivo não encontrado');
            }
            if (!$user = $doc->user) {
                throw new Exception('Erro ao buscar informações de usuário de capa de lote');
            }

            if ($doc->origin == null) {
                $doc->origin()->associate(new Agencia(['codigo' => $doc->from_agency, 'nome' => 'Agência sem cadastro']));
            }

            if ($doc->destin == null) {
                $doc->destin()->associate(new Agencia(['codigo' => $doc->to_agency, 'nome' => 'Agência sem cadastro']));
            }

            foreach ($doc->history as $h) {
                if (!$user = $h->user) {
                    throw new Exception('Erro ao buscar informações de usuário de histórico');
                }
                $h->local = ($h->user->agencia == null ? $h->user->unidade : (string)$h->user->agencia);
                $h->description = __('status.' . $h->description);
            }

            return response()->json($doc, 200);

        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

    }
}