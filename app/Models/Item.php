<?php

namespace App\Models;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    protected $table = 'item';

    protected $dateFormat = 'U';

    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
