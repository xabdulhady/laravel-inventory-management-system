<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CsvData extends Model
{

    use HasFactory;
    protected $fillable = ['data_id', 'header_data', 'csv_data'];
}
