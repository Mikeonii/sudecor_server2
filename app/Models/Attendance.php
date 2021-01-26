<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class Attendance extends Model
{
    use HasFactory;
    public $timestamps = false;
    public function client(){
    	return $this->belongsTo(Client::class);
    }
}
