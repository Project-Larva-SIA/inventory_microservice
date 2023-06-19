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


public function index()
{

    $bids = Bids::all();
    return $this->successResponse($bids);
}

public function showBid($BidID)
{
    $bids = Bids::findOrFail($BidID);
    return $this->successResponse($bids);

}

public function deleteBid($BidID)
{
    $bids = Bids::findOrFail($BidID);
    $bids->delete();

    return $this->successResponse($bids);

}

}
