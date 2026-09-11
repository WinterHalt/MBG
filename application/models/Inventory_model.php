<?php
// Final Version of Availability Model !
// Availability Model Support Stock Opname
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory_model extends MY_Model {
  // Availability Model Responsible on Inventory Controller
  public function __construct(){
    // Construct Parent
    parent::__construct();
  }

  public function tabelAllInventory(){
    // Select All History of Medical Gases Stock Opname
    $column = "id, tanggal, user";
    $sqlquery = "SELECT $column FROM tabel_logging";
    $query = $this->db->query($sqlquery, []);
    return $query->result_array();
  }

  public function publishPrimary($tanggal, $user){
    // Insert Meta Data of Stock Opname Activity
    $singular = array('tanggal' => $tanggal, 'user' => $user);
    // Single Input Array
    $this->db->insert('tabel_logging', $singular);
    // Return Result
    return $this->db->insert_id();
  }

  public function publishDetail($inputs){
    // Insert banyak baris detail sekaligus
    return $this->db->insert_batch('tabel_logging_detail', $inputs);
  }

  public function detailPrimary($id){
    // Detail on Meta Data Stock Opname Table
    $column = "id, tanggal, user";
    $sqlquery = "SELECT $column FROM tabel_logging WHERE id = ?";
    $query = $this->db->query($sqlquery, [$id]);
    return $query->row_array();
  }

  public function detailInventory($id){
    // Detail on Stock Opname Content Medical Gases
    $column = "tld.gases as gsid, tg.gases, tld.sistem, tld.fisik, tld.selisih";
    $joined = "JOIN tabel_gases tg ON tld.gases = tg.id";
    $sqlquery = "SELECT $column FROM tabel_logging_detail tld $joined WHERE tld.loggingKey = ?";
    $query = $this->db->query($sqlquery, [$id]);
    return $query->result_array();
  }
}
?>