<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $guarded=['']; 

      /**
     * 
     * @return \Illuminate\Database\Eloquent\Relation\Belongsto
     */

     public function employer(){
        return $this->belongsTo(Employer::class);
     }
}
