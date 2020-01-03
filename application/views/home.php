<?php
if ($this->session->flashdata('info')) echo $this->session->flashdata('info');
?>
<div class="mt-3 container">
	<div class="d-flex justify-content-center form-row">
		<div class="col-lg-4 post-outer">
			<div class="mb-5 text-dark">
				<div class="h5 float-left">
					Moneytor Apps
				</div>
				<div class="float-right">
					<a href="<?= base_url('index.php/login/logout'); ?>" title="Logout" class="card-link">
						Logout
					</a>
				</div>
			</div>
			<hr>
		</div>
	</div>
</div>
<div class="text-center text-truncate ml-3 mr-3">
	👋 Hi, good <?= waktu(date('H')); ?> <?= nama($user['nama']); ?>
</div>
<div class="mb-3 mb-5 mt-3">
	<div class="container">
		<div class="d-flex justify-content-center form-row">
			<div class="col-lg-4 post-outer">
				<?php if ($uang_rows->num_rows() < 1): ?>
					<div class="mt-5">
						<img src="<?= base_url('assets/.images/start.png'); ?>" alt="Empty" class="img-fluid p-2">
						<div class="font-weight-light text-center h6 mt-3">Start to monitoring your money!</div>
					</div>
				<?php endif; ?>
				<?php foreach ($uang_rows->result_array() as $uang): ?>
					<div class="mb-3">
						<a href="<?= base_url('index.php/home/moneytor?pocket='.$uang['pocket'].'&uid='.$uang['uang_id']); ?>" title="<?= $uang['nama']; ?>" class="card-link">
							<div class="card bg-primary brad-20 text-white">
								<div class="card-body brad-20 shadow-sm">
									<div class="my-0">
										<div class="mb-3 text-truncate"><?= $uang['nama']; ?></div>
										<div class="float-left">
											<div class="h5"><?= rupiah($uang['jumlah']); ?></div>
										</div>
										<div class="float-right">
											<div><?= $uang['bulan'].'/'.$uang['tahun']; ?></div>
										</div>
									</div>
								</div>
							</div>
						</a>
						<div class="form-row text-center mt--20 text-white">
							<div class="col">
								<a href="#" class="btn btn-success btn-sm brad-20 shadow-sm" data-toggle="modal" data-target="#income<?= $uang['uang_id']; ?>">
									<i class="fa fa-plus"></i> Income
								</a>
							</div>
							<div class="col">
								<?php if($uang['jumlah'] != 0): ?>
									<a href="#" class="btn btn-danger btn-sm brad-20 shadow-sm" data-toggle="modal" data-target="#spending<?= $uang['uang_id']; ?>" disabled="disabled">
										<i class="fa fa-minus"></i> Spending
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="modal" id="income<?= $uang['uang_id']; ?>" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<?= form_open('index.php/home/income'); ?>
									<div class="modal-header">
										<span class="modal-title text-truncate">Income <?= $uang['nama']; ?></span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="uang_id" value="<?= $uang['uang_id']; ?>">
										<input type="text" name="nama" value="" placeholder="Income name" class="form-control brad-20 mb-3">
										<input type="text" name="jumlah" value="0" placeholder="0" class="form-control brad-20 mb-3 uang">
									</div>
									<div class="modal-footer p-2">
										<button name="income" class="btn btn-primary btn-sm brad-20">Save changes</button>
									</div>
								<?= form_close(); ?>
							</div>
						</div>
					</div>
					<div class="modal" id="spending<?= $uang['uang_id']; ?>" tabindex="-1" role="dialog">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<?= form_open('index.php/home/spending'); ?>
									<div class="modal-header">
										<span class="modal-title text-truncate">Spending <?= $uang['nama']; ?></span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<input type="hidden" name="uang_id" value="<?= $uang['uang_id']; ?>">
										<input type="hidden" name="uang" value="<?= $uang['jumlah']; ?>">
										<select name="kategori_id" class="custom-select form-control mb-3 brad-20">
											<?php foreach ($kategori_rows->result_array() as $kategori): ?>
												<option value="<?= $kategori['kategori_id']; ?>"><?= $kategori['nama']; ?></option>
											<?php endforeach; ?>
										</select>
										<input type="text" name="nama" placeholder="Spending Name" class="form-control mb-3 brad-20" autofocus="on">
										<input type="text" name="jumlah" value="0" placeholder="0" class="form-control brad-20 uang" autofocus="on">
									</div>
									<div class="modal-footer p-2">
										<button name="spending" class="btn btn-primary btn-sm brad-20">Save changes</button>
									</div>
								<?= form_close(); ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
