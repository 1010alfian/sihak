<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function _template($data){
        $this->load->view('template/index', $data);
    }

    function index(){
        $ajax = $this->input->get_post("ajax");
        if ($ajax=="yes") {
            $data['konten'] = $this->load->view("dashboard/index",TRUE);
            echo json_encode($data);
        }else{
            $data['title'] = 'Dashboard - Sihak';
            $data['konten']='dashboard/index';
            $this->_template($data);
        }
    }
}