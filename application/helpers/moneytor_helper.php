<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('moneytor'))
{
	function rupiah($uang)
	{
		$rupiah = number_format($uang, 0, ',','.');

		return 'Rp'.$rupiah;
	}

	function waktu($waktu)
	{
		if ($waktu <= 11) $waktu = 'morning';
		elseif ($waktu <= 13) $waktu = 'noon';
		elseif ($waktu <= 17) $waktu = 'after noon';
		elseif ($waktu <= 21) $waktu = 'evening';
		elseif ($waktu <= 24) $waktu = 'night';
		else $waktu = 'day';

		return $waktu;
	}

	function nama($nama)
	{
		if ($nama == "" OR $nama == NULL)
		{
			$nama = '<i>Anonim</i>';
		}

		return $nama;
	}
}