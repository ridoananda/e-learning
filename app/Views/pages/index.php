<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<?php if (session()->getFlashdata('berhasil')) : ?>
	<script>
		swal('Pesan terkirim!!', 'Terima kasih sudah hubungi kami, secepatnya akan kami respon', 'success')
	</script>
<?php endif ?>
<?php if (session()->getFlashdata('gagal')) : ?>
	<script>
		swal('Error!', '<?= $validation->getError('nama_lengkap') ?> <?= $validation->getError('email') ?> <?= $validation->getError('pesan') ?>', 'error')
	</script>
<?php endif ?>

<div id="home">
	<nav class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar">
		<div class="container">
			<a class="navbar-brand font-weight-bold" href="/">E-Learning</a>
			<button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="navbarNav">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
				<ul class="navbar-nav mt-2 mt-lg-0 align-items-center">
					<li class="nav-item">
						<a class="nav-link active" href="#home">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#fitur">Fitur</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#artikel">Artikel</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#hubungi">Hubungi Kami</a>
					</li>
					<li class="nav-item">
						<a class="nav-link btn-masuk mt-2 mt-lg-0" href="/masuk">
							<?= (session()->has('e')) ? '<i class="fas fa-user fa-sm fa-fw"></i> Dashboard Saya' : '<i class="fas fa-sign-in-alt fa-sm fa-fw"></i> Masuk'; ?>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<div class="custom-section">
					<h1>Tingkatkan Prestasi Mu <br>dengan belajar</h1>
					<p>Bingung dengan pelajaran sekolah? daftar disini aja.
						kamu bisa akses fitur di website ini.
						Absen sekolah, membaca artikel, dan lainnya.
						Tunggu apalagi ? Daftar Sekarang!
					</p>
					<a class="btn btn-primary btn-daftar mr-1" href="/daftar">Daftar sekarang</a>
					<a class="btn btn-primary btn-masuk" href="/masuk">Masuk</a>
				</div>
			</div>
		</div>
	</div>

	<section id="fitur">
		<div class="container py-5 mb-4">
			<div class="row">
				<div class="col">
					<h1 class="text-capitalize">Apa saja fitur yang
						disediakan?</h2>
				</div>
			</div>
			<div class="row mt-4">
				<div class="col-lg-4 mb-3">
					<img src="/img/membaca-artikel.png" alt="Membaca artikel" class="mb-4">
					<h5>Membaca artikel</h5>
					<p>Baca lah semua artikel yang tersedia disini
						dan berdiskusi lah di kolom
						komentar.</p>
				</div>
				<div class="col-lg-4 mb-3">
					<img src="/img/absen-kelas.png" alt="Membaca artikel" class="mb-4">
					<h5>Absen Kelas</h5>
					<p>Kamu bisa absen sekolah disini dengan
						mudah dan gak ribet.</p>
				</div>
				<div class="col-lg-4 mb-3">
					<img src="/img/tugas-kelas.png" alt="Tugas kelas" class="mb-4">
					<h5>Tugas Kelas</h5>
					<p>Gak perlu kode kelas lagi, mata pelajaran
						sudah diterapkan sesuai kelas dan jurusan
						kamu.</p>
				</div>
			</div>
		</div>
	</section>

	<section id="artikel">
		<div class="container py-3">
			<div class="row mb-3">
				<div class="col">
					<h1 class="text-capitalize">Artikel</h2>
				</div>
			</div>
			<div class="row">
				<?php foreach ($artikel as $art) :
					$user_upload = $db->table('user')->where(['id' => $art->user_id])->get()->getRow();
					$kategori = $db->table('kategori_artikel')->where(['id' => $art->kategori_id])->get()->getRow();
					$komentar = $db->table('komentar_artikel')->where(['artikel_id' => $art->id])->countAllResults();
				?>
					<div class="col-lg-4 col-sm-6">
						<div class="card mb-3 shadow">
							<img src="/template/img/thumbnail/<?= $art->thumbnail; ?>" class="card-img-top" alt="Thumbnail artikel">
							<div class="card-body">
								<h4 class="judul-artikel"><?= $art->judul; ?></h4>
								<small class="text-muted d-block mb-2">
									<div class="mb-1">
										<span class="mr-2 d-inline-block"><i class="far fa-user fa-fw"></i> <?= $user_upload->nama_lengkap; ?></span>
										<span><i class="far fa-folder-open fa-fw"></i> <?= $kategori->kategori; ?></span>
									</div>
									<div>
										<span class="d-inline-block mr-2"><i class="far fa-clock fa-fw"></i> <?= tanggal_lengkap($art->created_at); ?></span>
										<span><i class="far fa-comments fa-fw"></i> <?= $komentar; ?> Komentar</span>
									</div>
								</small>
								<div class="isi-text text-break">
								  <?php
          //         $str = str_replace("</p>", "", $art->text);
          //         $paragraf = explode("<p>", $str);
                 
								  // echo (count($paragraf) > 2) ? $paragraf[1] : $paragraf[1]; 
								  ?>
								  </div>
								<a class="btn d-block btn-baca-selengkapnya" href="/artikel/<?= $art->slug; ?>" role="button">Baca Selengkapnya <i class="fas fa-chevron-right fa-xs fa-fw"></i></a>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
			<div class="row">
				<div class="col d-flex justify-content-center py-3">
					<a href="/artikel" class="text-center text-dark text-decoration-none h5">Lihat semua artikel <i class="fa fa-arrow-right fa-xs fa-fw"></i></a>
				</div>
			</div>
		</div>
	</section>

	<section id="hubungi">
		<div class="container py-3">
			<div class="row mt-4">
				<div class="col">
					<h1 class="text-capitalize">Hubungi Kami</h2>
				</div>
			</div>
			<div class="row justify-content-center mb-2">
				<div class="col-md-6">
					<form action="/hubungi" method="post" class="form-hubungi" autocomplete="off">
						<div class="form-group">
							<label for="nama_lengkap">Nama lengkap</label>
							<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" aria-describedby="asdsad" value="<?= old('nama_lengkap'); ?>">
						</div>
						<div class="form-group">
							<label for="email">Email</label>
							<input type="text" class="form-control" name="email" id="email" value="<?= old('email'); ?>">
						</div>
						<div class="form-group">
							<label for="pesan">Pesan</label>
							<textarea class="form-control" name="pesan" id="pesan" rows="4"><?= old('pesan'); ?></textarea>
						</div>
						<div class="d-flex justify-content-center">
							<button type="submit" class="btn">Kirim</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>

</div>
<?= $this->endSection(); ?>