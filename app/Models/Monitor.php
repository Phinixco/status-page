<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int id
 * @property string name
 * @property string status
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Monitor extends Model
{
    const STATUS_DOWN = 'DOWN';
    const STATUS_UP = 'UP';

    const STATUSES = [
        self::STATUS_DOWN,
        self::STATUS_UP
    ];


    use SoftDeletes;
    use HasFactory;

    protected $guarded = [];
}
