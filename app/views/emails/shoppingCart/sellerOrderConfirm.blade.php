<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2><?php echo $title;?></h2>
<h4>Hello  <?php echo $sellerName;?></h4>
<p> Buyer has been bought your product.
    Please see it  in your dashboard.
    <a href = "<?php echo $sellerDashboard; ?>">Your Dashboard of purchasetree</a>
</p>
<div style="width:100%">
    <div style="display: inline-block; width: 30%; float: left;margin-right:10%;">
        <img src="<?php echo $content->options->url;?>" style="display: inline-block; width: 100%">
    </div>
    <div style="display: inline-block; width: 60%; float: left;">
        <p>
            <a href="<?php echo $url;?>">
                <?php echo $productName;
                if($content->options->color !=""){
                    echo " , ". $content->options->color." ";
                }
                if($content->options->size !=""){
                    echo " , ".strtoupper($content->options->size);
                } ?>
            </a>
        </p>
        <?php if($content->options->shipping_method !="") {?>
            <p id="shipping{{$content->options->indexID}}">
                Shipping Method : <?php echo $content->options->shipping_method; ?>

            </p>
        <?php } ?>
        <p>
            Product Price :
            <?php echo " $" .number_format($content->price,2)."USD"; ?>
            <br>
            <?php
                echo "Shipping Price : ";
                if($content->options->shipping_price !=""){

                    echo "+ $".number_format($content->options->shipping_price,2) ." ". "USD";
                }
            ?>
        </p>
        <p>
            Quantity : <?php echo $content->qty. " ". $content->options->unit; ?>
        </p>
        <p>
            Total :
            <?php
            $total_value = 0;
            $subTotalPrice = ($content->qty*round($content->price,2));
            $total_value = $total_value*1+$subTotalPrice*1;
            $subTotalShipping =0;
            if($content->options->shipping_price !=""){
                $subTotalShipping = round($content->options->shipping_price,2)*$content->qty;
                $total_value = $total_value+$subTotalShipping;
            }
            $subTotal = $subTotalPrice+$subTotalShipping;
            echo "$".number_format(round($subTotal,2),2)." USD";
            ?>
        </p>
    </div>
</div>
<div style="width: 100%; float: left">
    <p >We hope to see you again soon. <br>
        Purchasetree support team.</p>
</div>
</body>
</html>