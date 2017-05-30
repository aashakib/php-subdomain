<?php
include '../PHPSubDomain.php';

$domain = new PHPSubDomain('CPANEL_USERNAME', 'CPANEL_PASSWORD', 'YOUR_DOMAIN', 'SUB_DOMAIN_NAME', 'SKIN', 'LOCATION_PATH', 'PORT');

$domain->delete();
