<?php

namespace App\Models;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';

    protected $dateFormat = 'U';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }
}
