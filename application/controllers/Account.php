<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_home');
		$this->load->model('model_account');
	}

	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "You must logged in to access apps", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url(), 'refresh');
			die;
		}

		$this->form_validation->set_rules('nama', 'name', 'trim|required|min_length[3]|max_length[30]');

		$data = array(
			'title' 		=> 'Account &mdash; Moneytor Apps',
			'description' 	=> 'Moneytor Apps is web based application that used to monitoring money up to IDR 100.000.000',
			'user_id'		=> $this->session->userdata('user_id')
		);

		$data['user'] = $this->model_home->ambil_user_data($data['user_id'])->row_array();

		if ($this->form_validation->run() == TRUE)
		{
			$nama = $this->input->post('nama');

			if($data['user']['nama'] != $nama)
			{
				if ($this->model_account->simpan_nama($nama))
				{
					$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Name successfully updated", timer: 10000, icon: "success", button: false});</script>');
					redirect(base_url('index.php/account'), 'refresh');
				}
				else
				{
					$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong", timer: 10000, icon: "error", button: false});</script>');
					redirect(base_url('index.php/account'), 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Info", text: "You not make any changes", timer: 10000, icon: "info", button: false});</script>');
				redirect(base_url('index.php/account'), 'refresh');
			}
		}
		else
		{
			$this->load->view('template/header', $data);
			$this->load->view('account');
			$this->load->view('template/footer');
		}
	}

	public function password()
	{
		$data = array(
			'title' 		=> 'Password &mdash; Moneytor Apps',
			'description'	=> 'Moneytor Apps is web based application that used to monitoring money up to IDR 100.000.000',
			'user_id'		=> $this->session->userdata('user_id')
		);

		$data['user'] = $this->model_home->ambil_user_data($data['user_id'])->row_array();

		$this->form_validation->set_rules('password_old', 'password', 'trim|required');
		$this->form_validation->set_rules('password_new', 'new password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_cfm', 'confirm password', 'trim|required|matches[password_new]');

		if ($this->form_validation->run() == TRUE)
		{
			$password_old = $this->input->post('password_old');
			$password_new = $this->input->post('password_new');
			
			if (password_verify($password_old, $data['user']['password']))
			{
				$this->model_account->renew_password($password_new);

				$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Password has been updated", timer: 10000, icon: "success", button: false});</script>');
				redirect(base_url('index.php/account/password'), 'refresh');				
			}
			else
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Password you entered is correct", timer: 10000, icon: "error", button: false});</script>');
				redirect(base_url('index.php/account/password'), 'refresh');
			}
		}
		else
		{
			$this->load->view('template/header', $data);
			$this->load->view('password');
			$this->load->view('template/footer');
		}
	}
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */