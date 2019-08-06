<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Release Escrow</h2>
@if($user_type == "seller")
    <p>Buyer User Name : {{$buyer->username}}</p>
    <p>Buyer has been dispute escrow.</p>
    <p>Please contact with this buyer.</p>
    <p>Please check escrow dispute page. This is url {{route('user.escrow.shoppingCartDispute',100000*1+$shoppingCartProduct->id)}}</p>
    <p>Admin will send funds to you.</p>
@elseif($user_type == "buyer")
    <p>You  has been dispute escrow.</p>
    <p>Please contact to seller.</p>
    <p>Please check escrow dispute page. This is url {{route('user.escrow.shoppingCartDispute',100000*1+$shoppingCartProduct->id)}}</p>
@elseif($user_type == "admin")
    <p>Buyer User Name : {{$buyer->username}}</p>
    <p>Buyer has been dispute escrow. </p>
    <p>Seller user name is {{$seller->username}}</p>
@endif
<p>Purchasetree.com Support</p>
</body>
</html>
