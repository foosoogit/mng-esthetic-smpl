<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
		'name',
		'email',
		'number_keiyaku',
		'serial_keiyaku',
		'serial_user',
		'serial_Teacher',
		'course',
		'keiyaku_kikan',
		'keiyaku_naiyo',
		'keiyaku_bi',
		'keiyaku_kingaku',
		'keiyaku_num',
		'keiyaku_kingaku_total',
		'date_latest_visit',
		'remarks',
	];

    public function getKeiyakuZankinAttribute($value){
		$PaidAmount=PaymentHistory::where('serial_keiyaku','=',$this->serial_keiyaku)
						->where('date_payment','<>',"")
						->selectRaw('SUM(amount_payment) as paid')->first();
		$keiyaku_kingaku=0;
		if(isset($this->keiyaku_kingaku)){
			$keiyaku_kingaku=$this->keiyaku_kingaku;
		}
		$keiyaku_zankin = (int)$keiyaku_kingaku-(int)$PaidAmount['paid'];
		return $keiyaku_zankin;
	}
}
