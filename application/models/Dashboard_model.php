<?php
// Main File Model to Handle Main File Controller !
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends MY_Model {
  // Dashboard Model Responsible on Dashboard Controller !
  public function __construct() {
    // Builder
    parent::__construct();
  }

  public function monthlyReportReal($id){
    // Real — Model Untuk Data Pengeluaran Bulanan Dari Database
    $this->db->select('bulan, total');
    $this->db->from('laporan_pengeluaran');
    $this->db->where('gsid', $id);
    $query = $this->db->get();
    $total = $query->num_rows();
    return $total == 0 ? array() : $query->result_array();
  }

  public function monthlyReport($gas){
    // Demo — Data Dummy Untuk Kebutuhan Preview, Nanti Diganti monthlyReport() Saat Integrasi Real
    $dummy = array(
      '1' => array(100, 140, 130, 105, 112, 136, 154, 148, 132, 120, 138, 150),
      '2' => array(90, 130, 120, 95, 102, 126, 144, 138, 122, 110, 128, 140),
      '3' => array(50, 51, 60, 78, 51, 38, 40, 45, 62, 58, 47, 53),
      '4' => array(30, 34, 28, 40, 36, 32, 45, 42, 38, 33, 29, 37),
      '5' => array(22, 25, 20, 28, 24, 21, 30, 27, 26, 23, 19, 25),
      '6' => array(10, 14, 13, 15, 12, 16, 14, 11, 17, 13, 12, 15),
      '7' => array(18, 20, 16, 22, 19, 17, 24, 21, 20, 16, 15, 19),
      '8' => array(35, 38, 32, 44, 40, 36, 48, 45, 41, 37, 33, 39)
    );

    // Kalau Key Gas Tidak Ditemukan, Balikin Array Kosong (Jaga-Jaga Typo)
    return isset($dummy[$gas]) ? $dummy[$gas] : array();
  }
}