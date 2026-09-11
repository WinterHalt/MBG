<?php
// Barang Model Handle Barang Controller
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_model extends MY_Model {
  // Model Builder
  public function __construct(){
    // Construct Parent
    parent::__construct();
  }

  public function getAllBarang(){
    // Model Builder to Get All Barang Data with Certain Column
    $this->db->select('id, gases, stock, unit');
    $query = $this->db->from('tabel_gases')->where('deleted_at', NULL)->get();
    // Hasil Dalam Bentuk Array
    return $query->result_array();
  }

  public function getBarangById($id){
    // Model Builder to Single Barang
    $this->db->from('tabel_gases')->where('id', $id);
    // Return Single Array
    return $this->db->get()->row_array();

  }

  public function publishBarang($data){
    // Model Builder to Input or Modif Data Barang
    // Variable Data Barang
    $insert_data = array('gases' => $data['gases'], 'unit' => $data['unit']);
    // Validasi Kondisional
    if (isset($data['id']) && !empty($data['id'])) {
      // I - Filter
      $filter = array('id' => $data['id']);
      // I - Perubahan Data - Melakukan Perubahan Data Pada Tabel Gases
      return $this->db->update('tabel_gases', $insert_data, $filter);
    } else {
      // II - Input - Melakukan Input Data Baru Pada Tabel Gases
      return $this->db->insert('tabel_gases', $insert_data);
    }
  }

  public function deleteBarang($id){
    // Model Builder to Soft Delete the Barang
    if (!isset($id) || empty($id)) {
      return false;
    }
    // Variable Array
    $inputs = array('deleted_at' => realtime(), 'deleted_by' => username());
    // Hasil
    return $this->db->update('tabel_gases', $inputs, ['id' => $id]);
  }

  public function BarangOnly(){
    // Model Builder to Show All Available Barang
    $this->db->select("id, gases, stock");
    // Table
    $this->db->from('tabel_gases');
    // Filter
    $this->db->where(array('deleted_at' => NULL));
    // Define Variable Query
    $query = $this->db->get();
    // Define Result
    return $query->result_array();
  }

  public function jumlahBaru($inputs){
    // Model Builder to update stock in batch by id
    return $this->db->update_batch('tabel_gases', $inputs, 'id');
  }

  public function kurangJumlah($inputs){
    foreach ($inputs as $row) {
      $stock = (int) $row['stock'];
      $this->db->set('stock', 'stock - ' . $stock, false)
                ->where('id', $row['id'])
                ->update('tabel_gases');
    }
    return true;
  }

}
?>