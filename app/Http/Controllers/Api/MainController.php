<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Exception;
use Illuminate\Http\JsonResponse;

class MainController extends Controller
{
    public function togglePublish(Request $request): JsonResponse
    {
        try {
            $cmid = $request->cmid;
            $class = $request->classPath;

            $model = $class::find($cmid);
            $model->status = !$model->status;
            $model->save();

            return response()->json([
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status'    => 204,
                'message'   => $e->getMessage()
            ]);
        }
    }
}
