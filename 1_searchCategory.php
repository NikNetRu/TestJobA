<?php

function searchCategory($arrayCategory, $id) {
    foreach ($arrayCategory as $iterable) {
        if ($iterable[$id] == $id) {echo ('Found-'.$iterable['title']); return $iterable['title'];}
        if (array_key_exists('children', $iterable)) searchCategory($iterable['children'], $id);
     }
}

$gadgets = array(
    "phones" => array("apple" => "iPhone 12", 
                "samsumg" => "Samsung S20",
                "nokia" => "Nokia 8.3"),
    "tablets" => array("lenovo" => "Lenovo Yoga Smart Tab", 
                    "samsung" => "Samsung Galaxy Tab S5",
                    "apple" => "Apple iPad Pro"));

searchCategory($gadgets, 'apples');