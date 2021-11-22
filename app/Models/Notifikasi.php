<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [ 
        'kabupaten_id' => 'integer', 
        'peternak_id' => 'integer',
        'pendamping_id' => 'integer',
        'tsr_id' => 'integer',
        'strow_id' => 'integer',
        'user_id' => 'integer',
        'sapi_id' => 'integer',
        
        ];

        
    public function sapi()  
    {
        return $this->belongsTo(Sapi::class)->with(['status_sapi','jenis_sapi', 'peternak']);
    }

    public function peternak()  
    {
        return $this->belongsTo(Peternak::class)->with('desa');
    }
    public function pendamping()  
    {
        return $this->belongsTo(Pendamping::class);
    }
    public function tsr()  
    {
        return $this->belongsTo(Tsr::class);
    }
}