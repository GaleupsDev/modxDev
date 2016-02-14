<?php

/* Получаем информацию о заказе 550 */
 $order_id = 550;
 if ($order_id) {
		$modx->addPackage('shopkeeper', MODX_CORE_PATH."components/shopkeeper/model/");
		$order = $modx->getObject('SHKorder',array('id'=>$order_id));
		$output = $order->toArray();
		print_r($output);
	} 
