<?php

class Dashboard extends Admin_Controller {
  // Define Role & Builder & Model
  protected $role;
  public function __construct(){
    parent::__construct();
    $this->role = 'dashboard';
    $this->load->model('dashboard_model');
  }

  public function index(){
    // Pengeluaran Liquid Oxygen I
    $this->data['liquidtu'] = elaborator($this->dashboard_model->monthlyReport('1'));
    // Pengeluaran Liquid Oxygen II
    $this->data['liquidwa'] = elaborator($this->dashboard_model->monthlyReport('2'));
    // Data Pengeluaran Oxygen
    $this->data['oxygen'] = elaborator($this->dashboard_model->monthlyReport('3'));
    // Data Pengeluaran Nitroxide
    $this->data['nitroxide'] = elaborator($this->dashboard_model->monthlyReport('4'));
    // Data Pengeluaran Cardioxide
    $this->data['cardioxide'] = elaborator($this->dashboard_model->monthlyReport('5'));
    // Data Pengeluaran Argon
    $this->data['argon'] = elaborator($this->dashboard_model->monthlyReport('6'));
    // Data Pengeluaran Nitrocair
    $this->data['nitrocair'] = elaborator($this->dashboard_model->monthlyReport('7'));
    // Data Pengeluaran Carbomix
    $this->data['carbomix'] = elaborator($this->dashboard_model->monthlyReport('8'));
    // File
    $this->data['title'] = 'Panel Dashboard';
    $this->data['sub_page'] = 'dashboard/index';
    $this->data['main_menu'] = 'dashboard';
    $this->load->view('layout/index', $this->data);
  }
}

?>