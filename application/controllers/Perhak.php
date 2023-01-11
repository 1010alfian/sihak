<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perhak extends CI_Controller {
    


    public function __construct(){
        parent::__construct();
        $this->load->helper('download');
        $this->load->model('perhak_model');
    }

    function _template($data){
        $this->load->view('template/index', $data);
    }

    function index(){
        $ajax = $this->input->get_post("ajax");
        if ($ajax=="yes") {
            $data['konten'] = $this->load->view("perhak/index",TRUE);
            echo json_encode($data);
        }else{
            $data['title'] = 'Permohonan Perubahan';
            $data['konten']='perhak/index';
            $this->_template($data);
        }
    }

    public function data_pemohon(){
        $list = $this->perhak_model->get_pemohon();
        $data = [];
        $no = $_POST['start'];

        $approve = '<i class="fas fa-check text-success"></i> Approve <br><i class="fas fa-dollar-sign text-warning"></i> Menunggu Pembayaran';
        $belumApprove = '<i class="fas fa-hourglass-start text-danger"></i> Waiting Approve';
        $tolak = '<i class="fas fa-ban text-danger"></i> Ditolak';
        $sudahBayar = '<i class="fas fa-check text-success"></i> Pemohon sudah membayar';

        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->nama_pemohon;
            $row[] = $field->pengajuan;
            $row[] = $field->no_berkas;
            // $row[] = '<a href="'.base_url('perhak/unduh/').$field->id_pemohon.'" class=" btn btn-sm btn-info"><i class="fas fa-arrow-down"></i> Unduh</a>';

            $getNoHak = $this->db->get_where('no_hak', ['id_pemohon' => $field->id_pemohon])->row();
            $no_hak = isset($getNoHak->no_hak)?($getNoHak->no_hak):0;

            $statusBayar = $this->db->get_where('bukti_bayar', ['id_pemohon' => $field->id_pemohon])->row();
            $sb = isset($statusBayar->status)?($statusBayar->status):0;

            $button1 = '
                <button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="lihat('.$field->id_pemohon.')"><i class="fas fa-search"></i> Preview</button> 
                <button class="btn btn-sm btn-success btn-approve" href="javascript:void(0)" onclick="approve('.$field->id_pemohon.')"><i class="fas fa-check"></i> Approve</button> 
                <button class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="tolak('.$field->id_pemohon.')"><i class="fas fa-ban"></i> Tolak</button>'
            ;
            $button2 = '
                <button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="lihat('.$field->id_pemohon.')"><i class="fas fa-search"></i> Preview</button>        
            ';
            
            $button3 = '
                <button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="lihat('.$field->id_pemohon.')"><i class="fas fa-search"></i> Preview</button> 
                <button class="btn btn-sm btn-success btn-approve" href="javascript:void(0)" onclick="to_approve('.$field->id_pemohon.')"><i class="fas fa-check"></i> Book No</button>';
            ;

            $cek_pembayaran = '<button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="cek_pembayaran('.$field->id_pemohon.')"><i class="fas fa-search"></i> Cek Pembayaran</button> ';

            $belumApproveNoHak = '<i class="fas fa-hourglass-start text-danger"></i> Waiting Approve<br> <i class="fas fa-check text-success"></i> No HAK : '.$no_hak;

            $status_bayar_disetujui_tunggu_no_booking = '<i class="fas fa-dollar-sign text-success"></i> Pembayaran telah di setujui<br><i class="fas fa-hourglass-start text-danger"></i> Tunggu no booking oleh kasubsi';

            // $tunggu_no_booking = '<i class="fas fa-hourglass-start text-danger"></i> Tunggu no booking oleh kasubsi';
            
            $button = '';
            $status = '';
            if($field->status == 1){
                if($sb == 1){
                    $button = $cek_pembayaran;
                    $status = $sudahBayar;
                }elseif($sb == 2){
                    if (!$no_hak) {
                        $button = $button2;
                        $status = $status_bayar_disetujui_tunggu_no_booking;
                    }else{
                        $button = $button2;
                        $status = 'No Hak : '.$no_hak;
                    }
                }else{
                    $button = $button2;
                    $status = $approve;
                }
            }elseif($field->status == 2){
                $status = $tolak;
                $button = $button2;
            }else{
                
                if($no_hak > 0){
                    $button = $button3;
                    $status = $belumApproveNoHak;
                }else{
                    $status = $belumApprove;
                    $button = $button1;
                }
            }
            $row[] = $button;
            $row[] = $status;

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $c = $this->perhak_model->count_pemohon(),
            "recordsFiltered" => $c,
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function data_pemohon_kasubsi(){
        $list = $this->perhak_model->get_pemohon();
        $data = [];
        $no = $_POST['start'];

        $approve = '<i class="fas fa-check text-success"></i> Approve <br><i class="fas fa-dollar-sign text-warning"></i> Menunggu Pembayaran';
        $belumApprove = '<i class="fas fa-hourglass-start text-danger"></i> Waiting Approve';
        $tolak = '<i class="fas fa-ban text-danger"></i> Ditolak';

        $tungguSetujuBayar = '<i class="fas fa-check text-success"></i> Approve <br><i class="fas fa-hourglass-start text-danger"></i> Menunggu pembayaran & konfirmasi oleh admin';

        $book_no_hak = '<i class="fas fa-check text-success"></i> Pembayaran telah di setujui admin <br> ';

        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->nama_pemohon;
            $row[] = $field->pengajuan;
            $row[] = $field->no_berkas;
            // $row[] = '<a href="'.base_url('perhak/unduh/').$field->id_pemohon.'" class=" btn btn-sm btn-info"><i class="fas fa-arrow-down"></i> Unduh</a>';

            $getNoHak = $this->db->get_where('no_hak', ['id_pemohon' => $field->id_pemohon])->row();
            $no_hak = isset($getNoHak->no_hak)?($getNoHak->no_hak):0;

            $statusBayar = $this->db->get_where('bukti_bayar', ['id_pemohon' => $field->id_pemohon])->row();
            $sb = isset($statusBayar->status)?($statusBayar->status):0;

            $button1 = '
                <button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="lihat('.$field->id_pemohon.')"><i class="fas fa-search"></i> Preview</button> 
                <button class="btn btn-sm btn-success btn-approve" href="javascript:void(0)" onclick="approve('.$field->id_pemohon.')"><i class="fas fa-check"></i> Approve</button> 
                <button class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="tolak('.$field->id_pemohon.')"><i class="fas fa-ban"></i> Tolak</button>'
            ;
            $button2 = '
                <button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="lihat('.$field->id_pemohon.')"><i class="fas fa-search"></i> Preview</button>        
            ';
            
            $button3 = '
                <button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="lihat('.$field->id_pemohon.')"><i class="fas fa-search"></i> Preview</button> 
                <button class="btn btn-sm btn-success btn-approve" href="javascript:void(0)" onclick="to_approve('.$field->id_pemohon.')"><i class="fas fa-check"></i> Book No</button>';
            ;

            $cek_pembayaran = '<button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="cek_pembayaran('.$field->id_pemohon.')"><i class="fas fa-search"></i> Cek Pembayaran</button> ';
            
            $belumApproveNoHak = '<i class="fas fa-hourglass-start text-danger"></i> Waiting Approve<br> <i class="fas fa-check text-success"></i> No HAK : '.$no_hak;
            
            $button = '';
            $status = '';
            if($field->status == 1){
                if($sb == 1){
                    $status = $tungguSetujuBayar;
                }elseif($sb == 2){
                    if (!$no_hak) {
                        $button = $button3;
                        $status = $book_no_hak;
                    }else{
                        $button = $button2;
                        $status = 'No Hak : '.$no_hak;
                    }
                }else{
                    $status = $belumApprove;
                }
            }elseif($field->status == 2){
                $status = $tolak;
                $button = $button2;
            }else{
                
                if($no_hak > 0){
                    $button = $button3;
                    $status = $belumApproveNoHak;
                }else{
                    $status = $belumApprove;
                    $button = $button1;
                }
            }
            $row[] = $button;
            $row[] = $status;

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $c = $this->perhak_model->count_pemohon(),
            "recordsFiltered" => $c,
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function lihat($id){
        $pemohon = $this->perhak_model->getPemohonById($id);
        echo json_encode($pemohon);
    }

    public function tolak_temu(){
        $tolakTemu = $this->perhak_model->tolakTemu();
        echo json_encode($tolakTemu);
    }

    public function approve(){
        $id_pemohon = $this->input->post('id_pemohon');
        $approve = $this->perhak_model->updateStatus($id_pemohon);
        echo json_encode($approve);
    }





    // USER
    public function ajukan_perubahan(){
        $ajax = $this->input->get_post("ajax");
        if ($ajax=="yes") {
            $data['konten'] = $this->load->view("perhak/ajukan_permohonan",TRUE);
            echo json_encode($data);
        }else{
            $data['title'] = 'Ajukan Permohonan';
            $data['konten']='perhak/ajukan_permohonan';
            $this->_template($data);
        }  
    }

    public function simpan_pengajuan(){
        $config = array();
        $config['upload_path'] = './upload/ktp/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx|jpg|jpeg|png';
        $this->load->library('upload', $config, 'ktpupload');
        $this->ktpupload->initialize($config);
        $upload_ktp = $this->ktpupload->do_upload('ktp');
        
        $config = array();
        $config['upload_path'] = './upload/imb/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx';
        $this->load->library('upload', $config, 'imbupload');
        $this->imbupload->initialize($config);
        $upload_imb = $this->imbupload->do_upload('dok_imb');

        $config = array();
        $config['upload_path'] = './upload/sppt/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx';
        $this->load->library('upload', $config, 'spptupload');
        $this->spptupload->initialize($config);
        $upload_sppt = $this->spptupload->do_upload('dok_sppt');

        $config = array();
        $config['upload_path'] = './upload/sertifikat/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx';
        $this->load->library('upload', $config, 'sertifikatupload');
        $this->sertifikatupload->initialize($config);
        $upload_sertifikat = $this->sertifikatupload->do_upload('dok_sertifikat');

        // Check uploads success
        if ($upload_ktp && $upload_imb && $upload_sppt && $upload_sertifikat) {
            $ktp_data = $this->ktpupload->data('file_name');
            $imb_data = $this->imbupload->data('file_name');
            $sppt_data = $this->spptupload->data('file_name');
            $sertifikat_data = $this->sertifikatupload->data('file_name');
        } else {
    
            // Error Occured in one of the uploads
    
            echo 'KTP upload Error : ' . $this->ktpupload->display_errors() . '<br/>';
            echo 'IMB upload Error : ' . $this->imbupload->display_errors() . '<br/>';
            echo 'SPPT upload Error : ' . $this->spptupload->display_errors() . '<br/>';
            echo 'Sertifikat upload Error : ' . $this->sertifikatupload->display_errors() . '<br/>';
        }

        // if(!$this->upload->do_upload('dokumen')){
        //     $data['error'] = $this->upload->display_errors();
        // }else{
        //     $dokumen = $this->upload->data('file_name');
        // }

		$data = [
            'pengajuan' => $this->input->post('pengajuan', true), 
        	'nama_pemohon'  => $this->session->name,
        	'no_berkas' => $this->input->post('no_berkas', true),
        	'luas_tanah' => $this->input->post('luas_tanah', true),
        	'alamat_tanah' => $this->input->post('alamat', true),
        	'nik' => $this->input->post('nik', true),
        	'ktp' => $ktp_data,
        	'no_imb' => $this->input->post('no_imb', true),
        	'dok_imb' => $imb_data,
            'no_sppt' => $this->input->post('no_sppt', true),
        	'dok_sppt' => $sppt_data,
            'no_sertifikat' => $this->input->post('no_sertifikat', true),
        	'dok_sertifikat' => $sertifikat_data,
            'status' => 0,
            'id_user' => $this->session->id_user,
        	'created_at' => date("Y-m-d H:i:s"),
    	];

        $save = $this->perhak_model->simpanPengajuan($data);
        echo json_encode($save);
    }

    //edit bayar
    public function pembayaranupdate(){
        $bukti_bayar = $this->input->post('bukti_bayar');
        $config = array();
        $config['upload_path'] = './upload/bukti_bayar/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $this->load->library('upload', $config, 'bukti');
        $this->bukti->initialize($config);
        $upload_bukti = $this->bukti->do_upload('buktibayar_baru');

        // Check uploads success
        if ($upload_bukti) {
            if($bukti_bayar){
                $path = './upload/bukti_bayar/'.$this->input->post('bukti_bayar');
                unlink($path);
            }
            $buktibayar = $this->bukti->data('file_name');
        } else {

        }

        $data = [
            'id_pemohon' => $this->input->post('id_pemohon'),
             'id_bukti' => $this->input->post('id_bayar'),
            'no_berkas' => $this->input->post('no_berkas'),
            'nama_bank' => $this->input->post('nama_bank'),
            'nama_pemilik_tabungan' => $this->input->post('nama_pemilik_tabungan'),
            'nominal' => $this->input->post('nominal'),
           'bukti_bayar' => isset($buktibayar)?($buktibayar):$bukti_bayar,
            'status' => 1
        ];

        $query = $this->perhak_model->pembayaranupdate($data);
        echo json_encode($query);
        
    }

    public function update_pengajuan(){

        $ktp_lama = $this->input->post('ktp_lama');
        $config = array();
        $config['upload_path'] = './upload/ktp/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx';
        $this->load->library('upload', $config, 'ktpupload');
        $this->ktpupload->initialize($config);
        $upload_ktp = $this->ktpupload->do_upload('ktp');
        
        $imb_lama = $this->input->post('imb_lama');
        $config = array();
        $config['upload_path'] = './upload/imb/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx';
        $this->load->library('upload', $config, 'imbupload');
        $this->imbupload->initialize($config);
        $upload_imb = $this->imbupload->do_upload('dok_imb');

        $sppt_lama = $this->input->post('sppt_lama');
        $config = array();
        $config['upload_path'] = './upload/sppt/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx';
        $this->load->library('upload', $config, 'spptupload');
        $this->spptupload->initialize($config);
        $upload_sppt = $this->spptupload->do_upload('dok_sppt');

        $sertifikat_lama = $this->input->post('sertifikat_lama');
        $config = array();
        $config['upload_path'] = './upload/sertifikat/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx';
        $this->load->library('upload', $config, 'sertifikatupload');
        $this->sertifikatupload->initialize($config);
        $upload_sertifikat = $this->sertifikatupload->do_upload('dok_sertifikat');

        // Check uploads success
        if ($upload_ktp && $upload_imb && $upload_sppt && $upload_sertifikat) {
            if($ktp_lama){
                $path = './upload/ktp/'.$this->input->post('ktp_lama');
                unlink($path);
            }
            if($imb_lama){
                $path = './upload/imb/'.$this->input->post('imb_lama');
                unlink($path);
            }
            if($sppt_lama){
                $path = './upload/sppt/'.$this->input->post('sppt_lama');
                unlink($path);
            }
            if($sertifikat_lama){
                $path = './upload/sertifikat/'.$this->input->post('sertifikat_lama');
                unlink($path);
            }
            $ktp_data = $this->ktpupload->data('file_name');
            $imb_data = $this->imbupload->data('file_name');
            $sppt_data = $this->spptupload->data('file_name');
            $sertifikat_data = $this->sertifikatupload->data('file_name');
        } else {

        }

		$data = [
            'id_pemohon' => $this->input->post('id_pemohon', true),  
            'pengajuan' => $this->input->post('pengajuan', true), 
        	'nama_pemohon'  => $this->session->name,
        	'no_berkas' => $this->input->post('no_berkas', true),
        	'luas_tanah' => $this->input->post('luas_tanah', true),
        	'alamat_tanah' => $this->input->post('alamat', true),
        	'nik' => $this->input->post('nik', true),
        	'ktp' => isset($ktp_data)?($ktp_data):$ktp_lama,
        	'no_imb' => $this->input->post('no_imb', true),
        	'dok_imb' => isset($imb_data)?($imb_data):$imb_lama,
            'no_sppt' => $this->input->post('no_sppt', true),
        	'dok_sppt' => isset($sppt_data)?($sppt_data):$sppt_lama,
            'no_sertifikat' => $this->input->post('no_sertifikat', true),
        	'dok_sertifikat' => isset($sertifikat_data)?($sertifikat_data):$sertifikat_lama,
            'status' => 0,
            'id_user' => $this->session->id_user,
        	'created_at' => date("Y-m-d H:i:s"),
    	];

        $update = $this->perhak_model->updatePengajuan($data);
        echo json_encode($update);
    }

    public function get_no_berkas(){
        $getNoLama = $this->db->order_by('id_pemohon',"desc")->limit(1)->get('pemohon')->row();
        $noBerkas = isset($getNoLama->no_berkas)?($getNoLama->no_berkas + 1):"1";
        echo json_encode($noBerkas);
    }

    public function unduh_ktp($id_pemohon){
        $getDokumen = $this->perhak_model->getUnduh($id_pemohon);
        $ktp = $getDokumen->ktp;

        force_download('./upload/ktp/'.$ktp,null);
    }

    public function unduh_sppt($id_pemohon){
        $getDokumen = $this->perhak_model->getUnduh($id_pemohon);
        $sppt = $getDokumen->dok_sppt;

        force_download('./upload/sppt/'.$sppt,null);
    }

    public function unduh_imb($id_pemohon){
        $getDokumen = $this->perhak_model->getUnduh($id_pemohon);
        $imb = $getDokumen->dok_imb;

        force_download('./upload/imb/'.$imb,null);
    }

    public function unduh_sertifikat($id_pemohon){
        $getDokumen = $this->perhak_model->getUnduh($id_pemohon);
        $sertifikat = $getDokumen->dok_sertifikat;

        force_download('./upload/sertifikat/'.$sertifikat,null);
    }

    public function get_pengajuan(){
        $list = $this->perhak_model->get_pengajuan();
        $data = [];
        $no = $_POST['start'];

        $approve = '<i class="fas fa-check text-success"></i> Approve <br> <i class="fas fa-exclamation-triangle text-warning"></i><span> Segera lakukan pembayaran</span>';
        $approveBayar = '<i class="fas fa-check text-success"></i> Approve <br> <i class="fas fa-hourglass-start text-danger"></i><span> Pembayaran menunggu konfirmasi</span>';
        $pending = '<i class="fas fa-check text-success"></i> Approve <br> <i class="fas fa-hourglass-start text-danger"></i><span> Pembayaran di pending</span>';
        $ketpending = '<button class="btn btn-sm" onclick="ketpendingg()"><i class="fas fa-comment-dots text-success"></i> </button>';
        $approveBayarKonfirmasi = '<i class="fas fa-check text-success"></i> Approve <br> <i class="fas fa-check text-success"></i><span> Pembayaran di setujui</span> <br> <i class="fas fa-hourglass-start text-danger"></i><span> Tunggu no booking</span>';
        $belumApprove = '<i class="fas fa-hourglass-start text-danger"></i> Waiting';
        $tolak = '<i class="fas fa-ban text-danger"></i> Ditolak';

        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->pengajuan;

            $getNoHak = $this->db->get_where('no_hak', ['id_pemohon' => $field->id_pemohon])->row();
            $no_hak = isset($getNoHak->no_hak)?($getNoHak->no_hak):0;

            $statusBayar = $this->db->get_where('bukti_bayar', ['id_pemohon' => $field->id_pemohon])->row();
            $sb = isset($statusBayar->status)?($statusBayar->status):0;

            $button1 = '<button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="edit('.$field->id_pemohon.')"><i class="fas fa-edit"></i> Edit</button> | <button class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="hapus_pengajuan('.$field->id_pemohon.')"><i class="fas fa-trash"></i> Hapus</button>';
            $button2 = '<button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="edit('.$field->id_pemohon.')"><i class="fas fa-edit"></i> Edit</button> | <button class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="hapus_pengajuan('.$field->id_pemohon.')"><i class="fas fa-trash"></i> Hapus</button>';
            //$button2 = '<button class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="hapus_pengajuan('.$field->id_pemohon.')"><i class="fas fa-trash"></i> Hapus</button>';
            $button3 = '<button class="btn btn-warning" href="javascript:void(0)" onclick="pembayaran('.$field->id_pemohon.')"><i class="fas fa-dollar-sign"></i> Pembayaran</button>';

            $buttoneditpembayaran = '<button class="btn btn-warning" href="javascript:void(0)" onclick="pembayaranedit('.$field->id_pemohon.')"><i class="fas fa-dollar-sign"></i> Pembayaran</button>';

            $ket = '<button class="btn btn-sm" onclick="ket('.$field->id_pemohon.')"><i class="fas fa-comment-dots text-success"></i> </button>';

            $button4 = '<button class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="edit('.$field->id_pemohon.')"><i class="fas fa-edit"></i> Edit</button>';

            $belumApproveNoHak = '<i class="fas fa-hourglass-start text-danger"></i> Waiting Approve<br> <i class="fas fa-check text-success"></i> No HAK : '.$no_hak;


            $button = '';
            $status = '';
            if($field->status == 1){
                if($sb == 1){
                    $status = $approveBayar;
                    $button = '';
                }elseif($sb == 2){
                    if (!$no_hak) {
                        $status = $approveBayarKonfirmasi;
                    }else{
                        $status = 'No Hak : '.$no_hak.'<br> Segera buat janji temu';
                    }
                }
                elseif($sb == 3){
                    $status = $pending. "" .$ketpending;
                    $button = $buttoneditpembayaran;
                }else{
                    $status = $approve;
                    $button = $button3;
                }
            }elseif($field->status == 2){
                $status = $tolak." ".$ket;
                $button = $button2;
            }else{
                if($no_hak > 0){
                    $status = $belumApproveNoHak;
                    $button = $button4;
                }else{
                    $status = $belumApprove;
                    $button = $button1;
                }
            }

            $row[] = $status;
            $row[] = $button;

            // $row[] = '<a onclick="javascript:edit("'.$field->id_pemohon.'")" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Edit</a> | <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>';

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $c = $this->perhak_model->count_pengajuan(),
            "recordsFiltered" => $c,
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function edit_permohonan(){
        $id_pemohon = $this->input->post('id_pemohon');
        $getPemohon = $this->db->get_where('pemohon', ['id_pemohon'=> $id_pemohon])->row();
        echo json_encode($getPemohon);
    }

    public function edit_pembayaran(){
        $id_pemohon = $this->input->post('id_pemohon');
        $getbukti = $this->db->get_where('bukti_bayar', ['id_pemohon'=> $id_pemohon])->row();
        echo json_encode($getBukti);
    }

    public function hapus_pengajuan(){
        $id_pemohon = $this->input->post('id_pemohon');
        $getDokumen = $this->perhak_model->getPemohonById($id_pemohon);
        $ktp = isset($getDokumen->ktp)?($getDokumen->ktp):"";
        $imb = isset($getDokumen->dok_imb)?($getDokumen->dok_imb):"";
        $sppt = isset($getDokumen->dok_sppt)?($getDokumen->dok_sppt):"";
        $sertifikat = isset($getDokumen->dok_sertifikat)?($getDokumen->dok_sertifikat):"";
        $path_ktp = "./upload/ktp/".$ktp;
        unlink($path_ktp);
        $path_imb = "./upload/imb/".$imb;
        unlink($path_imb);
        $path_sppt = "./upload/sppt/".$sppt;
        unlink($path_sppt);
        $path_sertifikat = "./upload/sertifikat/".$sertifikat;
        unlink($path_sertifikat);

        $hapus = $this->perhak_model->hapusById($id_pemohon);
        echo json_encode($hapus);
    }

    function buat_janji(){
        $ajax = $this->input->get_post("ajax");
        if ($ajax=="yes") {
            $data['konten'] = $this->load->view("perhak/buat_janji",TRUE);
            echo json_encode($data);
        }else{
            $data['title'] = 'Buat Janji';
            $data['konten']='perhak/buat_janji';
            $this->_template($data);
        }
    }

    function kirim_janji(){
        $data = [
            'id_user' => $this->session->id_user,
            'nama' => $this->session->name,
            'tgl' => $this->input->post('dates'),
            'status' => 0,
            'created_at' => date("Y-m-d H:i:s"),
        ];

        $query = $this->perhak_model->kirim_janji($data);
        echo json_encode($query);
    }

    public function get_janji_temu(){
        $list = $this->perhak_model->get_janji_temu();
        $data = [];
        $no = $_POST['start'];

        $approve = '<span class="badge badge-pill badge-success"><i class="fas fa-check"></i> Disetujui</span>';
        $ketApprove = 'Anda harus datang sesuai tanggal dan jam yang di ajukan.';
        $ketWait = 'Menunggu konfirmasi.';
        // $ketTolak = 'Tidak bisa bertemu di tanggal tersebut, karena ada kesibukan lain.';
        $ditolak = '<span class="badge badge-pill badge-danger"><i class="fas fa-ban"></i> Ditolak</span>';
        $belumApprove = '<i class="fas fa-hourglass-start text-primary"></i> Waiting';

        foreach ($list as $field) {
            $getKet = $this->db->get_where('tolak_janji_temu',['id_janji' => $field->id_janji])->row();
            $ketTolak = isset($getKet->keterangan)?($getKet->keterangan):"";


            $no++;
            $row = [];
            $row[] = $no;
            $row[] = 'Tanggal : '.substr($field->tgl, 0, 10).'<br> Jam : '.substr($field->tgl, 11,5);
            $status = '';
            $button = '';
            $ket = '';
            if($field->status == 1){
                $status = $approve;
                $ket = $ketApprove;
            }elseif($field->status == 3){
                $status = $ditolak;
                $ket = $ketTolak;
            }else{
                $ket = $ketWait;
                $status = $belumApprove;
                $button = '<button class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="hapus_janji('.$field->id_janji.')"><i class="fas fa-ban"></i> Batalkan</button>';
            }
            $row[] = $status;
            $row[] = $ket;
            $row[] = $button;

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $c = $this->perhak_model->count_janji_temu(),
            "recordsFiltered" => $c,
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function permintaan_temu(){
        $get_janji_temu = $this->perhak_model->permintaan_temu();
        $data = $this->load->view('perhak/permintaan_temu', ['data' => $get_janji_temu]);
        echo json_encode($data);
    }

    public function janji_temu(){
        $get_janji_temu = $this->perhak_model->janji_temu();
        $data = $this->load->view('perhak/janji_temu', ['data' => $get_janji_temu]);
        echo json_encode($data);
    }

    public function setuju_janji(){
        $id_janji = $this->input->post('id_janji');
        $query = $this->perhak_model->setuju_janji($id_janji);
        echo json_encode($query);
    }
    
    public function tolak_janji(){
        $id_janji = $this->input->post('id_janji');
        $id_user = $this->input->post('id_user');
        $keterangan = $this->input->post('keterangan');

        $data = [
            'id_janji' => $id_janji,
            'id_user' => $id_user,
            'keterangan' => $keterangan,
            'tolak_janji_at' => date("Y-m-d H:i:s")
        ];

        $query = $this->perhak_model->tolak_janji($data);
        echo json_encode($query);
    }

    public function modal_tolak_janji(){
        $id_janji = $this->input->post('id_janji');
        $query = $this->db->get_where('janji_temu', ['id_janji' => $id_janji])->row();
        echo json_encode($query);
    }

    public function deleteJanjiOtomatis(){
        $this->db->where('tgl <', date('Y-m-d'));
        $query = $this->db->delete('janji_temu');
        $tgl = date('Y-m-d');
        echo json_encode($tgl);
    }

    public function batalkan_janji_temu(){
        $id_janji = $this->input->post('id_janji');
        $query = $this->perhak_model->batalkan_janji_temu($id_janji);
        echo json_encode($query);
    }

    public function get_keterangan(){
        $id_pemohon = $this->input->post('id_pemohon');
        $query = $this->perhak_model->get_keterangan($id_pemohon);
        echo json_encode($query);
    }

    public function booking_no_hak(){
        $getNoHak = $this->db->limit(1)->order_by('id_hak', 'DESC')->get('no_hak')->row();
        $noHak = isset($getNoHak->no_hak)?($getNoHak->no_hak + 1):"1";
        echo json_encode($noHak);
    }

    public function save_no_hak(){
        $id_pemohon = $this->input->post('id_pemohon');
        $no_hak = $this->input->post('no_hak');

        $query = $this->perhak_model->save_no_hak($id_pemohon, $no_hak);
        echo json_encode($query);
    }

    public function get_data_to_bayar(){
        $id_pemohon = $this->input->post('id_pemohon');
        $query = $this->perhak_model->getPemohonById($id_pemohon);
        echo json_encode($query);
    }

    //edit pembayaran
    // public function get_data_pembayaran(){
    //     $id_pemohon = $this->input->post('id_pemohon');
    //     $query = $this->perhak_model->getPembayaran($id_pemohon);
    //     echo json_encode($query);
    // }

    public function simpan_bayar(){
        $config['upload_path'] = './upload/bukti_bayar/';
        $config['allowed_types'] = 'pdf|doc|docx|xlsx|jpg|jpeg|png';
        $this->load->library('upload', $config);

        $bukti_bayar = '';
        if(!$this->upload->do_upload('bukti_pembayaran')){
        }else{
            $bukti_bayar = $this->upload->data('file_name');
        }

        $data = [
            'id_pemohon' => $this->input->post('id_pemohon'),
            'no_berkas' => $this->input->post('no_berkas'),
            'nama_bank' => $this->input->post('nama_bank'),
            'nama_pemilik_tabungan' => $this->input->post('nama_pemilik_tabungan'),
            'nominal' => $this->input->post('nominal'),
            'bukti_bayar' => $bukti_bayar,
            'status' => 1
        ];

        $query = $this->perhak_model->simpan_bayar($data);
        echo json_encode($query);
    }

    function kelola_pembayaran(){
        $ajax = $this->input->get_post("ajax");
        if ($ajax=="yes") {
            $data['konten'] = $this->load->view("perhak/kelola_pembayaran",TRUE);
            echo json_encode($data);
        }else{
            $data['title'] = 'Kelola Pembayaran';
            $data['konten']='perhak/kelola_pembayaran';
            $this->_template($data);
        }
    }

    function get_kelola_pembayaran(){
        $list = $this->perhak_model->get_kelola_pembayaran();

        $data = [];
        $no = $_POST['start'];

        $sudahBayar = '<i class="fas fa-check text-success"></i> Sudah Bayar <br> <i class="fas fa-hourglass-start text-danger"></i> Waiting Approve Bayar';
        $pending = '<i class="fas fa-check text-success"></i> Sudah Bayar <br> <i class="fas fa-hourglass-start text-danger"></i> Pembayaran di pending';
        

        $sudahBayarDanApprove = '<i class="fas fa-check text-success"></i> Sudah Bayar <br> <i class="fas fa-check text-success"></i> Pembayaran di setujui';
        $belumBayar = '<i class="fas fa-ban text-danger"></i> Belum Bayar';
        $approve = '<i class="fas fa-check text-success"></i> Approve Bayar';
        $belumApprove = '<i class="fas fa-hourglass-start text-danger"></i> Waiting Approve Bayar';
        $tolak = '<i class="fas fa-ban text-danger"></i> Pembayaran Ditolak';

        foreach ($list as $field) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $field->nama_pemohon;
            $row[] = $field->pengajuan;
            $row[] = $field->no_berkas;
            // $row[] = '<a href="'.base_url('perhak/unduh/').$field->id_pemohon.'" class=" btn btn-sm btn-info"><i class="fas fa-arrow-down"></i> Unduh</a>';

            $getNoHak = $this->db->get_where('no_hak', ['id_pemohon' => $field->id_pemohon])->row();
            $no_hak = isset($getNoHak->no_hak)?($getNoHak->no_hak):0;

            $getBayar = $this->db->get_where('bukti_bayar', ['id_pemohon' => $field->id_pemohon])->row();
            $statusBayar = isset($getBayar->status)?($getBayar->status):0;

            $button2 = '<button class="btn btn-sm btn-primary" onclick="lihat_bayar('.$field->id_pemohon.')">Preview</button>';

            $button3 = '';
       
            
            $button = '';
            $status = '';
            if($getBayar){
                if($statusBayar == 2){
                    $status = $sudahBayarDanApprove;
                    $button = $button3;
                }elseif($statusBayar == 1){
                    $status = $sudahBayar;
                    $button = $button2;
                }elseif($statusBayar == 3){
                    $status = $pending;
                }
            }else{
                $status = $belumBayar;
            }
            $row[] = $button;
            $row[] = $status;

            $data[] = $row;
        }

        $output = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $c = $this->perhak_model->count_pembayaran(),
            "recordsFiltered" => $c,
            "data" => $data,
        ];

        echo json_encode($output);
    }

    public function lihat_bayar(){
        $id_pemohon = $this->input->post('id_bayar');
        $query = $this->db->get_where('bukti_bayar', ['id_pemohon'=>$id_pemohon])->row();
        echo json_encode($query);
    }

    public function lihat_bayar_sesuaiuser(){
        $id_pemohon = $this->input->post('id_bayar');
        $query = $this->db->get_where('bukti_bayar', ['id_pemohon'=>$id_pemohon])->row();
        echo json_encode($query);
    }

    public function setuju_bayar(){
        $id_bukti = $this->input->post('id_bayar'); 

        $this->db->set('status', 2);
        $this->db->where('id_bukti', $id_bukti);
        $query = $this->db->update('bukti_bayar');
        echo json_encode($query);
    }

    public function pending_bayar(){
        $id_bukti = $this->input->post('id_bayar'); 

        $this->db->set('status', 3);
        $this->db->where('id_bukti', $id_bukti);
        $query = $this->db->update('bukti_bayar');
        echo json_encode($query);
    }

    public function cek_pembayaran(){
        $id_pemohon = $this->input->post('id_pemohon');
        $data_bayar = $this->db->get_where('bukti_bayar',['id_pemohon' => $id_pemohon])->row();
        echo json_encode($data_bayar);
    }

}   