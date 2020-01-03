<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_account extends CI_Model {

	public function simpan_nama($nama)
	{
		$data = array('nama' => $nama);

		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->update('user', $data);

		return TRUE;
	}
	public function renew_password($password)
	{
		$data = array(
			'password' => password_hash($password, PASSWORD_DEFAULT)
		);

		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->update('user', $data);
	}
}

/* End of file model_account.php */
/* Location: ./application/models/model_account.php */