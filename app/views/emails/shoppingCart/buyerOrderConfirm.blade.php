<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2><?php echo $title;?></h2>
<h4>Hello  <?php echo $customer_name;?></h4>
<p><?php echo $description;?></p>
<p>Your purchase has been divided into <?php echo count($contents);?> orders.</p>

<?php
   $i =1;
foreach($contents as $key =>$content){?>
   <h4 style="width: 100%; float: left">Order <?php echo $i; $i++; ?> of  <?php echo count($contents);?></h4>
   <div style="width:100%;float: left">
       <div style="display: inline-block; width: 30%; float: left; margin-right:10%">
           <img src="<?php echo $content->options->url;?>" style="display: inline-block; width: 100%">
       </div>
       <div style="display: inline-block; width: 60%; float: left;">
            <p><?php echo $customer_name; ?></p>
           <p><?php echo $shipping_address; ?></p>
           <p><?php echo $shipping_city; if($shipping_state !=""){echo  " ". $shipping_state;} echo " ". $shipping_zip.  "  ". $shipping_country; ?></p>
           <p>
               <?php
                   $subTotal = $content->qty * round($content->price, 2);
                   $subTotalShipping = 0;
                   if ($content->options->shipping_price != "") {
                       $subTotalShipping = $content->qty * round($content->options->shipping_price, 2);
                   }
                       $subTotalList =($subTotal + $subTotalShipping);
                       $escrowFee = round($escrowFeeRate*$subTotalList,2);
                  echo "Sub Total :  $"." ". number_format($subTotalList,2) ."<br>";
                  echo "Escrow Fee : $"." ". number_format($escrowFee,2) ."<br>";
                  echo "Total : $"." ". number_format(($subTotalList*1+$escrowFee*1),2);
               ?>
           </p>
       </div>
   </div>
<?php }?>

<div style="width: 100%; float: left">
    <p >We hope to see you again soon. <br>
        Purchasetree support team.</p>
</div>

</body>
</html>
