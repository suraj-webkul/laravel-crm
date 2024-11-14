<?php

namespace Webkul\Chatter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webkul\Chatter\Contracts\Task as TaskContract;
use Webkul\User\Models\User;

class Task extends Model implements TaskContract
{
    use HasFactory;

    protected $fillable = ['title', 'description'];


    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
}
