<?

/**
 * класс для работы с БД
 *
 */
class DB {
    protected $db;
    static private $instance = null;

    /**
     * @var string
     * Параметры подключения
     */
    private $host = 'localhost';
    private $port = 10005;
    private $login = 'root';
    private $password = 'root';
    private $db_name = 'local';

    private function __construct() {
        $this->db = new \mysqli(
            $this->host,
            $this->login,
            $this->password,
            $this->db_name,
            $this->port
        );
    }

    private function __clone() {}

    static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return mixed
     * @throws Exception
     *
     * Получаем товары из таблицы product
     */
    public function getItems() {
        $result = $this->db->query('SELECT * FROM `product`');

        if (!empty($this->db->error_list)) {
            throw new \Exception(implode('<br>', array_column($this->db->error_list, 'error')));
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }


    /**
     * @param $id
     * @return array|null
     * @throws Exception
     *
     * Получаем товар по его id
     */
    public function getById($id) {

        $result = $this->db->query("SELECT * FROM `product` WHERE id in ({$id})");

        if (!empty($this->db->error_list)) {
            throw new \Exception(implode('<br>', array_column($this->db->error_list, 'error')));
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * @param $arFields
     * @return array
     *
     * Экранируем параметры запроса для вставки нового значения
     */
    protected function prepareFields($arFields) {
        $newResult = [];

        foreach ($arFields as $key=>$item)
            $newResult["`" . $key . "`"] = "'" . $item . "'";

        $keys = implode(',', array_keys($newResult));
        $values = "".implode(",", $newResult)."";

        return [
            'KEYS' => $keys,
            'VALUES' => $values
        ];
    }

    /**
     * @param $arFields
     * @return mixed
     * @throws Exception
     *
     * Добавляем информацию о заказе в таблицу order
     */
    public function addOrder($arFields) {

        $arData = self::prepareFields($arFields);

        try {
            $this->db->query("INSERT INTO `order` ({$arData['KEYS']}) VALUES ({$arData['VALUES']})");
        }
        catch (\Exception $e) {
            die($e->getMessage());
        }

        if (!empty($this->db->error_list)) {
            throw new \Exception(implode('<br>', array_column($this->db->error_list, 'error')));
        }

        return $this->db->insert_id;
    }

    /**
     * @param $orderId
     * @return mixed
     * @throws Exception
     *
     * Добавляем начальный статус заказа в таблицу order_status
     */
    public function addOrderStatus($orderId) {

        $arFields = [
            'ORDER_ID' => $orderId,
            'OPERATION' => 'NEW',
            'DATE' => date(DATE_RFC822),
            'STATUS' => 1,
        ];

        $arData = self::prepareFields($arFields);

        try {
            $this->db->query("INSERT INTO `order_status` ({$arData['KEYS']}) VALUES ({$arData['VALUES']})");
        }
        catch (\Exception $e) {
            die($e->getMessage());
        }

        if (!empty($this->db->error_list)) {
            throw new \Exception(implode('<br>', array_column($this->db->error_list, 'error')));
        }

        return $this->db->insert_id;
    }

    /**
     * @param $id
     * @param $arFields
     * @return bool|mixed
     * @throws Exception
     *
     * Обновляем информациюо статусу заказа
     */
    public function updateOrderStatus($id, $arFields) {

        if (empty($id))
            return false;

        $str = '';
        foreach ($arFields as $key=>$value)
            $str .= $key.'="'.$value.'",';

        $str = substr($str, 0, -1);

        try {
            $this->db->query("UPDATE `order_status` SET {$str} WHERE ORDER_ID = {$id}");
        }
        catch (\Exception $e) {
            die($e->getMessage());
        }

        if (!empty($this->db->error_list)) {
            throw new \Exception(implode('<br>', array_column($this->db->error_list, 'error')));
        }

        return $this->db->insert_id;
    }
}