</div>
<div class="mb-4">&nbsp;</div>

<div class="fixed-bottom mb-3">
	<div class="container">
		<div class="d-flex justify-content-center form-row">
			<div class="col-lg-4 post-outer">
				<div class="card shadow-sm brad-20">
					<div class="card-body shadow-sm brad-20 p-2">
						<div class="my-1 text-center">
							<div class="form-row">
								<div class="col">
									<a href="#" data-toggle="modal" data-target="#kategori" class="card-link text-dark">
										<i class="fa fa-tags"></i>
										<div class="small">Category</div>
									</a>
								</div>
								<div class="col mt--33">
									<a href="#" title="Add Moneytor" data-toggle="modal" data-target="#modal" class="card-link bg-white btn-primary btn-circle btn-lg shadow-add">
										<i class="fa fa-plus-circle text-primary fa-2x"></i>
									</a>
									<div class="small">Moneytor</div>
								</div>
								<div class="col">
									<a href="<?= base_url('index.php/account'); ?>" class="card-link text-dark">
										<i class="fa fa-user"></i>
										<div class="small">Accounts</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="kategori" tabindex="-1" role="dialog" aria-labelledby="kategori_label" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<span class="modal-title" id="kategori_label">Spending Categories</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="form-row text-center">
					<?php foreach ($kategori_rows->result_array() as $kategori): ?>
						<div class="col-4 my-1">
							<button class="btn btn-circle bg-primary">
								<?= '<i class="'.$kategori['icon'].' text-white"></i>'; ?>
							</button>
							<p class="text-truncate"><?= $kategori['nama']; ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<?= form_open('index.php/home', ''); ?>
			<?= validation_errors('<script>swal({title: "Warning", text: "', '", timer: 10000, icon: "warning", button: false});</script>'); ?>
			<div class="modal-header">
				<span class="modal-title">Add Moneytor</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body my-2">
				<input type="text" name="nama" value="" placeholder="Budget Name" class="form-control brad-20 mb-4" autofocus="on">
				<input type="text" name="jumlah" value="0" placeholder="0" class="form-control brad-20 mb-3 uang" autofocus="on">
				<div class="text-center mb-4">
					<a class="card-link" data-toggle="collapse" href="#advance" role="button" aria-expanded="false" aria-controls="advance">
						Show advanced
					</a>
				</div>
				<div class="collapse" id="advance">
					<div class="form-row">
						<div class="col">
							<select name="bulan" class="custom-select form-control brad-20 mb-4">
								<option value="01"<?php if(date('m') == 01) echo ' selected'; ?>>January</option>
								<option value="02"<?php if(date('m') == 02) echo ' selected'; ?>>February</option>
								<option value="03"<?php if(date('m') == 03) echo ' selected'; ?>>March</option>
								<option value="04"<?php if(date('m') == 04) echo ' selected'; ?>>April</option>
								<option value="05"<?php if(date('m') == 05) echo ' selected'; ?>>May</option>
								<option value="06"<?php if(date('m') == 06) echo ' selected'; ?>>June</option>
								<option value="07"<?php if(date('m') == 07) echo ' selected'; ?>>July</option>
								<option value="08"<?php if(date('m') == 08) echo ' selected'; ?>>August</option>
								<option value="09"<?php if(date('m') == 09) echo ' selected'; ?>>September</option>
								<option value="10"<?php if(date('m') == 10) echo ' selected'; ?>>October</option>
								<option value="11"<?php if(date('m') == 11) echo ' selected'; ?>>November</option>
								<option value="12"<?php if(date('m') == 12) echo ' selected'; ?>>December</option>
							</select>
						</div>
						<div class="col">
							<input type="number" name="tahun" value="<?= date('Y'); ?>" placeholder="Year" class="form-control brad-20 mb-4 bg-white" readonly>
						</div>
					</div>
				</div>
				<button name="submit" class="btn btn-primary btn-block brad-20">Save money</button>
			</div>
			<?= form_close(); ?>

		</div>
	</div>
</div>