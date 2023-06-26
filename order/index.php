<?
include ($_SERVER['DOCUMENT_ROOT'].'/template/header.php');

$arRequest = $_REQUEST;

if ($arRequest['action'] == 'submitForm') {

    if (empty($arRequest['items'])) {
        echo '<p>Добавьте товары в корзину</p>';
        echo '<a href="/">Вернуться</a>';
        die();
    }

    $arFields = [
        'DATE' => date('d.m.Y H:i:s'),
        'FIO' => $arRequest['fio'],
        'PRICE' => (float)$arRequest['summ'],
        'ITEMS' => $arRequest['items'],
    ];

// добавляем новый заказ
    $orderId = DB::getInstance()->addOrder($arFields);

// регистрируем заказ на стороне Сбера
    if ($orderId > 0) {

        DB::getInstance()->addOrderStatus($orderId);

        $arParams = [
            'userName' => \Sber::USERNAME,
            'password' => \Sber::PASSWORD,
            'orderNumber' => $orderId,
            'amount' => $arFields['PRICE'] * 100,
            'currency' => 'RUB',
            'orderBundle' => \Sber::prepareItems($arRequest['items']),
            'returnUrl' => Sber::RETURN_URL
        ];

        $result = \Sber::doPayment($arParams);

// выводим сообщение об ошибке в случае имеющейся
        if (!empty($result['errorCode'])) {

            switch ($result['errorCode']) {
                case 5:
                    $errorText = 'Ошибка авторизации магазина';
                    break;

                default:
                    $errorText = $result['errorMessage'];
                    break;
            }

            echo "<p class='alert alert-danger'>{$errorText}</p>";
            echo '<a href="/">Вернуться</a>';

        } // иначе - перенаправляем на страницу оплаты
        else
            \Sber::LocalRedirect($result['formUrl']);
    }
}

include ($_SERVER['DOCUMENT_ROOT'].'/template/footer.php');