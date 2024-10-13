<?php
/*Сохраняет данные в box.txt
Создание экземпляра FileBox::getInstanse();
*/
class FileBox extends AbstractBox{

	private static $instance;
	protected function __construct () 
    {
    }

	protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }	
	/*
	1. Открываем контент файла. Парсим в массив
	2. array_replace() заменяем открытый массив на массив из $box
	3. Сохраняем
	*/
	public function save() {
		if (!file_exists('box.txt')) file_put_contents('box.txt', '');
		$dataFromFile = file_get_contents('box.txt');
		$dataFromFileArr = unserialize($dataFromFile);
		$currentBox = $this->box;
		if ($dataFromFileArr == '') $dataFromFileArr = array();
		$mergeArrayR = array_replace($dataFromFileArr, $currentBox);
		$mergeArrayR = serialize($mergeArrayR);
		file_put_contents('box.txt', $mergeArrayR);
	}
	

	public function load() {
		$data = file_get_contents('box.txt');
		$this->box = unserialize($data);
	}

	public static function getInstanse () {
		if (empty(self::$instance)) self::$instance = new self();
		return self::$instance;
	}
}
