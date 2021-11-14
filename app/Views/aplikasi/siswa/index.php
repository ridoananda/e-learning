<?= $this->extend('aplikasi/layout/template') ?>
<?= $this->section('content') ?>

<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800">Dashboard Siswa</h1>

	<div class="row">
		<div class="col-md-6">
			<?php if (session()->getFlashdata('berhasil')) : ?>
				<div class="alert alert-success text-center">
					<?= session()->getFlashdata('berhasil') ?>
				</div>
			<?php endif ?>
			<hr class="my-2">
			<div class="mb-3">
				<p>
					Halo <?= $user['nama_lengkap']; ?>,
					<br>
					Selamat datang di website belajar online! kamu bisa mengumpulkan tugas dan absensi kelas harian disini. jika kamu masih bingung dengan aplikasi ini silahkan baca <a href="#panduan" class="badge badge-primary" id="panduan">buku panduan</a> agar tidak terjadi ketidaknyamanan.
				</p>
			</div>
			<div>
				<h4 class="text-gray-800">Apa tujuan aplikasi ini ?</h4>
				<p>Tujuan dibentuknya aplikasi ini untuk memudahkan kita dalam belajar secara online,
					dalam masa pandemi ini diharapkan bisa memulai belajar dengan semangat dan meningkatkan prestasi kita dalam belajar.
				</p>
			</div>
		</div>

		<!-- Content Row -->
		<div class="col-md-6">
			<h4 class="text-gray-800 mb-3" id="panduan">Buku panduan</h4>
			<nav>
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-link active" id="nav-tugas-tab" data-toggle="tab" href="#nav-tugas" role="tab" aria-controls="nav-tugas" aria-selected="true">Tugas</a>
					<a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Absen</a>
					<a class="nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Blog</a>
				</div>
			</nav>
			<div class="tab-content mb-5" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-tugas" role="tabpanel" aria-labelledby="nav-tugas-tab">
					<p class="mt-2">
						Kamu bisa menyerahkan tugas di forum tugas tetapi penyerahan tugas hanya bisa 1 kali saja.
						<br>
						Selain dari itu, kamu juga bisa berkomentar dan berdiskusi disana
						<br>
						Kamu akan mendapatkan notifikasi dari gmail jika ada tugas baru yang masuk,
						<br>
						<br>
						Saat kamu menyerahkan tugas, disana ada fitur <b>Upload File, Foto dan Video</b> tapi maksimal pengiriman file/video hanya 20MB dan juga ekstensi yang terbatas. hanya bisa upload file <b>Microsoft Word, Power Point, Excel dan PDF</b>. Selain dari itu tidak diizinkan mengupload, <i>*terkecuali di perbaharui</i>
						<br>
						<br>
						<b>INGAT!</b> ketika <b>Guru</b> kamu menghapus tugas, maka data tugas yang kamu kumpulkan juga terhapus.
						<br>
						<i>Jadilah pengguna yang bijak! Sekian dan terima kasih...</i>
					</p>
				</div>
				<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<p class="mt-2">
						Di halaman <a href="/aplikasi/siswa/absen" class="badge badge-info">Absen kelas</a> terdapat daftar absensi harian, pilih absen yang tersedia lalu pilih sesuai keterangan absen kamu (Hadir,Sakit,Izin) dan Hanya dengan 1 klik kamu sudah mengabsen pelajaran!
						<br>
						<br>
						Batas Waktu Ditentukan oleh <b>Guru</b> mata pelajaran kamu dan jika terdapat kesalahan mungkin absen sudah dihapus oleh guru
						<br>
						<br>
						Ketika kamu melakukan Absen maka <b>Guru</b> mata pelajaran tersebut mendapatkan notifikasi dari aplikasi ini
						<br>
						<br>
						<b>INGAT!</b> ketika kamu mengumpulkan absen, <b>Batas Pengiriman Absen</b> hanya sekali dalam sehari.
						<br>
						<i>Jadilah pengguna yang bijak! Sekian dan terima kasih...</i>
					</p>
				</div>
				<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">COOMING SOON :)</div>
			</div>
		</div>



	</div>
</div>
<!-- /.container-fluid -->

<?= $this->endSection() ?>