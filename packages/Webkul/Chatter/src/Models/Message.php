<?php

namespace Webkul\Chatter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Chatter\Contracts\Message as MessageContract;
use Webkul\User\Models\User;

class Message extends Model implements MessageContract
{
    use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'content'];


    protected $appends = ['ago'];

    public function getAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
