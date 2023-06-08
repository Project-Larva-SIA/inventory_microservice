<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Bids;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use App\Models\Items;

Class BidsController extends Controller {
use ApiResponser;
private $request;


public function __construct(Request $request){
    $this->request = $request;
}

public function getBids(){

$bids = Bids::all();

return $this->successResponse($bids, Response::HTTP_OK);

}

public function show($BidID)
{
    $specificData = Bids::find($BidID);

    if (!$specificData) {
        return response()->json(['message' => 'Bid not found'], 404);
    }

    $bidderId = $specificData->BidderID;
    $bidAmount = $specificData->BidAmount;
    $itemId = $specificData->ItemID;

    // Fetch the ItemName based on the ItemID
    $item = Items::find($itemId);
    $itemName = $item ? $item->ItemName : null;

    return response()->json(['BidderID' => $bidderId, 'BidAmount' => $bidAmount, 'ItemName' => $itemName]);
}



public function index()
{

    $bids = Bids::all();
    return $this->successResponse($bids);
}
public function addBid(Request $request ){

    $rules = [

    'ItemID' => 'required',
    'BidderID' => 'required',
    'BidAmount' => 'required',
    'BidTime' => 'required',

    ];

    $this->validate($request,$rules);
    $bids = Bids::create($request->all());

    return $this->successResponse($bids,Response::HTTP_CREATED);
}

public function showBid($BidID)
{
    $bids = Bids::findOrFail($BidID);
    return $this->successResponse($bids);

}

public function updateBid(Request $request,$BidID)
{
        
    $rules = [

        'ItemID' => 'required',
        'BidderID' => 'required',
        'BidAmount' => 'required',
        'BidTime' => 'required',
    
        ];

    $this->validate($request, $rules);
    $bids = Bids::findOrFail($BidID);
    $bids->fill($request->all());

    // if no changes happen
    if ($bids->isClean()) {
    return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    $bids->save();
    return $this->successResponse($bids);

}

public function deleteBid($BidID)
{
    $bids = Bids::findOrFail($BidID);
    $bids->delete();

    return $this->successResponse($bids);

}

}
