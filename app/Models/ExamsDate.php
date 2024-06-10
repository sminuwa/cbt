<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExamsDate
 *
 * @property int $id
 * @property int $test_id
 * @property Carbon $date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property TestConfig $test_config
 *
 * @package App\Models
 */
class ExamsDate extends Model
{
    protected $table = 'exams_dates';

    protected $casts = [
        'test_config_id' => 'int',
        'date' => 'datetime'
    ];

    protected $fillable = [
        'test_config_id',
        'date'
    ];

    public function test_config()
    {
        return $this->belongsTo(TestConfig::class, 'test_config_id');
    }
}
