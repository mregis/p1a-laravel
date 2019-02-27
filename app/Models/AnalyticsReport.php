<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Queue\SerializesModels;

class AnalyticsReport extends Model
{
    use SoftDeletes, SerializesModels;

    /**
     * Model's states field basic entries
     */
    const STATE_CREATED = 'state_created';
    const STATE_RUNING = 'state_runing';
    const STATE_COMPLETE = 'state_complete';
    const STATE_ERROR = 'state_error';
    const STATE_FINISHED_ERROR = 'state_finished_error';
    const STATE_ABORT = 'state_abort';

    protected $fillable = [
        'user_id',
        'filename',
        'hash',
        'state',
        'args',
    ];
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'deleted_at'
    ];

    protected $table = 'analytics_report';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'state' => self::STATE_CREATED
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

}
