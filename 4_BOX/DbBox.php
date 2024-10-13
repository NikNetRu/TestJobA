<?php
/*
$dsn = "mysql:dbname=astrio;host=127.0.0.1"; параметры хоста для PDO
$user = "root"; логин для БД
$password = '';  пароль для БД
$table = 'box'; наименование таблицы
*/

/*
создание экземпляра DbBox::getInstanse($dsn, $user, $password, $table);
столбцы таблицы куда записывается ключ, значение: $keyColumn - $valueColumn 
*/
class DbBox extends AbstractBox{
	
	protected static $instance;
		private $dsn = null;
		private $user = null;
		private $password = null;
		private $table = null;
		private $keyColumn = 'keyBox';
		private $valueColumn = 'valueBox';
     
    protected function __construct ($dsn, $user, $password, $table) 
    {
        $this->dsn = $dsn;
        $this->user = $user;
        $this->password = $password;
        $this->table = $table;
    }

	protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

	/*
	Сохраняем в БД
	Если ключ существует перезаписываем
	для сохранения любых данных в БД допишем сериализацию $value
	*/
	public function save() {
		$link = new PDO($this->dsn, $this->user, $this->password);
		$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$currentBox = $this->box;	
		foreach ($currentBox as $key => $value) {
			$query = "SELECT * FROM $this->table WHERE `$this->keyColumn` = '$key'";
			$result = $link->query($query);
			$value = serialize($value);
			if ($result->rowCount() != 0) {
				$query = "UPDATE $this->table SET $this->valueColumn = '$value' WHERE `$this->keyColumn` = '$key'";
				$result = $link->query($query);
				try {
				  $result = $link->query($query);
				  echo "Updated  $key - $value  succeeded";

				} catch(PDOException $e) {
				  echo "Updated $key - $value failed!";
				  echo 'Error: ' . $e->getMessage();
				}
			} else {
				$query = "INSERT INTO  $this->table ($this->keyColumn, $this->valueColumn) VALUES ('$key','$value')";
				try {
				  $result = $link->query($query);
				  echo "INSERT  $key - $value  succeeded";

				} catch(PDOException $e) {
				  echo "INSERT  $key - $value  failed!";
				  echo 'Error: ' . $e->getMessage();
				}
			}
		}
	}
	
	//выбираем все записи БД, проходим по строкам, записываем содержимое полей в Box.
	//Все значения ключей сериализованы , для $value ведём десериализацию
	public function load() {
		$this->box = null;
		$link = new PDO($this->dsn, $this->user, $this->password);
		$query = "SELECT * FROM $this->table";
		$result = $link->query($query);
		$result = $result->fetchAll(PDO::FETCH_ASSOC);
		for ($i=0; $i < count($result); $i++) {
			$key = $result[$i][$this->keyColumn];
			$value = unserialize($result[$i][$this->valueColumn]);
			$this->box[$key] = $value;

		}

	}

	public static function getInstanse ($dsn, $user, $password, $table) {
		if (empty(self::$instance)) self::$instance = new self($dsn, $user, $password, $table);
		return self::$instance;
	}
}