<?php
$id_air = "";
$id_kecamatan = "";
$lokasi = "";
$keterangan = "";
$lat = "";
$lng = "";
$tanggal = date('Y-m-d');
if ($parameter == 'ubah' && $id != '') {
	$this->db->where('id_air', $id);
	$row = $this->Model->get()->row_array();
	extract($row);
}
?>
<?= content_open('Form Titik Air') ?>
<form method="post" action="<?= site_url($url . '/simpan') ?>" enctype="multipart/form-data">
	<?= input_hidden('id_air', $id_air) ?>
	<?= input_hidden('parameter', $parameter) ?>
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<label>Lokasi</label>
				<div class="row">
					<div class="col-md-8">
						<?= input_text('lokasi', $lokasi) ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Nama Kecamatan</label>
				<div class="row">
					<div class="col-md-10">
						<?php
						$op[''] = 'Pilih Kecamatan';
						$get = $this->KecamatanModel->get();
						foreach ($get->result() as $row) {
							$op[$row->id_kecamatan] = $row->nm_kecamatan;
						}
						?>
						<?= select('id_kecamatan', $op, $id_kecamatan) ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Keterangan</label>
				<div class="row">
					<div class="col-md-12">
						<?= textarea('keterangan', $keterangan) ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Titik Koordinat</label>
				<div class="row">
					<div class="col-md-6">
						<?= input_text('lat', $lat) ?>
					</div>
					<div class="col-md-6">
						<?= input_text('lng', $lng) ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Tanggal</label>
				<div class="row">
					<div class="col-md-8">
						<?= input_date('tanggal', $tanggal) ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Marker</label>
				<div class="row">
					<div class="col-md-10">
						<?= input_file('marker', '') ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<h3>Pilih Titik</h3>
			<div id="map" style="height: 400px"></div>
		</div>
		<div class="col-md-12">
			<hr>
			<div class="form-group">
				<button type="submit" name="simpan" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
				<a href="<?= site_url($url) ?>" class="btn btn-danger"><i class="fa fa-reply"></i> Kembali</a>
			</div>
		</div>
	</div>

</form>
<?= content_close() ?>