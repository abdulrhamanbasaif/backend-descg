<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiDescriptionLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'product_id',         
        'generated_text',
        'request_data',
        'response_data'
    ];

    protected $casts = [
        'request_data' => 'array',
        'response_data' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
