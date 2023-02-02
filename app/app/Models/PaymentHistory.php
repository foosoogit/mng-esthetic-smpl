<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contract;
use Illuminate\Database\Eloquent\Casts\Attribute; 

class PaymentHistory extends Model
{
    use HasFactory,SoftDeletes;

    public $AmountPersonal="";

    protected $fillable = [
		'serial_keiyaku',
		'serial_user',
		'payment_history_serial',
		'serial_staff',
		'date_visit',
	];
    /*
    public function getCardAmountAttribute($value){
		$CardAmount="";
		if($this->how_to_pay=="card" and $this->amount_payment<>""){$CardAmount=$this->amount_payment;}
		return $CardAmount;
	}
    */
    protected function CardAmount():Attribute{
        $AmountPersonal="";
        //print "how_to_pay=".$this->how_to_pay."<br>";
        if($this->how_to_pay=="card" and $this->amount_payment<>""){$AmountPersonal=$this->amount_payment;}
        return Attribute::make(
            get: fn ($value) => $AmountPersonal,
            set: fn ($value) => $AmountPersonal,
        );
	}
    /*
    public function getPayPayAmountAttribute($value){
		$PayPayAmount="";
		if($this->how_to_pay=="paypay" and $this->amount_payment<>""){$PayPayAmount=$this->amount_payment;}
		return $PayPayAmount;
	}
    */

    protected function PayPayAmount():Attribute{
        $AmountPersonal="";
        //print "how_to_pay=".$this->how_to_pay."<br>";
        if($this->how_to_pay=="paypay" and $this->amount_payment<>""){$AmountPersonal=$this->amount_payment;}
        return Attribute::make(
            get: fn ($value) => $AmountPersonal,
            //set: fn ($value) => $AmountPersonal,
        );
	}
    /*
	public function getCashAmountAttribute($value){
		$CashAmount="";
		$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		//print_r($kyakuInf);
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin=='1' ){
				$CashAmount=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card=='1' ){
				$CashAmount=$this->amount_payment;
			}
		}
		return $CashAmount;
	}
    */

    protected function CashAmount():Attribute{
        $AmountPersonal="";
        $kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
        //print "how_to_pay=".$this->how_to_pay."<br>";
        if($this->how_to_pay=="cash" and $this->amount_payment<>""){
            if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin==1 ){
				$AmountPersonal=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card>1 ){
				$AmountPersonal=$this->amount_payment;
			}
            //$AmountPersonal=$this->amount_payment;
        
        }
        //print "how_to_pay=".$this->how_to_pay."<br>";
        return Attribute::make(
            get: fn ($value) => $AmountPersonal,
            //set: fn ($value) => $AmountPersonal,
        );
	}

	/*
    public function getCashSplitAttribute($value){
		$CashSplit="";
    	$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin>1 ){
				$CashSplit=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card>1 ){
				$CashSplit=$this->amount_payment;
			}
		}
		return $CashSplit;
	}
    */

	protected function CashSplit():Attribute{
        $AmountPersonal="";
        $kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin>1 ){
				$AmountPersonal=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card>1 ){
				$AmountPersonal=$this->amount_payment;
			}
		}
        return Attribute::make(
            get: fn ($value) => $AmountPersonal,
            //set: fn ($value) => $AmountPersonal,
        );
	}
    /*
	public function getCashTotalAttribute($value){
		$CashSplit="";
    	$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin>=1 ){
				$CashSplit=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card>=1 ){
				$CashSplit=$this->amount_payment;
			}
		}
		return $CashSplit;
	}
    */

    protected function CashTotal():Attribute{
        $AmountPersonal="";
        //$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin>=1 ){
				$AmountPersonal=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card>=1 ){
				$AmountPersonal=$this->amount_payment;
			}
		}
        return Attribute::make(
            get: fn ($value) => $AmountPersonal,
            //set: fn ($value) => $AmountPersonal,
        );
	}
    
}
