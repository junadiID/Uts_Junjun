<?php
// Hargailah orang lain jika Anda ingin dihargai

date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

$cfg_mt = 0; // Maintenance? 1 = ya 0 = tidak
if($cfg_mt == 1) {
    die("Site under Maintenance.");
}

// web
$cfg_webname = "Market Junadi - Social Media Reseller Panel";
$cfg_logo_txt = "Market Junadi";
$cfg_baseurl = "https://marketjunadi.my.id/Market/";
$cfg_desc = "SMM Panel Merupakan sebuah website penyedia layanan sosial media termurah, cepat & berkualitas.";
$cfg_author = "Market Junadi";
$cfg_about = "SMM Panel Merupakan sebuah website penyedia layanan sosial media termurah, cepat & berkualitas.";

// fitur staff
$cfg_min_transfer = 5000; // jumlah minimal transfer saldo
$cfg_member_price = 15000; // harga pendaftaran member
$cfg_member_bonus = 5000; // bonus saldo member
$cfg_agen_price = 30000; // harga pendaftaran agen
$cfg_agen_bonus = 15000; // bonus saldo agen
$cfg_reseller_price = 50000; // harga pendaftaran reseller
$cfg_reseller_bonus = 30000; // bonus saldo reseller
$cfg_admin_price = 80000; // harga pendaftaran admin
$cfg_admin_bonus = 50000; // bonus saldo admin

// database
$db_server = "localhost"; 
$db_user = "marketju_smm"; // masukan nama db user kalian
$db_password = "Paneladmin"; // masukan password db kalian
$db_name = "marketju_smm"; // masukan nama db kalian
$cfg_apikey = "a"; // masukan api key operan pulsa kalian

// date & time
$date = date("Y-m-d");
$time = date("H:i:s");

// require
require("lib/database.php");
require("lib/function.php");