<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require('../../../wp-load.php');

$option = $_REQUEST['option'];

switch ($option) {
  case 1 : continentQuery();
    break;
  case 2 : countryQuery();
    break;
  default:
    break;
}

function continentQuery () {
  global $wpdb;
  $continent = $_REQUEST['region'];
  $result = $wpdb->get_results("SELECT * FROM wp_continent WHERE cnt_name LIKE '%$continent%' ORDER BY id_continent ASC ", ARRAY_A);
  if (count($result) != 0) {
    for ($i = 0; $i < count($result); $i++) {
      $answer[] = array("id" => $result[$i]['cnt_name'], "text" => $result[$i]['cnt_name']);
    }
  } else {
    $answer[] = array("id" => "0", "text" => "No Results Found..");
  }
  echo json_encode($answer);
}

function countryQuery() {
  global $wpdb;
  $continent = $_REQUEST['region'];
  $country = $_REQUEST['country'];
  $where = "";
  if ($continent != '') {
    $where .= " AND cnt_name LIKE '%" . $continent . "%'";
  }
  $result = $wpdb->get_results("SELECT * FROM wp_country INNER JOIN wp_continent on (wp_continent_id_continent = id_continent) WHERE cny_name LIKE '%$country%' $where ORDER BY id_country ASC ", ARRAY_A);
  if (count($result) != 0) {
    for ($i = 0; $i < count($result); $i++) {
      $answer[] = array("id" => $result[$i]['cny_name'], "text" => $result[$i]['cny_name']);
    }
  } else {
    $answer[] = array("id" => "0", "text" => "No Results Found..");
  }
  echo json_encode($answer);
}