<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_home');
	}

	public function index()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "You must logged in to access apps", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url(), 'refresh');
			die;
		}

		$this->form_validation->set_rules('nama', 'budget name', 'trim|required|max_length[30]');
		$this->form_validation->set_rules('jumlah', 'budget value', 'required');
		$this->form_validation->set_rules('bulan', 'month', 'trim|required');
		$this->form_validation->set_rules('tahun', 'year', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{
			$nama 		= $this->input->post('nama');
			$jumlah 	= str_replace(".", "", $this->input->post('jumlah'));
			$bulan 		= $this->input->post('bulan');
			$tahun 		= $this->input->post('tahun');
			
			$this->load->library('ciqrcode');

			$config['cacheable']    = true;
	        $config['imagedir']     = '/assets/.images/qrcode/';
	        $config['quality']      = true;
	        $config['size']         = '1024';
	        $config['black']        = array(224,255,255);
	        $config['white']        = array(70,130,180);
	        $this->ciqrcode->initialize($config);

			$this->load->helper('string');

	        $random = random_string('alnum', 11);
	        $qrcode = $random.'.png';

	        $params['data'] = $random;
	        $params['level'] = 'H';
	        $params['size'] = 10;
	        $params['savename'] = FCPATH.$config['imagedir'].$qrcode;
	        $this->ciqrcode->generate($params);


			if ($this->model_home->simpan_uang(ucfirst($nama), $jumlah, $bulan, $tahun, $random))
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Money success to saved", timer: 10000, icon: "success", button: false});</script>');
				redirect(base_url('index.php/home'), 'refresh');
			}
			else
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong, try again later", timer: 10000, icon: "error", button: false});</script>');
				redirect(base_url('index.php/home'), 'refresh');
			}
		}
		else
		{
			$data = array(
				'title' 		=> 'Home &mdash; Moneytor Apps',
				'description'	=> 'Moneytor Apps is web based application that used to monitoring money up to IDR 100.000.000',
				'uang_rows'		=> $this->model_home->lihat_uang(),
				'kategori_rows'	=> $this->model_home->ambil_kategori()
			);
			
			$data['user'] = $this->model_home->ambil_user_data($this->session->userdata('user_id'))->row_array();

			$this->load->view('template/header', $data, FALSE);
			$this->load->view('home');
			$this->load->view('template/footer');
		}
	}

	public function spending()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "You must logged in to access apps", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url(), 'refresh');
			die;
		}

		if (isset($_POST['spending']))
		{
			$uang_id 	 = $this->input->post('uang_id');
			$kategori_id = $this->input->post('kategori_id');
			$nama		 = $this->input->post('nama');
			$jumlah 	 = str_replace(".", "", $this->input->post('jumlah'));
			$totaluang 	 = $this->input->post('uang');

			if (!empty($nama) && !empty($jumlah))
			{
				if (strlen($nama) <=25 && $jumlah >= 1)
				{
					if ($jumlah <= $totaluang)
					{
						$spending = $this->model_home->spending_pengeluaran($uang_id, $kategori_id, $nama, $jumlah);
						$uang 	  = $this->model_home->spending_uang($uang_id, $jumlah);

						if ($spending && $uang)
						{
							$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Spending successfully added", timer: 10000, icon: "success", button: false});</script>');
							redirect(base_url('index.php/home'), 'refresh');
						}
						else
						{
							$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong, try again later", timer: 10000, icon: "error", button: false});</script>');
							redirect(base_url('index.php/home'), 'refresh');
						}
					}
					else
					{
						$this->session->set_flashdata('info', '<script>swal({title: "Info", text: "You must set spending value less than or equal to amount of money", timer: 10000, icon: "info", button: false});</script>');
						redirect(base_url('index.php/home'), 'refresh');
					}

				}
				else
				{
					$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Spending name maximal 25 character and spending value cannot empty or zero", timer: 10000, icon: "error", button: false});</script>');
					redirect(base_url('index.php/home'), 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Please complete all field to create spending", timer: 10000, icon: "error", button: false});</script>');
				redirect(base_url('index.php/home'), 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong, try again later", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url('index.php/home'), 'refresh');
		}
	}

	public function moneytor($pocket='', $uid='')
	{
		$pocket = $this->input->get('pocket');
		$uid 	= $this->input->get('uid');

		if ($this->model_home->ambil_uang($pocket, $uid)->num_rows() > 0)
		{
			$data = array(
				'pocket'			=> $this->model_home->ambil_uang($pocket, $uid)->row_array(),
				'spending_rows'		=> $this->model_home->ambil_spending($uid),
				'income_rows'		=> $this->model_home->ambil_income($uid),
				'spending_sum'		=> $this->model_home->ambil_sum($uid, 'pengeluaran')->row_array(),
				'income_sum'		=> $this->model_home->ambil_sum($uid, 'pemasukan')->row_array(),
				'user_id'			=> $this->model_home->ambil_user_id($uid),
				'link'				=> (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"
			);

			$data['user_data']		= $this->model_home->ambil_user_data($data['user_id'])->row_array();
			$data['title']			= $data['pocket']['nama'].' &mdash; Moneytor Apps';
			$data['description']	= 'Moneytoring data for '.$data['pocket']['nama'].' &mdash; Moneytor Apps';

			$this->load->view('template/header', $data, FALSE);
			$this->load->view('moneytor');
			$this->load->view('template/footer');
		}
		else
		{
			$data = array(
				"error" 	=> true,
				"message" 	=> "No data to display",
				"btw" 		=> "I'am weak to design 404 page XD"
			);

			print("<pre>".print_r($data, true)."</pre><br/>");
		}
	}

	public function hapus_moneytor()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "You must logged in to access apps", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url(), 'refresh');
			die;
		}

		$this->form_validation->set_rules('uang_id', 'pocket', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{
			$uang_id = $this->input->post('uang_id');
			$pocket  = $this->input->post('pocket');

			$pemasukan 		= $this->model_home->hapus_moneytor($uang_id, 'pemasukan');
			$pengeluaran 	= $this->model_home->hapus_moneytor($uang_id, 'pengeluaran');
			$moneytor 		= $this->model_home->hapus_moneytor($uang_id, 'uang');
			
			unlink('assets/.images/qrcode/'.$pocket.'.png');

			if ($pemasukan && $pengeluaran && $moneytor)
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Moneytor successfully deleted", timer: 10000, icon: "success", button: false});</script>');
				redirect(base_url('index.php/home'), 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url('index.php/home'), 'refresh');
		}
	}

	public function hapus_spending($pengeluaran_id='')
	{
		if (!$this->session->has_userdata('user_id'))
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "You must logged in to access apps", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url(), 'refresh');
			die;
		}

		$this->form_validation->set_rules('pengeluaran_id', 'pengeluaran_id', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{
			$pocket 		= $this->input->post('pocket');
			$uang_id 		= $this->input->post('uang_id');
			$pengeluaran_id = $this->input->post('pengeluaran_id');
			$jumlah 		= $this->input->post('jumlah');

			$hapus 	= $this->model_home->hapus_pengeluaran($pengeluaran_id);
			$tambah = $this->model_home->tambah_uang($uang_id, $jumlah);

			if ($hapus && $tambah)
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Spending successfully deleted", timer: 10000, icon: "success", button: false});</script>');
				redirect(base_url('index.php/home/moneytor?pocket='.$pocket.'&uid='.$uang_id), 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url('index.php/home'), 'refresh');
		}
	}

	public function income()
	{
		if (!$this->session->has_userdata('user_id'))
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "You must logged in to access apps", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url(), 'refresh');
			die;
		}

		$uang_id 	= $this->input->post('uang_id');
		$nama 		= $this->input->post('nama');
		$jumlah 	= str_replace(".", "", $this->input->post('jumlah'));

		if (isset($_POST['income']))
		{
			if (!empty($nama) && !empty($jumlah))
			{
				if (strlen($nama) <=25 && $jumlah >= 1)
				{
					$simpan = $this->model_home->income_simpan($uang_id, $nama, $jumlah);
					$tambah = $this->model_home->income_uang($uang_id, $jumlah);

					if ($simpan && $tambah)
					{
						$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Income successfully added", timer: 10000, icon: "success", button: false});</script>');
						redirect(base_url('index.php/home'), 'refresh');
					}
					else
					{
						$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong, try again later", timer: 10000, icon: "error", button: false});</script>');
						redirect(base_url('index.php/home'), 'refresh');
					}
				}
				else
				{
					$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Income name maximal 25 character and income value cannot empty or zero", timer: 10000, icon: "error", button: false});</script>');
					redirect(base_url('index.php/home'), 'refresh');
				}
			}
			else
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Please complete all field to save income", timer: 10000, icon: "error", button: false});</script>');
				redirect(base_url('index.php/home'), 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url('index.php/home'), 'refresh');
		}
	}

	public function hapus_income($pemasukan_id='')
	{
		if (!$this->session->has_userdata('user_id'))
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "You must logged in to access apps", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url(), 'refresh');
			die;
		}

		$this->form_validation->set_rules('pemasukan_id', 'pemasukan_id', 'trim|required');

		if ($this->form_validation->run() == TRUE)
		{
			$pocket 		= $this->input->post('pocket');
			$uang_id 		= $this->input->post('uang_id');
			$pemasukan_id 	= $this->input->post('pemasukan_id');
			$jumlah 		= $this->input->post('jumlah');

			$hapus 	= $this->model_home->hapus_pemasukan($pemasukan_id);
			$tambah = $this->model_home->kurangi_uang($uang_id, $jumlah);

			if ($hapus && $tambah)
			{
				$this->session->set_flashdata('info', '<script>swal({title: "Success", text: "Income successfully deleted", timer: 10000, icon: "success", button: false});</script>');
				redirect(base_url('index.php/home/moneytor?pocket='.$pocket.'&uid='.$uang_id), 'refresh');
			}
		}
		else
		{
			$this->session->set_flashdata('info', '<script>swal({title: "Error", text: "Something when wrong", timer: 10000, icon: "error", button: false});</script>');
			redirect(base_url('index.php/home'), 'refresh');
		}
	}
}

/* End of file beranda.php */
/* Location: ./application/controllers/beranda.php */