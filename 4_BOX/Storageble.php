<?php

interface Storageble {
	/*
	��������� ������ � ��������� ������
	*/
	public function save();
	/*
	��������� ������ �� ��������� ������ 
	*/
	public function load();	
	/*
	������������� ������ � ����������-���������
	*/
	public function setData($key, $value);
	/*
	��������� ������ � �� ����������=-��������
	*/
	public function getData ($key);
}
