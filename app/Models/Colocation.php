<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = ['name','status','owner_id'];


    public function owner(){
        return $this->belongsTo(User::class,'owner_id');
    }

    public function members(){
        return $this->belongsToMany(User::class)
                    ->withPivot('role','joined_at','left_at');
    }
    public function invitations()
{
    return $this->hasMany(Invitation::class);
}

public function expenses()
{
    return $this->hasMany(Expense::class);
}

public function categories()
{
    return $this->hasMany(Category::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}
}
