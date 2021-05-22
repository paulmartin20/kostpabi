<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpacePhoto extends Model
{
  use HasFactory;
  protected $guarded = [];

  public function space()
  {
    return $this->belongsTo('App\Models\Space', 'space_id', 'id');
  }
}
