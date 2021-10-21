<?php
use Bitrix\Sale;

global $USER;

if( $_GET["UTM_SOURCE"]) {

	setcookie("UTM_SOURCE", $_GET["UTM_SOURCE"], time()+86400);

}

$utmSource = $request["UTM_SOURCE"];

$order = Sale\Order::load($orderId);

$order->setField('UTM_SOURCE', 'Поле UTM_SOURCE');
$order->save();
