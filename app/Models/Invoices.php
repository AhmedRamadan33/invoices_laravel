<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoices extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $table = 'invoices';
  protected $fillable = [
    'invoice_Date',
    'Due_date',
    'product',
    'section_id',
    'Amount_collection',
    'Amount_Commission',
    'Discount',
    'Value_VAT',
    'Rate_VAT',
    'Total',
    'Status',
    'Value_Status',
    'note',
    'Payment_Date',
  ];
  public function sections()
  {
    return $this->belongsTo(Sections::class, 'section_id', 'id');
  }
}
