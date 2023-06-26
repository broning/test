<?
include ($_SERVER['DOCUMENT_ROOT'].'/lib/db.php');

if (!empty($_GET['orderNumber'])) {

    $orderId = $_GET['orderNumber'];
    $arFields = [
        'DATE' => $_GET['callbackCreationDate'] ? $_GET['callbackCreationDate'] : date(DATE_RFC822),
        'OPERATION' => $_GET['operation'],
        'STATUS' => $_GET['status'],
    ];

    DB::getInstance()->updateOrderStatus($orderId, $arFields);
}
