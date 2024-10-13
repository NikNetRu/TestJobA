<?php
abstract class AbstractBox implements Storageble {
	
	abstract public function save();
	abstract public function load();

	protected $box = array();

	public function setData ($key, $value) {
		$this->box[$key] = $value; 
	}
	public function getData ($key) {
		echo("Saved in $key: ");
		print_r($this->box[$key]);
		echo (PHP_EOL);
		return $this->box[$key];
	}

}