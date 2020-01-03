<?php
if ($this->session->flashdata('info')) echo $this->session->flashdata('info');
?>
<div class="mt-3 container">
	<div class="d-flex justify-content-center form-row">
		<div class="col-lg-4 post-outer">
			<div class="mb-3 text-dark">
				<div class="float-left mr-3">
					<?php if($this->session->has_userdata('user_id')): ?>
						<a href="<?= base_url('index.php/home'); ?>" title="Back" class="card-link">
							<i class="fa fa-arrow-left"></i>
						</a>
					<?php endif; ?>
					<?php if(!$this->session->has_userdata('user_id')): ?>
						<a href="<?= base_url(); ?>" title="Home" class="card-link">
							<i class="fa fa-home"></i>
						</a>
					<?php endif; ?>
				</div>
				<div class="float-right ml-2">
					<?php if($this->session->has_userdata('user_id')): ?>
						<?= form_open('index.php/home/hapus_moneytor'); ?>
						<input type="hidden" name="uang_id" value="<?= $pocket['uang_id']; ?>">
						<input type="hidden" name="pocket" value="<?= $pocket['pocket']; ?>">
						<button name="hapus" class="btn btn-sm p-0 pb-2">
							<i class="fa fa-trash text-danger"></i>
						</button>
						<?= form_close(); ?>
					<?php endif; ?>
					<?php if(!$this->session->has_userdata('user_id')): ?>
						<a href="#" title="Info" class="card-link" data-toggle="modal" data-target="#infoModal">
							<i class="fa fa-info-circle"></i>
						</a>
					<?php endif; ?>
				</div>
				<div class="text-center font-weight-bold font-weight-light text-truncate">
					<?= $pocket['nama']; ?>
				</div>
			</div>
			<hr>
			<div class="card bg-primary brad-20 text-white">
				<div class="card-body brad-20">
					<div class="my-0">
						<div class="mb-3 text-truncate"><?= $pocket['nama']; ?></div>
						<div class="float-left">
							<div class="h5"><?= rupiah($pocket['jumlah']); ?></div>
						</div>
						<div class="float-right">
							<div><?= $pocket['bulan'].'/'.$pocket['tahun']; ?></div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-row text-center mt--20 text-white">
				<div class="col">
					<span class="btn btn-success btn-sm brad-20 shadow-sm">
						<i class="fa fa-plus"></i> <?= rupiah($income_sum['jumlah']); ?>
					</span>
				</div>
				<div class="col">
					<span class="btn btn-danger btn-sm brad-20 shadow-sm">
						<i class="fa fa-minus"></i> <?= rupiah($spending_sum['jumlah']); ?>
					</span>
				</div>
			</div>
			<div class="my-3 text-center">
				<a class="card-link" data-toggle="collapse" href="#qrcode" role="button" aria-expanded="false" aria-controls="qrcode">
					Show QRcode
				</a>
			</div>
			<div class="collapse" id="qrcode">
				<center>
					<div class="row col-6">
						<img src="<?= base_url('assets/.images/qrcode/'.$pocket['qrcode']); ?>" alt="QRcode" class="img-fluid img-thumbnail shadow-sm mb-4">
					</div>
				</center>
			</div>
		</div>
	</div>
</div>

