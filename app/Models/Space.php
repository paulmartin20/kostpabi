<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
  use HasFactory;

  protected $fillable = [
      'user_id',
      'title',
      'address',
      'description',
      'latitude',
      'longitude'
  ];

  public function photos()
  {
    return $this->hasMany('App\Models\SpacePhoto', 'space_id', 'id');
  }

  public function user()
  {
    return $this->belongsTo('App\Models\User', 'user_id', 'id');
  }

  public function getSpaces($latitude, $longitude, $radius)
  {
    return $this->select('spaces.*')->selectRaw(
      '( 6371 *
          acos( cos( radians(?) ) *
              cos( radians( latitude ) ) *
              cos( radians(longitude ) - radians(?)) +
              sin( radians(?) ) *
              sin( radians( latitude ) )
          )
      ) AS distance', [$latitude, $longitude, $latitude]
    )->havingRaw("distance < ?", [$radius])->orderBy('distance', 'asc');
  }
}
