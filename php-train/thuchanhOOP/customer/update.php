<?php
require_once('../models/customer.php');
$id = $_GET['index'];
$idUpdate['id_update'] = true;
$datas = new customer();
$data = $datas->readFileUpdateCustomer($id);

require_once('../view/formCustomer.php');