<div class="mb-5">
	<div class="container">
		<div class="d-flex justify-content-center form-row">
			<div class="col-lg-4 post-outer">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item btn-sm">
						<a class="nav-link brad-20 shadow-sm border-btn-tab" id="income-tab" data-toggle="tab" href="#income" role="tab" aria-controls="income" aria-selected="false">Income</a>
					</li>
					<li class="nav-item btn-sm">
						<a class="nav-link brad-20 shadow-sm border-btn-tab active" id="spending-tab" data-toggle="tab" href="#spending" role="tab" aria-controls="spending" aria-selected="true">Spending</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane" id="income" role="tabpanel" aria-labelledby="income-tab">
						<div class="list-group mt-2">
							<?php if ($income_rows->num_rows() < 1): ?>
								<div class="text-center">
									<img src="<?= base_url('assets/.images/empty.png'); ?>" alt="No data" class="img-fluid pt-5 pl-5 pr-5">
								</div>
							<?php endif; ?>
							<?php foreach ($income_rows->result_array() as $income): ?>
								<div class="list-group-item shadow-sm">
									<div class="text-success mb-2">
										<i class="fa fa-plus-circle"></i>
										<?= ucfirst($income['nama']); ?>
										<div class="float-right">
											<?php if($this->session->has_userdata('user_id')): ?>
												<?= form_open('index.php/home/hapus_income'); ?>
												<input type="hidden" name="pocket" value="<?= $pocket['pocket']; ?>">
												<input type="hidden" name="uang_id" value="<?= $pocket['uang_id']; ?>">
												<input type="hidden" name="pemasukan_id" value="<?= $income['pemasukan_id']; ?>">
												<input type="hidden" name="jumlah" value="<?= $income['jumlah']; ?>">
												<button name="hapus" class="btn btn-sm p-0">
													<i class="fa fa-trash text-danger"></i>
												</button>
												<?= form_close(); ?>
											<?php endif; ?>
										</div>
									</div>
									<span class="font-weight-light"><?= date('Y/m/d H:i a', strtotime($income['tanggal'])); ?></span>
									<div class="float-right font-weight-light text-primary">
										+<?= rupiah($income['jumlah']); ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="tab-pane active" id="spending" role="tabpanel" aria-labelledby="spending-tab">
						<div class="list-group mt-2">
							<?php if ($spending_rows->num_rows() < 1): ?>
								<div class="text-center">
									<img src="<?= base_url('assets/.images/empty.png'); ?>" alt="No data" class="img-fluid pt-5 pl-5 pr-5">
								</div>
							<?php endif; ?>
							<?php foreach ($spending_rows->result_array() as $spending): ?>
								<div class="list-group-item shadow-sm" data-toggle="collapse" href="#sp<?= $spending['pengeluaran_id'] ?>" role="button" aria-expanded="false" aria-controls="sp<?= $spending['pengeluaran_id'] ?>">
									<div class="text-success">
										<?= '<i class="'.$spending['icon'].'"></i> '; ?>
										<?= $spending['kategori']; ?>
										<div class="float-right">
											<i class="fa fa-angle-down"></i>
										</div>
									</div>
									<div class="mt-2">
										<span class="text-dark text-truncate">
											<?= ucfirst($spending['nama']); ?>
										</span>
										<div class="float-right font-weight-light text-danger">
											-<?= rupiah($spending['jumlah']); ?>
										</div>
									</div>
									<div class="collapse" id="sp<?= $spending['pengeluaran_id'] ?>">
										<div class="font-weight-light mt-3">
											<?= date('Y/m/d H:i a', strtotime($spending['tanggal'])); ?>
											<div class="float-right">
												<?php if($this->session->has_userdata('user_id')): ?>
													<?= form_open('index.php/home/hapus_spending'); ?>
													<input type="hidden" name="pocket" value="<?= $pocket['pocket']; ?>">
													<input type="hidden" name="uang_id" value="<?= $pocket['uang_id']; ?>">
													<input type="hidden" name="pengeluaran_id" value="<?= $spending['pengeluaran_id']; ?>">
													<input type="hidden" name="jumlah" value="<?= $spending['jumlah']; ?>">
													<button name="hapus" class="btn btn-sm p-0">
														<i class="fa fa-trash text-danger"></i>
													</button>
													<?= form_close(); ?>
												<?php endif; ?>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="mt-5">
	&nbsp;
</div>

<div class="fixed-bottom mb-2">
	<div class="container">
		<div class="d-flex justify-content-center form-row">
			<div class="col-lg-4 post-outer">
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?= $link; ?>" title="Share to Facebook" class="card-link">
					<button class="btn btn-facebook btn-sm brad-20">
						<i class="fab fa-facebook"></i> Facebook
					</button>
				</a>
				<a href="https://api.whatsapp.com/send?text=<?= $title; ?>%0A%0A<?= $link; ?>" title="Share to Facebook" class="card-link">
					<button class="btn btn-success btn-sm brad-20">
						<i class="fab fa-whatsapp"></i> WhatsApp
					</button>
				</a>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="info" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<span class="modal-title" id="info">Information</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				This Moneytoring data was personally created by <?= nama($user_data['nama']); ?>

				<div class="mt-3">
					Create Moneytoring for yourself
					<div class="form-row text-center mt-2">
						<div class="col">
							<a href="<?= base_url(); ?>" title="Login" class="card-link">
								<button class="btn btn-sm btn-outline-primary brad-20 btn-block">Login</button>
							</a>
						</div>
						<div class="col">
							<a href="<?= base_url('index.php/join'); ?>" title="Join Us" class="card-link">
								<button class="btn btn-sm btn-primary brad-20 btn-block">Join Us</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
