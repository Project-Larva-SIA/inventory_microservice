<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model{

protected $table = 'items';

public $primaryKey = 'ItemID';

public $timestamps = false;

protected $fillable = [
    'ItemID', 'ItemName', 'Description', 'StartingBid', 'CurrentBid', 'BidderID'
];
}