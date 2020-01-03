<?php
if ($this->session->flashdata('info')) echo $this->session->flashdata('info');
?>
<div class="mt-3 mb-5 container">
	<div class="d-flex justify-content-center form-row">
		<div class="col-lg-4 post-outer">
			<div class="mb-3 text-dark">
				<div class="float-left">
					<a href="<?= base_url('index.php/home'); ?>" title="Back" class="card-link">
						<i class="fa fa-arrow-left"></i>
					</a>
				</div>
				<div class="float-right">
					<a href="<?= base_url('index.php/account/password'); ?>" title="Password" class="card-link">
						<i class="fa fa-lock"></i>
					</a>
				</div>
				<div class="text-center font-weight-bold font-weight-light text-truncate">
					Account
				</div>
			</div>
			<hr>
			<div class="text-center mb-5 text-truncate ml-3 mr-3">
				👋 Hi, good <?= waktu(date('H')); ?> <?= nama($user['nama']); ?>
			</div>
			<div class="card card-body shadow brad-20 mb-3">
				<?= form_open('index.php/account'); ?>
				<?= validation_errors('<script>swal({title: "Warning", text: "', '", timer: 10000, icon: "warning", button: false});</script>'); ?>
				<input type="text" name="nama" value="<?= $user['nama']; ?>" placeholder="Your name" class="form-control brad-20 mb-3">
				<button name="submit" class="btn btn-primary brad-20">Save changes</button>
				<?= form_close(); ?>
			</div>
		</div>
	</div>
</div>