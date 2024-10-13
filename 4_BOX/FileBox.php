<?php
/*��������� ������ � box.txt
�������� ���������� FileBox::getInstanse();
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
	1. ��������� ������� �����. ������ � ������
	2. array_replace() �������� �������� ������ �� ������ �� $box
	3. ���������
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
