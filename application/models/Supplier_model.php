<?php
// Supplier Model to Perform Database Query on Supplier Table
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier_model extends MY_Model {
  public function __construct(){
    // Construct Parent
    parent::__construct();
  }

  public function getAllSupplier(){
    // Tabel Supplier Model
    $column = "id, name, position, company_name, mobileno, email";
    // Query to Get All Supplier Data with Certain Column
    $query = $this->db->select($column)->from('availableSupplier')->get();
    // Hasil Dalam Bentuk Array
    return $query->result_array();
  }

  public function getSupplierById($id){
    // Deliver Certain Data of Supplier on Certain Id
    $this->db->from('availableSupplier')->where('id', $id);
    // Return Single Array
    return $this->db->get()->row_array();
  }

  public function publishSupplier($inputs){    
    // Variable Data Supplier
    // Validasi Kondisional
    if (isset($inputs['id']) && !empty($inputs['id'])) {
      // I - Filter
      $filter = array('id' => $inputs['id']);
      $inputs['updated_at'] = date("Y-m-d H:i:s");
      $inputs['updated_by'] = html_escape($this->session->userdata('name'));
      // Melakukan Perubahan Data Pada Tabel Supplier
      return $this->db->update('kontrak_penyedia', $inputs, $filter);
    } else {
      // II - Input
      $inputs['uuid'] = $uuid = $this->uuid->v4();
      $inputs['is_active'] = 1;
      $inputs['created_at'] = date("Y-m-d H:i:s");
      $inputs['created_by'] = html_escape($this->session->userdata('name'));
      // Melakukan Input Data Baru Pada Tabel Supplier
      return $this->db->insert('kontrak_penyedia', $inputs);
    }
  }

  public function deleteSupplier($id){
    // Soft Delete on Certain Supplier Data
    if (!isset($id) || empty($id)) {
      return false;
    }
    // Soft Delete Variable
    $data = array('is_active' => 0, 'deleted_at' => realtime(), 'deleted_by' => username());
    // Return True or False Result
    return $this->db->update('kontrak_penyedia', $data, ['id' => $id]);
  }

  public function SupplierOnly(){
    // All of Available Supplier to Initiate Kontrak
    $column = "id, company_name as text";
    // Model Query
    $sqlquery = "SELECT $column FROM kontrak_penyedia WHERE is_active = 1";
    // Model Hasil
    $query = $this->db->query($sqlquery);
    // Return Result
    return $query->result_array();
  }
}