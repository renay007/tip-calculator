<!doctype html>
<?php
	require_once(__DIR__.'/classes/Bills.php');
	require_once(__DIR__.'/functions.php');

	$radio_buttons = [10, 15, 20];

	$subtotal = isset($_POST['subtotal']) ? $_POST['subtotal'] : "0";
	$percent_tip = isset($_POST['percent_tip']) ? $_POST['percent_tip'] : $radio_buttons[0];
	$custom_tip = isset($_POST['custom_tip']) ? $_POST['custom_tip'] : "";
	$split = isset($_POST['split']) ? $_POST['split'] : "1";

	$invalid_bill = "";
	$invalid_percent_tip = "";
	$invalid_split = "";

	$isValidTip = false;

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$invalid_bill = !isValid($subtotal) ? "invalid" : "";
			$invalid_percent_tip = ($percent_tip == "custom" && !isValid($custom_tip)) ? "invalid" : "";
			$invalid_split = !isValidSplit($split) ? "invalid" : "";

		if (isValid($subtotal)) {	
				$new_bill = new Bills\Bill($subtotal); 
			if (isValid($percent_tip) && isValidSplit($split)) {
				$new_bill->setPercentTip($percent_tip);
				$isValidTip = true;
			} else  if ($percent_tip == "custom" && isValid($custom_tip) && isValidSplit($split)) {
				$new_bill->setPercentTip($custom_tip);
				$isValidTip = true;
			} else {
				$isValidTip = false;
			}
		} else {
			$isValidTip = false;
		}
	}
?>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="Tip Calculator">
        <meta name="viewport" content="width=device-width, initial-scale=1">
				
				<link rel="stylesheet" href="css/main.css">
				<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body class="bg-yellow">
				<div class="row">
					<div class="col-sm-4 col-sm-offset-4 bg-white shadow margin-top">
						<h2 class="text-center">Tip Calculator</h2>
						<form name="calculator_form" method="post">
							<div class="<?php echo $invalid_bill;?> col-sm-10 col-sm-offset-1 margin-top form-group form-inline">
								<label for="subtotal">Bill Subtotal: $</label>
								<input type="text" class="form-control" id="subtotal" name="subtotal" value="<?php echo $subtotal; ?>" placeholder="Subtotal">
							</div>
							<div class="<?php echo $invalid_percent_tip;?> col-sm-10 col-sm-offset-1 form-group margin-top">
								<?php foreach($radio_buttons as $radio_button) { ?>
										<label class="radio-inline">
											<input type="radio" 
														 name="percent_tip" 
														 id="<?php echo $radio_button;?>_percent" 
														 <?php echo ($radio_button == $percent_tip) ? "checked = 'checked'": ''; ?>
														 value="<?php echo $radio_button;?>"> 
														 <?php echo $radio_button;?>%
										</label>
								<?php	} ?>
								<label class="radio-inline">
								<input type="radio" name="percent_tip" id="custom_percent" <?php echo ($percent_tip == "custom") ? "checked = 'checked'": '';?> value="custom"> Custom
								</label>
							</div>
							<div style="display_none" id="custom_box" class="<?php echo $invalid_percent_tip;?> col-sm-10 col-sm-offset-1 text-center form-group form-inline">
								<input type="text" name="custom_tip" value="<?php echo $custom_tip;?>" class="form-control" placeholder="Custom"> %
							</div>
							<div class="<?php echo $invalid_split;?> margin-top col-sm-10 col-sm-offset-1 form-group form-inline">
								<label for="split">Split: </label>
								<input type="text" class="form-control" id="split" name="split" value="<?php echo $split; ?>" placeholder="Split">
								<label for="split"> person(s) </label>
							</div>
							<div class="col-sm-10 col-sm-offset-1 form-group margin-top margin-bottom text-center">
								<button type="submit" class="submit-button btn btn-block btn-default">Submit</button>
							</div>
							<?php if ($isValidTip) { ?>
								<div class="col-sm-10 margin-bottom col-sm-offset-1">
									<div class="border bg-light-yellow col-sm-12 margin-bottom">
										<p class="">Tip: $<span><?php echo $new_bill->getTip();?></span></p>
										<p class="">Total: $<span><?php echo $new_bill->getTotal();?></span></p>
										<?php if ($split > 1) { ?>
											<p class="">Tip each: $<span><?php echo $new_bill->getTip($split);?></span></p>
											<p class="">Total each: $<span><?php echo $new_bill->getTotal($split);?></span></p>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</form>
					</div>
				</div>

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
				<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
				<script src="js/main.js"></script>
    </body>
</html>
