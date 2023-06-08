<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Items;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

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


  
}
