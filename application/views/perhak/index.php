<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Hi, welcome back!</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Tables</a></li>
				<li class="breadcrumb-item active" aria-current="page"> Data Tables</li>
			</ol>
		</nav>
	</div>
	<div class="d-flex my-auto">
	</div>
</div>
<!-- /breadcrumb -->

<!-- row opened -->
<div class="row row-sm">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mg-b-2 mt-2">SIMPLE TABLE</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table text-md-nowrap" id="table">
						<thead>
							<tr>
								<th>No</th>
								<th class="wd-15p border-bottom-0">Nama Pemohon</th>
								<th class="wd-15p border-bottom-0">Pengajuan</th>
								<th class="wd-15p border-bottom-0">No Berkas</th>
								<th class="wd-25p border-bottom-0">Aksi</th>
								<th class="wd-25p border-bottom-0">Status</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--/div-->
</div>
<!-- row opened -->



<!-- datatable -->
<?php if($this->session->role_id == 1): ?>
<script>
	var table;
	$(document).ready(function(){
		table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url" : "<?=base_url()?>perhak/data_pemohon",
				"type" : "POST"
			},

			"columnDefs": [
				{"targets" : [0], "orderable" : false,},
				{"targets" : [5], "className" : "text-center",},
			],
		});

	});
</script>
<?php else : ?>
<script>
	var table;
	$(document).ready(function(){
		table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url" : "<?=base_url()?>perhak/data_pemohon_kasubsi",
				"type" : "POST"
			},

			"columnDefs": [
				{"targets" : [0], "orderable" : false,},
				{"targets" : [5], "className" : "text-center",},
			],
		});

	});
</script>
<?php endif; ?>

<script>
	function reload_datatable(){
		table.ajax.reload();
	}

	function tolak(id){
		var id = id;
		var keterangan = $('[name="keterangan"]').val();

		$.ajax({
			url : '<?=base_url()?>perhak/lihat/'+id,
			type: "POST",
			dataType: "JSON",
			success: function(data){
				$('[name="id_tolak"]').val(id);
				$('#modal-tolak').modal('show');
			}
		})
	}

	function tolak_temu(){
		var id_pemohon = $('[name="id_tolak"]').val();
		var keterangan = $('[name="keterangan"]').val();

		$.ajax({
			url : '<?=base_url()?>perhak/tolak_temu',
			type: "POST",
			dataType: "JSON",
			data: {id_pemohon: id_pemohon, keterangan: keterangan},
			success: function(data){
				reload_datatable();
				$('#modal-tolak').modal('hide');
			}
		})
	}

	function lihat(id){
		var id = id;
		$.ajax({
			url : '<?=base_url()?>perhak/lihat/'+id,
			type: "POST",
			dataType: "JSON",
			success: function(data){
				$('.pengajuan').text(data.pengajuan);
				$('[name="id"]').val(data.id_pemohon);
				$('[name="nik"]').text(data.nik);
				$('[name="nama_pemohon"]').text(data.nama_pemohon);
				$('[name="no_berkas"]').text(data.no_berkas);
				$('[name="luas_tanah"]').text(data.luas_tanah);
				$('[name="alamat_tanah"]').text(data.alamat_tanah);
				$('[name="no_imb"]').text(data.no_imb);
				$('[name="no_sppt"]').text(data.no_sppt);
				$('[name="no_sertifikat"]').text(data.no_sertifikat);
				$('#modal').modal('show');
			}
		})
	}

	function to_approve(id){
		$.ajax({
			url: '<?=base_url()?>perhak/lihat/'+id,
			type: 'POST',
			dataType: 'JSON',
			success: function(data){
				$('#modal-booking').modal('show');
				$('[name="id_pemohon_hak"]').val(data.id_pemohon);
			}
		})
	}

	function approve(id){
		var konfirmasi = confirm("Anda akan approve permohonan ini ?");

		if(konfirmasi){
			$.ajax({
				url: '<?=base_url()?>perhak/approve',
				data: {id_pemohon: id},
				type: 'POST',
				dataType: 'JSON',
				success: function(res){
					$('#modal-approve').modal('show');
					reload_datatable();
				}
			})
		}
	}
	
	function booking_no_hak(){
		var id = $('[name="id_pemohon_hak"]').val();

		$.ajax({
			url: '<?=base_url()?>perhak/booking_no_hak',
			data: {id_pemohon: id},
			type: 'POST',
			dataType: 'JSON',
			success: function(data){
				$('#no_hak').text(data);
				$('[name="no_hak_value"]').val(data);
				$('.btn-booking').hide();
				$('.btn-save-booking').show();
			}
		})
	}

	function save_no_hak(){
		var id = $('[name="id_pemohon_hak"]').val();
		var no_hak = $('[name="no_hak_value"]').val();

		$.ajax({
			url: '<?=base_url()?>perhak/save_no_hak',
			data: {id_pemohon: id, no_hak: no_hak},
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				$('#modal-booking').modal('hide');
				$('.btn-booking').show();
				$('.btn-save-booking').hide();
				reload_datatable();
			}
		})
	}
	
	function unduh_ktp(){
		var id = $('[name="id"]').val();
		window.location.href = '<?=base_url()?>perhak/unduh_ktp/'+id;
	}
	function unduh_sppt(){
		var id = $('[name="id"]').val();
		window.location.href = '<?=base_url()?>perhak/unduh_sppt/'+id;
	}
	function unduh_imb(){
		var id = $('[name="id"]').val();
		window.location.href = '<?=base_url()?>perhak/unduh_imb/'+id;
	}
	function unduh_sertifikat(){
		var id = $('[name="id"]').val();
		window.location.href = '<?=base_url()?>perhak/unduh_sertifikat/'+id;
	}
	function cek_pembayaran(id){
		$.ajax({
			url: '<?=base_url()?>perhak/cek_pembayaran',
			data: {id_pemohon: id,},
			type: 'POST',
			dataType: 'JSON',
			success: function(res){
				$('[name="id_bukti"]').val(res.id_bukti);
				$('#name').text(res.nama_pemilik_tabungan);
				$('#bank').text('Bank : ' + res.nama_bank);
				$('#nominal').text('Nominal : Rp. ' + formatRupiah(res.nominal));
				$('#bukti_bayar').attr('src', '<?=base_url()?>upload/bukti_bayar/' + res.bukti_bayar);
				$('#modal-cek_bayar').modal('show');
				reload_datatable();
			}
		})
	}

	function formatRupiah(angka, prefix){
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}

	function setuju_bayar(){
        var id = $('[name="id_bukti"]').val();
        var konfirmasi = confirm("Anda menyetujui pembayaran ini ?");

        if(konfirmasi){
            $.ajax({
                url: '<?=base_url()?>perhak/setuju_bayar',
                type: 'POST',
                data: {id_bayar: id},
                dataType: 'JSON',
                success: function(res){
                    $('#modal-cek_bayar').modal('hide');
                    alert('Pembayaran di setujui');
                    reload_datatable();
                }
            })
        }
    }
