<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderSupplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'order_supplier_code', 'supplier_id', 'to_store_id',
      'status_id', 'req_empl_id', 'order_date', 'received_date', 'note', 'total', 'is_paid'
    ];

    public function supplier(){
      return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function toStore(){
      return $this->belongsTo(Store::class, 'to_store_id');
    }

    public function status(){
      return $this->belongsTo(MasterDataStatus::class, 'status_id');
    }

    public function requester(){
      return $this->belongsTo(Employee::class, 'req_empl_id');
    }

    public function sender(){
      return $this->belongsTo(Employee::class, 'send_empl_id');
    }

    public function detailItem(){
      return $this->hasMany(DetailOrderSupplier::class, "order_supplier_id", "id");
    }
}
