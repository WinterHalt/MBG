<?php
// Controller u Data Master Supplier

class Supplier extends Admin_Controller {
  // Define Role & Builder & Model
  protected $role;
  public function __construct(){
    parent::__construct();
    $this->role = 'supplier';
    $this->load->model('supplier_model', 'splmdl');
  }

  public function index(){
    // Controller u Tabel Data Supplier
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // File Model
    $this->data['results'] = $this->splmdl->getAllSupplier();
    // File
    $this->data['title'] = 'Tabel Data Supplier';
    $this->data['sub_page'] = 'supplier/index';
    $this->data['main_menu'] = 'supplier';
    $this->load->view('layout/index', $this->data);
  }

  public function insert(){
    // Controller u Tabel Data Supplier
    if (!get_permission($this->role, 'is_add')){
      access_denied();
    }
    // File
    $this->data['title'] = 'Panel Input Supplier';
    $this->data['sub_page'] = 'supplier/insert';
    $this->data['main_menu'] = 'supplier';
    $this->load->view('layout/index', $this->data);
  }

  public function publish(){
    // Controller to Publish Supplier Data
    if (!get_permission($this->role, 'is_add') && !get_permission($this->role, 'is_edit')) {
      access_denied();
    }
    // Variable Input
    $inputs = $this->input->post();
    // Model Publish
    $result = $this->splmdl->publishSupplier($inputs);
    // Hasil
    if ($result) {
      // Hasil 1
      set_alert('success', 'Data Supplier Berhasil Disimpan !');
    } else {
      // Hasil 0
      set_alert('error', 'Data Supplier Gagal Disimpan !');
    }
    // Kembali ke Halaman Supplier
    redirect(base_url('supplier'));
  }

  public function detail($id){
    // Controller Detail Supplier Data
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // File Model
    $this->data['result'] = $this->splmdl->getSupplierById($id);
    // File
    $this->data['title'] = 'Panel Detail Supplier';
    $this->data['sub_page'] = 'supplier/detail';
    $this->data['main_menu'] = 'supplier';
    $this->load->view('layout/index', $this->data);
  }

  public function delete($id){
    // Controller to Perform Soft Delete on Supplier Table
    if (!get_permission($this->role, 'is_delete')){
      access_denied();
    }
    // Delete the Data on Model
    $this->splmdl->deleteSupplier($id);
  }

  public function supplierOnly(){
    // Controller u Data Master Supplier Dalam Perjanjian Kerja Sama
    if (!get_permission($this->role, 'is_view')){
      access_denied();
    }
    // Variable
    $result = $this->splmdl->supplierOnly();
    // Hasil Model
    echo json_encode($result);
  }
}
?>