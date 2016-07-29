<?php
namespace App\Models;

use App\Eloquent\Model;

class X_AD_TABLE extends Model
{
	protected $table = 'ad_table';

	protected $primaryKey = 'ad_table_id';

	public function scopeActive($query){
		return $query->where('ISACTIVE', 'Y');
	}


}