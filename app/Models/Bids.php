<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bids extends Model{

protected $table = 'bids';

public $primaryKey = 'BidID';

public $timestamps = false;

protected $fillable = [
    'BidID', 'ItemID', 'BidderID', 'BidAmount', 'BidTime'
];
}