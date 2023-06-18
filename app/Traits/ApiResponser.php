<?php
namespace App\Traits;
use Illuminate\Http\Response;
trait ApiResponser

{

public function successResponse($data, $code = Response::HTTP_OK){
    return response()->json(['data' => $data, 'database' => 'inventory'], $code);
}
public function successResponseFeature($data, $data2, $code = Response::HTTP_OK){
    return response()->json(['table 1' => $data, 'table 2' => $data2, 'database' => 'inventory'], $code);
}

public function errorResponse($message, $code) {
    return response()->json(['error' => $message, 'database' => 'inventory', 'code' => $code],
    $code);
}
}