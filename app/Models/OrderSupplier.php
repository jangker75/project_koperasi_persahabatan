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
      'status_id', 'req_empl_id', 'order_date', 'received_date', 'note'
    ];

    public function supplier(){
      return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function toStore(){
      return $this->belongsTo(Store::class, 'to_store_id');
    }

    public function Status(){
      return $this->belongsTo(MasterDataStatus::class, 'status_id');
    }

    public function Requester(){
      return $this->belongsTo(Employee::class, 'req_empl_id');
    }

    public function Sender(){
      return $this->belongsTo(Employee::class, 'send_empl_id');
    }

    public function detailItem(){
      return $this->hasMany(DetailOrderSupplier::class, "order_supplier_id", "id");
    }
}
