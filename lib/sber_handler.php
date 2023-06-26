<?
/**
 * Класс для работы с API Сбера
 */
class Sber
{
    const URL = 'https://3dsec.sberbank.ru/payment/rest/';
    const RETURN_URL = 'http://testloc.local/payment/';
    const CALLBACK_URL = 'http://testloc.local/callback/';

    const USERNAME = 'test-api';
    const PASSWORD = 'testpass';

    /**
     * @param $items
     * @return array
     *
     * Подгатавливаем корзину товаров для Сбера
     */
    public static function prepareItems($items)
    {
        $result = [];
        $arNewItems = [];

        $arItems = json_decode($items, 1);

        foreach ($arItems as $arItem)
            $arNewItems[$arItem['id']] = $arItem['q'];

        $arDbItems = $db = \DB::getInstance()->getById(implode(',', array_keys($arNewItems)));

        foreach ($arDbItems as $key => $item) {
            $result['cartItems']['items'] = [
                'positionId' => $key,
                'name' => $item['NAME'],
                'quantity' => $arNewItems[$item['ID']],
                'itemCode' => $item['ID'],
            ];
        }

        return $result;
    }

    /**
     * @param $arFields
     * @return mixed
     *
     * Отправляем запрос на регистрацию заказа в Сбере
     */
    public static function doPayment($arFields)
    {
        return self::send('register.do', $arFields);
    }

    /**
     * @param $arFields
     * @return mixed
     *
     * Получаем статус заказа
     */
    public static function getOrderStatus($arFields)
    {
        return self::send('getOrderStatus.do', $arFields);
    }

    /**
     * @param $method
     * @param $arFields
     * @return mixed
     *
     * Отправляем с помощью CURL запрос к API Сбера
     * Получаем ответ в виде десериализованного массива
     */
    protected static function send($method, $arFields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL.$method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($arFields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);

        return json_decode($result, true);
    }

    /**
     * @param $url
     *
     * Перенаправляем пользователя на страницу
     */
    public static function LocalRedirect($url = '/')
    {
        echo '<script type="text/javascript">window.location.href="' . $url . '"</script>';
    }
}