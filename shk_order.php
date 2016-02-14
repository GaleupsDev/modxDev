<?php

/* Получаем информацию о заказе 550 */
 $order_id = 552;
 if ($order_id) {
	$modx->addPackage('shopkeeper', MODX_CORE_PATH."components/shopkeeper/model/");
	$order = $modx->getObject('SHKorder',array('id'=>$order_id));
	$output = $order->toArray();
	$arr = unserialize($output['content']);
} 

for($i = 0; $i < count($arr); $i++)
{
 foreach($arr[$i] as $key => $val){
  if($key == 'link') echo $val;
 }
};
