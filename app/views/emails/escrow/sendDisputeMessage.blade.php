<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Dispute Message</h2>
@if($user_type == "seller")
    <p>Seller User Name : {{$user->username}}</p>
    <p>You has been get message from seller.</p>
    <p>Please contact with this buyer.</p>
    <p>Subject : {{ $subject }}</p>
    <p>Content : {{ $content }}</p>
    <p>Please check escrow dispute page. This is url {{route('user.escrow.shoppingCartDispute',100000*1+$shoppingCartProduct->id)}}</p>
@elseif($user_type == "buyer")
    <p>Buyer User Name : {{$user->username}}</p>
    <p>You has been get message from buyer.</p>
    <p>Subject : {{ $subject }}</p>
    <p>Content : {{ $content }}</p>
    <p>Please check escrow dispute page. This is url {{route('user.escrow.shoppingCartDispute',100000*1+$shoppingCartProduct->id)}}</p>
@elseif($user_type == "admin")
    @if($sender == "seller")
        <p>Seller User Name : {{$user->username}}</p>
        <p>Seller has been send message to Buyer</p>
        <p>Please check escrow dispute page. This is url {{route('user.escrow.shoppingCartDispute',100000*1+$shoppingCartProduct->id)}}</p>
    @else
        <p>Buyer User Name : {{$user->username}}</p>
        <p>Buyer has been send message to Seller</p>
        <p>Please check escrow dispute page. This is url {{route('user.escrow.shoppingCartDispute',100000*1+$shoppingCartProduct->id)}}</p>
    @endif
@endif
<p>Purchasetree.com Support</p>
</body>
</html>
