<?
include ($_SERVER['DOCUMENT_ROOT'].'/template/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && !empty($_GET['orderId'])) {

    $arFields = array(
        'userName' => \Sber::USERNAME,
        'password' => \Sber::PASSWORD,
        'orderId' => $_GET['orderId']
    );

    $arStatus = \Sber::getOrderStatus($arFields);

    if (empty($arStatus['errorCode']))
        echo "<p>Статус заказа: {$arStatus['orderStatus']}</p>";
    else {
        echo "<p>Ошибка: {$arStatus['errorCode']}: {$arStatus['errorMessage']}</p>";
    }

    echo "<a href='/'>Вернуться</a>";
}

include ($_SERVER['DOCUMENT_ROOT'].'/template/footer.php');