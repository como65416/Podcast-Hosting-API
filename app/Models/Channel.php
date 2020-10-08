<?php

namespace App\Models;

use App\Models\Item;
use App\Models\Member;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    protected $table = 'channel';

    protected $dateFormat = 'U';

    use SoftDeletes;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
