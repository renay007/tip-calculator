<?php
/**
 * isValid($number) -> true if bill is numeric and bill  > 0 
 * 									-> true if tip is numeric and tip > 0
 * 									-> false otherwise
 *
 * isValidSplit($number) -> true if split is a positive integer, split >= 1
 * 											 -> false otherwise
 * */

function isValid($number) {
	return is_numeric($number) && $number > 0;
}
function isValidSplit($number) {
	return ctype_digit($number) && $number >= 1;
}

?>
