<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'sku',
        'category',
        'features',
        'keywords',
        'tone',
        'length',
        'final_description',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function aiDescriptionLogs()
    {
        return $this->hasMany(AiDescriptionLog::class);
    }
}
