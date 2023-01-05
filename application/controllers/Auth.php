<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('auth_model');
		$this->load->library('form_validation');
    }

    public function signin(){
        $data['title'] = 'Sign In';
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if($this->form_validation->run() == FALSE){
            $this->load->view('signin', $data);
		}else{
            $this->login();
        }
    }

    private function login(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->auth_model->check_user($email);
        $getRole = $this->db->get_where('role', ['id_role' => $user->role_id])->row();
        $role = $getRole->role;

        // if user exist
        if($user){
            // if user active
            if($user->is_active == 1){
                if(password_verify($password, $user->password)){
                    $data = [
                        'id_user' => $user->id_user,
                        'email' => $user->email,
                        'name' => $user->name,
                        'role_id' => $user->role_id,
                        'role' => $role,
                    ];
                    $this->session->set_userdata($data);
                    redirect('dashboard');
                }else{
                    $this->session->set_flashdata('msg', 'Password salah');
                    redirect('auth/signin');    
                }
            }else{
                $this->session->set_flashdata('msg', 'Email tidak aktif');
                redirect('auth/signin');
            }
        }else{
            $this->session->set_flashdata('msg', 'Email belum terdaftar');
            redirect('auth/signin');
        }
    }

    function signout(){
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        redirect('auth/signin');
    }

    public function registration(){
        $data['title'] = 'Registrtation';
        $rules = $this->auth_model->rules();
        $this->form_validation->set_rules($rules);

        if($this->form_validation->run() == FALSE){
            $this->load->view('registration', $data);
		}else{
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'image' => 'default.jpg',
                'role_id' => 2,
                'is_active' => 1,
                'created_at' => date('d/m/Y H:i:s')
            ];

            $this->auth_model->registrationSave($data);
            $this->session->set_flashdata('msg', 'Akun berhasil di buat <br/> Silahkan Sign In');
            redirect('auth/signin');
        }
    }

}