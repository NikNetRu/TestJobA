<?php

// входные данные для скрипта HTML код, проверяет все ли теги закрыты.
//$arrSingleTeg - список тегов "одиночек" которые могут быть незакрытыми
function tegValidator($arrayTegs) {

	$arrSingleTeg = array ('img','input', 'link');
	$arrSingleTegSpChr = array ('<img>','<input>', '<link>');
	//������ ���� ������� ������� �������� ��� ������ �����
	$arrayCompareLastTegs = array();
	$sizeArrTegs = count($arrayTegs);
	for ($i = 0; $i < $sizeArrTegs; $i++) {
		$currentTeg = array_shift($arrayTegs);
		if (preg_match("#<[/]?[A-Za-z]+>#", $currentTeg) != 1) {
			return false;
		}
		//���� ��� ������������� - ����� ��� � ������ ������� $arrayCompareLastTegs
		//���� ��� ������������� ���������� ��� �������� � ������ ��������� $arrayCompareLastTegs
		if (preg_match("#<[A-Za-z]+>#", $currentTeg) == true) {
			array_unshift($arrayCompareLastTegs, $currentTeg);
		}
		else {
			$lastOpenedTeg = array_shift($arrayCompareLastTegs);
			$currentTeg = str_replace(['<','/','>'], '', $currentTeg);
			$lastOpenedTegWithoutSpecial = str_replace(['<','/','>'], '', $lastOpenedTeg);
			//������������ ��������� ���� ����� ������������� �����, ����� ������ �������������, ����� ����� ��������
			// ����� ��� ����������� ��� � ���� �� ���������
			if ($currentTeg != $lastOpenedTegWithoutSpecial) {
				$is_singleTeg = in_array($lastOpenedTegWithoutSpecial, $arrSingleTeg);
				if (!$is_singleTeg) {
					echo ("Incorrect in area $currentTeg");
					return false;
				} else {
					do {
						$lastOpenedTeg = array_shift($arrayCompareLastTegs);
						$lastOpenedTegWithoutSpecial = str_replace(['<','/','>'], '', $lastOpenedTeg);
						} while (in_array($lastOpenedTegWithoutSpecial, $arrSingleTeg) && $arrayCompareLastTegs != null);
					if ($currentTeg != $lastOpenedTegWithoutSpecial) {
						echo ("Incorrect in area $currentTeg");
						return false;
					}
				}	
			}
		}	
	}
	//�������� ���������� �������� � ������� �� ��������
	if (array_diff($arrayCompareLastTegs, $arrSingleTegSpChr)) {
	echo("Not all tags closed");
	return false;
	} 
	echo('correct');
	return true;
}

$array = array ('<head>','<input>');

tegValidator($array);
