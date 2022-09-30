<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    use HasFactory;

    protected $table = 'rates';

    protected $fillable = [
        'id',
        'currency_code',
        'date',
        'rate',
    ];
}
