<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_home extends CI_Model {

	public function simpan_uang($nama, $jumlah, $bulan, $tahun, $random)
	{
		$this->load->helper('string');

		$data = array(
			'user_id' 	=> $this->session->userdata('user_id'),
			'nama' 		=> $nama,
			'bulan' 	=> $bulan,
			'tahun' 	=> $tahun,
			'jumlah'	=> $jumlah,
			'pocket'	=> $random,
			'qrcode'    => $random.'.png'
		);

		$this->db->insert('uang', $data);
		return TRUE;
	}

	public function lihat_uang()
	{
		$this->db->select('*');
		$this->db->from('uang');
		$this->db->where('user_id', $this->session->userdata('user_id'));
		$this->db->order_by('uang_id', 'desc');

		return $this->db->get();
	}

	public function ambil_kategori()
	{
		$this->db->select('*');
		$this->db->from('kategori');

		return $this->db->get();
	}

	public function ambil_uang($pocket, $uid)
	{
		return $this->db->get_where(
			'uang', array('uang_id' => $uid, 'pocket' => $pocket)
		);
	}

	public function spending_pengeluaran($uang_id, $kategori_id, $nama, $jumlah)
	{
		$data = array(
			'uang_id' 		=> $uang_id,
			'kategori_id' 	=> $kategori_id,
			'nama'			=> $nama,
			'jumlah'		=> $jumlah,
			'tanggal'		=> date('Y-m-d H:i:s')
		);

		$this->db->insert('pengeluaran', $data);
		return TRUE;
	}

	public function spending_uang($uang_id, $jumlah)
	{
		$this->db->set('jumlah', 'jumlah-'.$jumlah.'', FALSE);
		$this->db->where('uang_id', $uang_id);
		$this->db->update('uang');

		return TRUE;
	}

	public function ambil_spending($uang_id)
	{
		$this->db->select('p.pengeluaran_id, p.uang_id, p.nama AS "nama", p.jumlah, p.tanggal, k.icon, k.nama AS "kategori"');
		$this->db->from('pengeluaran p');
		$this->db->join('kategori k', 'p.kategori_id = k.kategori_id', 'left');
		$this->db->where('uang_id', $uang_id);
		$this->db->order_by('pengeluaran_id', 'desc');

		return $this->db->get();
	}


	public function ambil_income($uang_id)
	{
		$this->db->select('*');
		$this->db->from('pemasukan');
		$this->db->where('uang_id', $uang_id);
		$this->db->order_by('pemasukan_id', 'desc');

		return $this->db->get();
	}

	public function ambil_sum($uang_id, $table)
	{
		$this->db->select_sum('jumlah');
		$this->db->where('uang_id', $uang_id);
		
		return $this->db->get($table);
	}

	public function hapus_moneytor($uang_id, $table)
	{
		$this->db->where('uang_id', $uang_id);
		$this->db->delete($table);

		return TRUE;
	}

	public function hapus_pengeluaran($pengeluaran_id)
	{
		$this->db->where('pengeluaran_id', $pengeluaran_id);
		$this->db->delete('pengeluaran');

		return TRUE;
	}

	public function tambah_uang($uang_id, $jumlah)
	{
		$this->db->set('jumlah', 'jumlah+'.$jumlah.'', FALSE);
		$this->db->where('uang_id', $uang_id);
		$this->db->update('uang');

		return TRUE;
	}

	public function income_simpan($uang_id, $nama, $jumlah)
	{
		$data = array(
			'uang_id' 		=> $uang_id,
			'nama'			=> $nama,
			'jumlah'		=> $jumlah,
			'tanggal'		=> date('Y-m-d H:i:s')
		);

		$this->db->insert('pemasukan', $data);
		return TRUE;
	}

	public function income_uang($uang_id, $jumlah)
	{
		$this->db->set('jumlah', 'jumlah+'.$jumlah.'', FALSE);
		$this->db->where('uang_id', $uang_id);
		$this->db->update('uang');

		return TRUE;
	}

	public function hapus_pemasukan($pemasukan_id)
	{
		$this->db->where('pemasukan_id', $pemasukan_id);
		$this->db->delete('pemasukan');

		return TRUE;
	}

	public function kurangi_uang($uang_id, $jumlah)
	{
		$this->db->set('jumlah', 'jumlah-'.$jumlah.'', FALSE);
		$this->db->where('uang_id', $uang_id);
		$this->db->update('uang');

		return TRUE;
	}

	public function ambil_user_id($uang_id)
	{
		$this->db->select('user_id');
		$this->db->from('uang');
		$this->db->where('uang_id', $uang_id);

		return $this->db->get()->row('user_id');
	}

	public function ambil_user_data($user_id)
	{
		$this->db->select('nama, password');
		$this->db->from('user');
		$this->db->where('user_id', $user_id);

		return $this->db->get();
	}
}

/* End of file model_home.php */
/* Location: ./application/models/model_home.php */