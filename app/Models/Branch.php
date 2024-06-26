<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'person_incharge',
        'name',
        'location',
        'phone',
        'status',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'branches_products', 'branches_id', 'product_id')->withPivot('price');
    }


    public function branch_products()
    {
        return $this->hasMany(BranchesProduct::class,'branches_id','id');
    }
}
