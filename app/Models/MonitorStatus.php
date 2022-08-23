<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string status
 * @property int monitor_id
 * @property Carbon started_at
 * @property Carbon ended_at
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class MonitorStatus extends Model
{
    use HasFactory;
}
