<?php

interface Storageble {
	/*
	—охран€ет данные в хранилище данных
	*/
	public function save();
	/*
	«агружает данные из хранилища данных 
	*/
	public function load();	
	/*
	”станавливает данные в переменную-хранилище
	*/
	public function setData($key, $value);
	/*
	«агружает данные в из переменной=-ранилища
	*/
	public function getData ($key);
}
