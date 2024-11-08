<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransferStock extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
      'transfer_stock_code', 'from_store_id', 'to_store_id',
      'status_id', 'req_empl_id', 'send_empl_id', 'req_date','note'
    ];

    public function detailItem(){
      return $this->hasMany(DetailTransferStock::class, "transfer_stock_id", "id");
    }

    public function FromStore(){
      return $this->belongsTo(Store::class, 'from_store_id');
    }

    public function ToStore(){
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

}
