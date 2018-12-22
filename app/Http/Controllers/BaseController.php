<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @author Matheus Marques <matheus.marques@thricein.com.br>
 */

 /**
 *  @SWG\Definition(
 *   definition="Código HTTP 200",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *          @SWG\Property(property="success", type="boolean"),
 *          @SWG\Property(property="message", type="string"),
 *          @SWG\Property(property="data", type="object")
 *       )
 *   }
 * )
 */

 /**
 *  @SWG\Definition(
 *   definition="Código HTTP 404",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *          @SWG\Property(property="success", type="boolean"),
 *          @SWG\Property(property="message", type="string")
 *       )
 *   }
 * )
 */

 /**
 *  @SWG\Definition(
 *   definition="Código HTTP 400",
 *   type="object",
 *   allOf={
 *       @SWG\Schema(
 *          @SWG\Property(property="success", type="boolean"),
 *          @SWG\Property(property="message", type="string"),
 *          @SWG\Property(property="errors", type="object")
 *       )
 *   }
 * )
 */

class BaseController extends Controller
{
    protected $redirectTo = '/';

    public function sendResponse($result, $message, $ret = false)
    {
        if (is_null($result)) {
            $response = [
                'success' => true,
                'message' => $message,
            ];
        } else {
            $response = [
                'success' => true,
                'message' => $message,
                'data'    => $result,
            ];
        }
	if($ret){
		$response['return'] = $ret;
	}
        return response()->json($response, 200);
    }

    public function sendError($error, $code)
    {
        $response     = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
