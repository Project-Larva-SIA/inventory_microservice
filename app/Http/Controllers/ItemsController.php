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

public function getItem(){

$items = Items::all();

return $this->successResponse($items, Response::HTTP_OK);

}


public function index()
{

    $items = Items::all();
    return $this->successResponse($items);
}
public function addItem(Request $request ){

    $rules = [

    'ItemName' => 'required',
    'Description' => 'required',
    'StartingBid' => 'required',
    'CurrentBid' => 'required',
    'BidderID' => 'required',

    ];

    $this->validate($request,$rules);
    $items = Items::create($request->all());

    return $this->successResponse($items,Response::HTTP_CREATED);
}

public function showItem($ItemID)
{
    $items = Items::findOrFail($ItemID);
    return $this->successResponse($items);

}

public function updateItem(Request $request,$ItemID)
{
        
    $rules = [

        'ItemName' => 'required',
        'Description' => 'required',
        'StartingBid' => 'required',
        'CurrentBid' => 'required',
        'BidderID' => 'required',
    
        ];

    $this->validate($request, $rules);
    $items = Items::findOrFail($ItemID);
    $items->fill($request->all());

    // if no changes happen
    if ($items->isClean()) {
    return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    $items->save();
    return $this->successResponse($items);

}

public function deleteItem($ItemID)
{
    $items = Items::findOrFail($ItemID);
    $items->delete();

    return $this->successResponse($items);

}

}
