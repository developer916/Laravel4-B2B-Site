<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>@if($type == "agreement") Agreement Mode @elseif($type == "escalation") Escalation Mode @endif</h2>
<p>Please check escrow dispute page. This is url {{route('user.escrow.shoppingCartDispute',100000*1+$shoppingCartProduct->id)}}</p>