</script>


<div class="modal" id="modal">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan"></h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-6">
						<input type="hidden" name="id">
						<table class="table table-bordered mg-b-0 text-md-nowrap">
							<tr>
								<td>NIK</td>
								<td> : </td>
								<td><b name="nik"></b></td>
							</tr>
							<tr>
								<td>KTP</td>
								<td> : </td>
								<td><b name="ktp"></b> <a href="javascript:unduh_ktp()" class=" btn btn-sm btn-success"><i class="fas fa-arrow-down"></i> Unduh</a></td>
							</tr>
							<tr>
								<td>Nama Pemohon</td>
								<td> : </td>
								<td><b name="nama_pemohon"></b></td>
							</tr>
							<tr>
								<td>Nomor Berkas</td>
								<td> : </td>
								<td><b name="no_berkas"></b></td>
							</tr>
							<tr>
								<td>No Sertifikat</td>
								<td> : </td>
								<td><b name="no_sertifikat"></b></td>
							</tr>
							<tr>
								<td>Dok Sertifikat</td>
								<td> : </td>
								<td><b name="ktp"></b> <a href="javascript:unduh_sertifikat()" class=" btn btn-sm btn-success"><i class="fas fa-arrow-down"></i> Unduh</a></td>
							</tr>
						</table>
					</div>
					<div class="col-6">
						<table class="table table-bordered mg-b-0 text-md-nowrap">
							<tr>
								<td>Luas Tanah</td>
								<td> : </td>
								<td><b name="luas_tanah"></b> ㎡</td>
							</tr>
							<tr>
								<td>Alamat Tanah</td>
								<td> : </td>
								<td><b name="alamat_tanah"></b></td>
							</tr>
							<tr>
								<td>No IMB</td>
								<td> : </td>
								<td><b name="no_imb"></b></td>
							</tr>
							<tr>
								<td>Dok IMB</td>
								<td> : </td>
								<td><b name="ktp"></b> <a href="javascript:unduh_imb()" class=" btn btn-sm btn-success"><i class="fas fa-arrow-down"></i> Unduh</a></td>
							</tr>
							<tr>
								<td>No SPPT</td>
								<td> : </td>
								<td><b name="no_sppt"></b></td>
							</tr>
							<tr>
								<td>Dok SPPT</td>
								<td> : </td>
								<td><b name="ktp"></b> <a href="javascript:unduh_sppt()" class=" btn btn-sm btn-success"><i class="fas fa-arrow-down"></i> Unduh</a></td>
							</tr>
							
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-tolak">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Tolak Permintaan</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<input type="hidden" name="id_tolak">
						<div class="form-group">
							<label for="">Keterangan</label>
							<textarea name="keterangan" class="form-control" id="" cols="30" rows="10"></textarea>
						</div>
						<div class="text-right">
							<button class="btn btn-danger" onclick="tolak_temu()">Tolak</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-booking">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Booking No Hak</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<input type="hidden" name="id_pemohon_hak">
						<div class="text-center">
							<h2 id="no_hak"></h2>
							<input type="hidden" name="no_hak_value">
						</div>
						<div class="text-center mt-3">
							<button class="btn btn-primary btn-booking" onclick="booking_no_hak()">Booking Now</button>
							<button class="btn btn-primary btn-save-booking" onclick="save_no_hak()" style="display: none">Simpan</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-cek_bayar">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Cek Pembayaran</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<input type="hidden" name="id_bukti">
						<p>Pemohon <b id="name"></b> telah melakukan pembayaran.</p>
						<br>
						<table class="table">
							<tr>
								<td id="bank"></td>
							</tr>
							<tr>
								<td id="nominal"></td>
							</tr>
							<tr>
								<td>Bukti pembayaran :</td>
							</tr>
							<tr>
								<td class="text-center">
									<img id="bukti_bayar" width="200">
								</td>
							</tr>
						</table>
						<div class="text-right">
							<button class="btn btn-primary" onclick="setuju_bayar()">Approve</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>