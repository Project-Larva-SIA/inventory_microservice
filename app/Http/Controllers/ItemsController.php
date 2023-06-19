<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

Class ItemsController extends Controller {
use ApiResponser;
private $request;


public function __construct(Request $request){
    $this->request = $request;
}


public function index()
{

    $items = Items::all();
    return $this->successResponse($items);
}
public function addItem(Request $request ){

    $this->validate($request, [
        'ItemName' => 'required',
        'Description' => 'required',
        'StartingBid' => 'required|numeric',
        ]);

    $items = Items::create($request->all());
    return $this->successResponse($items,Response::HTTP_CREATED);
}

public function showItem($ItemID)
{
    $items = Items::findOrFail($ItemID);
    return $this->successResponse($items);

}


public function deleteItem($ItemID)
{
    $items = Items::findOrFail($ItemID);
    $items->delete();

    return $this->successResponse($items);

}

}
