<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Models\Bids;
use App\Traits\ApiResponser;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;
class FeaturesController extends Controller

{

  use ApiResponser;

  private $request;

  public function __construct(Request $request){
      $this->request = $request;
  }

  public function filter(Request $request){
    // allow to filter an item

  $searchInput = $request->input('s');


  $items = Items::where('ItemName', 'LIKE', '%' . $searchInput . '%')->get();

  if ($items->isEmpty()) {
      return response()->json(['message' => 'No results']);
  }

  return response()->json($items);
  
    }
  



public function updateBidAmount(Request $request, $BidID)
{
     // Fetch the bid record from the bids table
     $bid = Bids::findOrFail($BidID);

     // Retrieve the corresponding item record from the Items table
     $item = Items::findOrFail($bid->ItemID);
 
     // Validate the bid amount
     $validator = Validator::make($request->all(), [
         'BidAmount' => 'required|numeric|min:' . ($item->CurrentBid + 1),
     ]);
 
     if ($validator->fails()) {
         return response()->json(['error' => $validator->errors()], 400);
     }
 
     // Update the CurrentBid column in the item record
     $item->CurrentBid = $request->input('BidAmount');
     $item->fill($request->all());

     $bid->BidAmount = $request->input('CurrentBid');
     $bid->fill($request->all());
     
     // Save the changes to the item record
     $item->save();
     $bid->save();
    //  $amount = "Successfully Updated Bid Amount";
 
     return $this->successResponseFeature($item, $bid);
}

public function addBidAmount(Request $request)
{
      $item = Items::findOrFail($request->input('ItemID'));
      // Validate the request data
      $validator = Validator::make($request->all(), [
          'ItemID' => 'required|numeric',
          'BidderID' => 'required|numeric',
          'BidAmount' => 'required|numeric|min:' . $item->StartingBid,
      ]);
  
      if ($validator->fails()) {
          return response()->json(['error' => $validator->errors()], 400);
      }
  
      // Create a new bid record
      $bid = new Bids();
      $bid->ItemID = $request->input('ItemID');
      $bid->BidderID = $request->input('BidderID');
      $bid->BidAmount = $request->input('BidAmount');
      $bid->BidTime = Carbon::now();
      $bid->save();
  
      // Retrieve the corresponding item record
      $item = Items::findOrFail($request->input('ItemID'));
  
      // Update the CurrentBid column in the item record if the new bid is higher
      if ($bid->BidAmount > $item->CurrentBid) {
          $item->CurrentBid = $bid->BidAmount;
          $item->save();
      }
  
      if ($bid->BidderID > $item->BidderID) {
          $item->BidderID = $bid->BidderID;
          $item->save();
       
      }
  
      return $this->successResponse($bid);

  
  }



  public function HigherBid()
  {
      // Retrieve items with higher bids
      $items = Items::where('CurrentBid', '>', 0)
          ->orderBy('CurrentBid', 'desc')
          ->get(['ItemName', 'CurrentBid']);
  
      return $this->successResponse($items);
  }


// Show Item Name and Bid Amount using BidID
public function showHighBidItem($BidID)
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
  

}



