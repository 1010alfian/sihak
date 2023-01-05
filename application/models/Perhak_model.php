<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perhak_model extends CI_Model {

    var $table = 'pemohon';

    // DATATABLES PEMOHON
    function get_pemohon()
    {
        $this->_get_data_pemohon();
        if($this->input->post("length")!=-1) 
        $this->db->limit($this->input->post("length"),$this->input->post("start"));
        return $this->db->get()->result();
    }

    function _get_data_pemohon()
    {
        if(isset($_POST['search']['value'])){
            $searchkey=$_POST['search']['value']; 
            $query=array(
                "pengajuan"=>$searchkey,		 
                "nama_pemohon"=>$searchkey,	 
                "no_berkas"=>$searchkey,	 
            );
            $this->db->group_start()->or_like($query)->group_end();
        }	
        
        $this->db->order_by("id_pemohon","asc");
        $query=$this->db->from($this->table);
        return $query;
    }

    public function count_pemohon()
    {				
        $this->_get_data_pemohon();
        return $this->db->get()->num_rows();
    }
    // DATATABLES PEMOHON

    public function getPemohonById($id){
        $pemohon = $this->db->get_where('pemohon', ['id_pemohon' => $id])->row();
        return $pemohon;
    }

    public function simpanPengajuan($data){
        $query = $this->db->insert('pemohon', $data);
        return $query;
    }

    public function updatePengajuan($data){
        $this->db->where('id_pemohon', $data['id_pemohon']);
        $query = $this->db->update('pemohon', $data);
        return $query;
    }

    public function getUnduh($id_pemohon){
        $query = $this->db->get_where('pemohon', ['id_pemohon' => $id_pemohon])->row();
        return $query;
    }

    public function updateStatus($id_pemohon){
        $this->db->where('id_pemohon',$id_pemohon);
        $query = $this->db->update('pemohon', ['status' => 1]);
        return $query;
    }

    // DATATABLES PEGAJUAN
    function get_pengajuan()
    {
        $this->_get_data_pengajuan();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
    }

    function _get_data_pengajuan()
	{
        $this->db->where('id_user', $this->session->id_user);
		if(isset($_POST['search']['value'])){
			$searchkey=$_POST['search']['value']; 
            $query=array(
            "pengajuan"=>$searchkey 				 
            );
            $this->db->group_start()->or_like($query)->group_end();
        }	
		
        $this->db->order_by("id_pemohon","asc");
        $query=$this->db->from($this->table);
		return $query;
    }
 
    public function count_pengajuan()
	{				
        $this->_get_data_pengajuan();
		return $this->db->get()->num_rows();
	}
    // DATATABLES PEGAJUAN

    public function hapusById($id_pemohon){
        $this->db->where('id_pemohon', $id_pemohon);
        $delete = $this->db->delete('pemohon');
        return $delete;
    }

    public function kirim_janji($data){
        $query = $this->db->insert('janji_temu', $data);
        return $query;
    }

    // DATATABLES JANJI TEMU
    function get_janji_temu()
    {
        $this->_get_data_janji_temu();
		if($this->input->post("length")!=-1) 
		$this->db->limit($this->input->post("length"),$this->input->post("start"));
	 	return $this->db->get()->result();
    }

    function _get_data_janji_temu()
	{
        $this->db->where('id_user', $this->session->id_user);
		if(isset($_POST['search']['value'])){
			$searchkey=$_POST['search']['value']; 
            $query=array(
            "tgl"=>$searchkey 				 
            );
            $this->db->group_start()->or_like($query)->group_end();
        }	
		
        $this->db->order_by("id_janji","desc");
        $query=$this->db->from('janji_temu');
		return $query;
    }
 
    public function count_janji_temu()
	{				
        $this->_get_data_janji_temu();
		return $this->db->get()->num_rows();
	}
    // DATATABLES JANJI TEMU

    public function permintaan_temu(){
        $this->db->where('status', 0);
        $query = $this->db->get('janji_temu')->result();
        return $query;
    }

    public function janji_temu(){
        $this->db->where('status', 1);
        $query = $this->db->get('janji_temu')->result();
        return $query;
    }

    public function setuju_janji($id_janji){
        $this->db->where('id_janji', $id_janji);
        $query = $this->db->update('janji_temu', ['status' => 1]);
        return $query;
    }

    public function tolak_janji($data){
        $this->db->where('id_janji', $data['id_janji']);
        $query = $this->db->update('janji_temu', ['status' => 3]);
        $this->db->insert('tolak_janji_temu', $data);
        return $query;
    }

    public function batalkan_janji_temu($id_janji){
        $this->db->where('id_janji', $id_janji);
        $query = $this->db->delete('janji_temu');
        return $query;
    }

    public function tolakTemu(){
        $id_pemohon = $this->input->post('id_pemohon');
        $keterangan = $this->input->post('keterangan');

        $data = [
            'id_pemohon' => $id_pemohon,
            'id_user' => $this->session->id_user,
            'keterangan' => $keterangan,
            'tolak_at' => date("Y-m-d H:i:s")
        ];

        // update status ke tabel pemohon
        $this->db->where('id_pemohon', $id_pemohon);
        $this->db->update('pemohon', ['status' => 2]);

        $query = $this->db->insert('tolak', $data);
        return $query;
    }

    public function get_keterangan($id_pemohon){
        $this->db->where('id_pemohon', $id_pemohon);
        $query = $this->db->get('tolak')->row();
        return $query;
    }

    public function save_no_hak($id_pemohon, $no_hak){
        $getPemohon = $this->getPemohonById($id_pemohon);
        $data = [
            'id_pemohon' => $id_pemohon,
            'id_user' => $getPemohon->id_user,
            'no_hak' => $no_hak,
            'created_at' => date("Y-m-d H:i:s"),
            'dilakukan_oleh_id' => $this->session->id_user,
            'dilakukan_oleh_nama' => $this->session->name,
        ];

        $query = $this->db->insert('no_hak', $data);
        return $query;
    }

    public function simpan_bayar($data){
        $query = $this->db->insert('bukti_bayar', $data);
        return $query;
    }

    // DATATABLES KELOLA PEMBAYARAN
    function get_kelola_pembayaran()
    {
        $this->_get_data_pembayaran();
        if($this->input->post("length")!=-1) 
        $this->db->limit($this->input->post("length"),$this->input->post("start"));
        return $this->db->get()->result();
    }

    function _get_data_pembayaran()
    {
        if(isset($_POST['search']['value'])){
            $searchkey=$_POST['search']['value']; 
            $query=array(
                "pengajuan"=>$searchkey,		 
                "nama_pemohon"=>$searchkey,
                "no_berkas"=>$searchkey
            );
            $this->db->group_start()->or_like($query)->group_end();
        }	
        
        $this->db->order_by("id_pemohon","asc");
        $query=$this->db->from($this->table);
        return $query;
    }

    public function count_pembayaran()
    {				
        $this->_get_data_pembayaran();
        return $this->db->get()->num_rows();
    }


    public function tes(){
        // $this->db->select('bb.id_pemohon as bbId', 'pem.id_pemohon as pemId', 'pem.pengajuan as pemNgajuan');
        $this->db->select('bb.status', 'nama_pemohon');
        $this->db->from('pemohon as pe')
        ->join('bukti_bayar as bb', 'bb.id_pemohon = pe.id_pemohon');

        $this->db->order_by("id_pemohon","asc");
        $query=$this->db->from($this->table);
        // ->join('pemohon as pem', 'pem.id_pemohon = bb.id_pemohon')->get();
        return $query;
    }
    // DATATABLES PEMOHON

}