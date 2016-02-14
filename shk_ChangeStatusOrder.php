<?php
/*
 *
 * Shopkeeper plugin example
 * 
 * System event: OnSHKChangeStatus
 * 
 */

$modx->addPackage('shopkeeper', MODX_CORE_PATH."components/shopkeeper/model/");
$order = $modx->getObject('SHKorder',array('id'=>$order_id));
$e = &$modx->Event;
$output = "";

/*Получаем чанк с телом письма (предварительно его нужно создать)*/
$message = $modx->getChunk('shkMailPaymentOk');
$modx->getService('mail', 'mail.modPHPMailer');
$modx->mail->set(modMail::MAIL_BODY,$message);

/*Вместо me@example.org подставлем e-mail отправителя (т. е. от кого придет письмо)*/
$modx->mail->set(modMail::MAIL_FROM,'info@pirogi39.ru');

/*Вместо Johnny Tester подставлем имя отправителя (например, название вашего сайта, или ваше собственное имя)*/
$modx->mail->set(modMail::MAIL_FROM_NAME,'Пироги а-ля Русс');

/*Вместо Check out my new email template! подставляем заголовок сообщения*/
$modx->mail->set(modMail::MAIL_SUBJECT,'В магазине поступила оплата');

/*Вместо user@example.com подставляем адрес получателя нашего письма*/
$modx->mail->address('to','artdevice@yandex.ru');

if ($e->name == 'OnSHKChangeStatus') {
    $order_id = isset($order_id) ? $order_id : '';
    $status = isset($status) ? $status : '';

    /*Отправляем*/
    $modx->mail->setHTML(true);
    if (!$modx->mail->send()) {
        $modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the email: '.$modx->mail->mailer->ErrorInfo);
    }
    $modx->mail->reset();

    $output .= "OnSHKChangeStatus submited<br />";
    $output .= "ID заказа: $order_id, Статус: $status";

    $output = $order->get('payment');
    $modx->log (1, $output);
}
