<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Release Escrow</h2>
@if($user_type == "seller")
    <p>Buyer User Name : {{$buyer->username}}</p>
    <p>Buyer has been release escrow to you.</p>
    <p>Please select payment method for this.</p>
    <p>Admin will send funds to you.</p>
@elseif($user_type == "buyer")
    <p>You has been release escrow to seller.</p>
    <p>Admin will send funds to seller.</p>
@elseif($user_type == "admin")
    <p>Buyer User Name : {{$buyer->username}}</p>
    <p>Buyer has been release escrow to seller. </p>
    <p>Seller user name is {{$seller->username}}</p>
    <p>Please check this url : {{URL::route('admin.shoppingCart.payment',$shoppingCartProduct->cart_id)}}</p>
@endif

<p>Purchasetree.com Support</p>
</body>
</html>
