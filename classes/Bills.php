<?php
namespace Bills {
class Bill {
	private $percent_tip;
	private $subtotal;
	private $tip;
	private $total;

	function __construct($subtotal, $percent_tip = 0) {
		$this->percent_tip = $percent_tip/100;
		$this->subtotal = $subtotal;
	}
	public function setPercentTip($percent_tip) {
		if ($percent_tip) {
			$this->percent_tip = $percent_tip/100;	
			return true;
		} else {
			return false;
		}
	}
	public function getTip($split=1) {
		return number_format((float) ($this->percent_tip*$this->subtotal)/$split, 2);
	}
	public function getTotal($split=1) {
			return number_format((float) ($this->getTip()+$this->subtotal)/$split, 2);
	}
}
}
?>
