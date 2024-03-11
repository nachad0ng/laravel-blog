<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    //protected $table =
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $guarded = [];

    public static $rules = [
        'year' => 'required|numeric|max:4',
    ];

/*
    public function getNextId() {

        return $this->attributes['year'] . str_pad($this->attributes['month'], 2, '0', STR_PAD_LEFT);
    }
*/

}
