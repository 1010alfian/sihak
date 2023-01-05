<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
	private $_table = "user";

    public function rules()
	{
		return [
            [
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'required|trim'
			],
			[
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'required|valid_email|is_unique[user.email]',
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required|max_length[255]|trim'
			]
		];
	}

	public function check_user($email){
		$user = $this->db->get_where($this->_table,['email'=>$email])->row();
		return $user;
	}

    public function registrationSave($data){
        $this->db->insert($this->_table, $data);
    }
}