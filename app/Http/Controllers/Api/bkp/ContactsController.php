<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Models\Contacts;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Yajra\Datatables\Datatables;

class ContactsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contacts::with('client')
            ->where('id', '>', 0)
            ->get();

        return Datatables::of($contacts)
            ->addColumn('action', function ($contacts) {
                return '<div align="center"><a href="edit/' . $contacts->id . '" data-toggle="tooltip" title="Editar" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-pencil-square"></i></a><button onclick="modalDelete(' . $contacts->id . ')" data-toggle="tooltip" title="Excluir" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></button></div>';
            })
            ->make(true);

        $contacts = Contacts::where('id', '>', 0)->get();
        return $this->sendResponse($contacts->toArray(), 'Informação recuperada com sucesso');
    }

    /**
     * @SWG\Post(
     *     path="/Contacts",
     *     operationId="store",
     *     summary="Adiciona um novo cliente",
     *     tags={"Contacts"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         in="body",
     *         required=true,
     *         @SWG\Definition(
     *              @SWG\Property(property="name", type="string"),
     *              @SWG\Property(property="email", type="string"),
     *         )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Informação adicionada com sucesso",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Erro na validação dos dados",
     *     )
     * )
     */
    public function store(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_name = $this->removeCharacters($image->getClientOriginalName());
            $image_name = time() . '.' . $image_name;
            $image->move("images/PhotosContacts/", $image_name);
            Image::make("images/PhotosContacts/" . $image_name)->resize(512, 512)->save("images/PhotosContacts/" . $image_name);
            $input['image'] = "images/PhotosContacts/" . $image_name;
        }
        $input['birth_date'] = new \DateTime($input['birth_date']);;
        $contact = Contacts::create($input);
        $ret = "/Contacts/" . $contact->id;
        return $this->sendResponse(null, 'Contato cadastrado com sucesso', $ret);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contacts::where('id', $id)->first();

        if (is_null($contact)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        return $this->sendResponse($contact->toArray(), 'Informação recuperada com sucesso');
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contacts::where('id', $id)->first();
        if (is_null($contact)) {
            return $this->sendError('Informação não encontrada', 404);
        }
        $input = $request->all();
        $input['birth_date'] = new \DateTime($input['birth_date']);;
        $contact->fill($input)->save();

        return $this->sendResponse($contact->toArray(), 'Informação atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contacts::where('id', $id)->first();

        if (is_null($contact)) {
            return $this->sendError('Informação não encontrada', 404);
        }

        $contact->delete();

        return $this->sendResponse(null, 'Informação excluída com sucesso');
    }

    public function removeCharacters($string)
    {
        return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
    }
}
