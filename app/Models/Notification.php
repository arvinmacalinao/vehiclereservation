<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table        = 'notifications';
    protected $primaryKey   = 'not_id';
    protected $fillable     = [ 'not_message', 'r_id', 'u_id', 'new_user_id', 'app_id', 'read_at', 'created_at', 'updated_at' ];
    protected $timestamp    = [ 'read_at', 'created_at', 'created_at' ];
    
    
    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
			$query->where('not_message', 'LIKE', "%$search%")
            ->orWhereHas('product', function($product) use($search) {
                $product->where('prod_description', 'like', "%$search%");
                });
		});
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
    
        if ($endDate) {
            $query->whereDate('created_at', '>=', $endDate);
        }
    
        return $query;
    }
}
