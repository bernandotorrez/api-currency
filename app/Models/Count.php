<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Count extends Model
{
    protected $table = 'tbl_count_call_api';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address', 'id_curr'
    ];
}
