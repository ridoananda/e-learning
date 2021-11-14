<?php

use Config\App;

function checked($role_id, $menu_id)
{
	$db = \Config\Database::connect();
	$access = $db->table('user_access_menu')->where([
		'role_id' => $role_id,
		'menu_id' => $menu_id
	])->countAllResults();

	if ($access > 0) {
		return 'checked';
	}
}

function waktu_lalu($timestamp)
{
	$selisih = time() - strtotime($timestamp);

	$detik = $selisih;
	$menit = round($selisih / 60);
	$jam = round($selisih / 3600);
	$hari = round($selisih / 86400);
	$minggu = round($selisih / 604800);
	$bulan = round($selisih / 2419200);
	$tahun = round($selisih / 29030400);

	if ($detik <= 60) {
		$waktu = 'baru saja';
	} else if ($menit <= 60) {
		$waktu = $menit . ' menit yang lalu';
	} else if ($jam <= 23) {
		$waktu = $jam . ' jam yang lalu';
	} else if ($hari <= 60) {
		$waktu = $hari . ' hari yang lalu';
	} else if ($minggu <= 7) {
		$waktu = $minggu . ' minggu yang lalu';
	} else if ($bulan <= 12) {
		$waktu = $bulan . ' bulan yang lalu';
	} else {
		$waktu = $tahun . ' tahun yang lalu';
	}

	return $waktu;
}

function jam($timestamp)
{
	$selisih = time() - strtotime($timestamp);

	$jam = date('H:i', strtotime($timestamp));

	return $jam;
}


function tanggal_lengkap($timestamp)
{
	$selisih = strtotime($timestamp);
	$hari = date('l', $selisih);

	switch ($hari) {
		case 'Monday':
			$hari = 'Senin';
			break;
		case 'Tuesday':
			$hari = 'Selasa';
			break;
		case 'Wednesday':
			$hari = 'Rabu';
			break;
		case 'Thursday':
			$hari = 'Kamis';
			break;
		case 'Friday':
			$hari = 'Jum\'at';
			break;
		case 'Saturday':
			$hari = 'Sabtu';
			break;

		default:
			$hari = 'Minggu';
			break;
	}

	$tanggal = date('j-m-Y', $selisih);

	return $hari . ', ' . $tanggal;
}


function time_lengkap($time)
{

	$hari = date('l', $time);

	switch ($hari) {
		case 'Monday':
			$hari = 'Senin';
			break;
		case 'Tuesday':
			$hari = 'Selasa';
			break;
		case 'Wednesday':
			$hari = 'Rabu';
			break;
		case 'Thursday':
			$hari = 'Kamis';
			break;
		case 'Friday':
			$hari = 'Jum\'at';
			break;
		case 'Saturday':
			$hari = 'Sabtu';
			break;

		default:
			$hari = 'Minggu';
			break;
	}

	$tanggal = date('j-m-Y', $time);

	return $hari . ', ' . $tanggal;
}

function tambah_notif($user_id, $url, $text, $icon)
{
	$notifModel = new \App\Models\NotifikasiModel();
	return $notifModel->save([
		'user_id' => $user_id,
		'url' => $url,
		'text' => $text,
		'icon' => $icon,
		'is_cek' => 0,
	]);
}

function sendEmail($to, $judul, $pesan)
{
	$email = \Config\Services::email();

	$email->setFrom('ridoananda123@gmail.com', 'Rido Ananda');
	$email->setTo($to);
	$email->setSubject($judul);
	$email->setMessage($pesan);

	if (!$email->send()) {
		return false;
	} else {
		return true;
	}
}
