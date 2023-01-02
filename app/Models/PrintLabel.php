<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintLabel extends Model
{
  use HasFactory;

  protected $table = 'label_prints';
  protected $fillable = ['name','height','width'];
}