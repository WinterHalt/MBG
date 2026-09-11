<?php
// Keluar Model to Perform Database Query on Pengeluaran
defined('BASEPATH') or exit('No direct script access allowed');

class Keluar_model extends MY_Model {
  // Define Public Construct
  public function __construct(){
    // Construct Parent
    parent::__construct();
  }

  public function tabelKeluar($start, $final){
    $column = 'tp.id, tp.tanggal, s.name AS user';
    $filter = array('tp.tanggal >=' => $start, 'tp.tanggal <=' => $final);
    $this->db->select($column);
    $this->db->from('tabel_pengeluaran tp');
    $this->db->join('staff s', 's.staff_id = tp.user');
    $this->db->where($filter);
    return $this->db->get()->result();
  }

  public function publishKeluar($time, $user){
    $data = array('tanggal' => $time, 'user' => $user);
    $insert = $this->db->insert('tabel_pengeluaran', $data);
    return ($insert) ? $this->db->insert_id() : false;
  }

  public function publishDetail($gases, $pagi, $sore, $malam, $total, $idKey){
    $detailVariable = [];
    foreach ($gases as $i => $gasesKey) {
      $row = [];
      $row['pengeluaranKey'] = $idKey;
      $row['gases'] = $gasesKey;
      $row['pagi'] = $pagi[$i];
      $row['sore'] = $sore[$i];
      $row['malam'] = $malam[$i];
      $row['total'] = $total[$i];
      $detailVariable[] = $row;
    }
    // trialTest($detailVariable);
    return $this->db->insert_batch('tabel_pengeluaran_detail', $detailVariable);
  }

  public function detailPrimary($id){
    $column = 'tp.id, tp.tanggal, s.name AS user';
    $this->db->select($column);
    $this->db->from('tabel_pengeluaran tp');
    $this->db->join('staff s', 's.staff_id = tp.user');
    $this->db->where('tp.id', $id);
    return $this->db->get()->row_array();
  }

  public function detailKeluar($id){
    $column = 'tg.gases, tpd.pagi, tpd.sore, tpd.malam, tpd.total';
    $this->db->select($column);
    $this->db->from('tabel_pengeluaran_detail tpd');
    $this->db->join('tabel_gases tg', 'tg.id = tpd.gases');
    $this->db->where('tpd.pengeluaranKey', $id);
    return $this->db->get()->result_array();
  }
}