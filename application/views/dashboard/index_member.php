<div class="card overflow-hidden">
    <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-10">Member Nih</h4>
            <i class="mdi mdi-dots-horizontal text-gray"></i>
        </div>
    </div>
    <div class="card-body pd-y-7">
        <table class="table text-md-nowrap" id="table">
            <thead>
                <tr>
                    <th class="wd-15p border-bottom-0">No</th>
                    <th class="wd-15p border-bottom-0">Pengajuan</th>
                    <th class="wd-15p border-bottom-0">Status</th>
                    <th class="wd-15p border-bottom-0">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<script>
    var table;
	$(document).ready(function(){
		table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url" : "<?=base_url()?>perhak/get_pengajuan",
				"type" : "POST"
			},

			"columnDefs": [
				{"targets" : [0], "orderable" : false,},
				// {"targets" : 3, "width" : "10%",},
			],
		});

	});
	
	function reload_datatable(){
		table.ajax.reload();
	}
	
    function edit(id){
        $.ajax({
			url : '<?=base_url()?>perhak/edit_permohonan/'+id,
			type: "POST",
			dataType: "JSON",
            data: {id_pemohon: id},
			success: function(data){
				$('[name="id_pemohon"]').val(data.id_pemohon);
				$('[name="pengajuan"]').val(data.pengajuan);
				$('[name="nama_pemohon_display"]').val(data.nama_pemohon);
				$('[name="nama_pemohon"]').val(data.nama_pemohon);
				$('[name="nik"]').val(data.nik);
				$('[name="ktp_lama"]').val(data.ktp);
				$('[name="ktp_hide"]').val(data.ktp);
				$('[name="luas_tanah"]').val(data.luas_tanah);
				$('[name="alamat"]').val(data.alamat_tanah);
				$('[name="no_imb"]').val(data.no_imb);
				$('[name="imb_lama"]').val(data.dok_imb);
				$('[name="imb_hide"]').val(data.dok_imb);
				$('[name="no_sppt"]').val(data.no_sppt);
				$('[name="sppt_lama"]').val(data.dok_sppt);
				$('[name="sppt_hide"]').val(data.dok_sppt);
				$('[name="no_sertifikat"]').val(data.no_sertifikat);
				$('[name="sertifikat_lama"]').val(data.dok_sertifikat);
				$('[name="sertifikat_hide"]').val(data.dok_sertifikat);
				$('[name="no_berkas"]').val(data.no_berkas);
				$('[name="no_berkas_display"]').val(data.no_berkas);
				$('#modal').modal('show');
			}
		})
    }

    function hapus_pengajuan(id){
		var konfirmasi = confirm("Anda yakin menghapus pengajuan ini ?");

		if(konfirmasi){
			$.ajax({
				url: '<?=base_url()?>perhak/hapus_pengajuan',
				type: 'post',
				dataType: 'json',
				data: {id_pemohon: id},
				success: function(res){
					$('#modal').modal('hide');
					alert('Berhasil menghapus.');
					table.ajax.reload();
				}
			})
		}

    }

	function update(){
		var form = $('#submit')[0];

		$.ajax({
			url: '<?=base_url()?>perhak/update_pengajuan',
			type: 'POST',
			data: new FormData(form),
			cache: false,
			processData: false,
			dataType: 'json',
			contentType: false,
			success: function(data){
				$('#modal').modal('hide');
				alert('Permohonan berhasil di update.');
				table.ajax.reload();
				$('#submit')[0].reset();
			}
		})
	}

	

    function ketpendingg(){
		

		$.ajax({
			type: "POST",
			success: function(data){
                $('#modal-keteranganpending').modal('show');
				$('#ketpending').text(data['keterangan']);
			}
		})
	}

    function ket(id){
		var id = id;

		$.ajax({
			url : '<?=base_url()?>perhak/get_keterangan',
			type: "POST",
			dataType: "JSON",
			data: {id_pemohon: id},
			success: function(data){
                $('#modal-keterangan').modal('show');
				$('#ket').text(data['keterangan']);
			}
		})
	}

    function pembayaran(id){
        $.ajax({
            url: '<?=base_url()?>perhak/get_data_to_bayar',
            type: 'POST',
            data: {id_pemohon: id},
            dataType: 'json',
            success: function(data){
                $('[name="id_pemohon"]').val(data['id_pemohon']);
                $('[name="no_berkas_display"]').val(data['no_berkas']);
                $('[name="no_berkas"]').val(data['no_berkas']);
                $('#modal-pembayaran').modal('show');
            }
        })
    }


// function edit(id){
//         $.ajax({
// 			url : '<?=base_url()?>perhak/edit_permohonan/'+id,
// 			type: "POST",
// 			dataType: "JSON",
//             data: {id_pemohon: id},
// 			success: function(data){
// 				$('[name="id_pemohon"]').val(data.id_pemohon);
// 				$('[name="pengajuan"]').val(data.pengajuan);
// 				$('[name="nama_pemohon_display"]').val(data.nama_pemohon);
// 				$('[name="nama_pemohon"]').val(data.nama_pemohon);
// 				$('[name="nik"]').val(data.nik);
// 				$('[name="ktp_lama"]').val(data.ktp);
// 				$('[name="ktp_hide"]').val(data.ktp);
// 				$('[name="luas_tanah"]').val(data.luas_tanah);
// 				$('[name="alamat"]').val(data.alamat_tanah);
// 				$('[name="no_imb"]').val(data.no_imb);
// 				$('[name="imb_lama"]').val(data.dok_imb);
// 				$('[name="imb_hide"]').val(data.dok_imb);
// 				$('[name="no_sppt"]').val(data.no_sppt);
// 				$('[name="sppt_lama"]').val(data.dok_sppt);
// 				$('[name="sppt_hide"]').val(data.dok_sppt);
// 				$('[name="no_sertifikat"]').val(data.no_sertifikat);
// 				$('[name="sertifikat_lama"]').val(data.dok_sertifikat);
// 				$('[name="sertifikat_hide"]').val(data.dok_sertifikat);
// 				$('[name="no_berkas"]').val(data.no_berkas);
// 				$('[name="no_berkas_display"]').val(data.no_berkas);
// 				$('#modal').modal('show');
// 			}
// 		})
//     }


    function pembayaranedit(id){

        $.ajax({
            url: '<?=base_url()?>perhak/edit_pembayaran/'+id,
            type: 'POST',
            dataType: 'JSON',
            data: {id_pemohon: id},
            success: function(data){
                $('[name="id_pemohon"]').val(data.id_pemohon);
                $('[name="id_bukti"]').val(data.id_bukti);
                $('[name="bukti_bayar"]').val(data.bukti_bayar);
                $('[name="nominal"]').val(data.nominal);
                $('[name="nama_pemilik_tabungan"]').val(data.nama_pemilik_tabungan);
                $('[name="nama_bank"]').val(data.nama_bank);
                $('[name="no_berkas"]').val(data.no_berkas);
                $('#modalpembayaran').modal('show');
            }
        })
    }

    function updatepembayaran(){
        var update = $('#submit')[0];

		$.ajax({
			url: '<?=base_url()?>perhak/pembayaranupdate',
			type: 'POST',
			data: new FormData(update),
			cache: false,
			processData: false,
			dataType: 'json',
			contentType: false,
			success: function(data){
				$('#modalpembayaran').modal('hide');
				alert('pembayaran berhasil di kirim.');
				table.ajax.reload();
				$('#submit')[0].reset();
			}
		})
	}

    function bayar(){
        var postData = new FormData($("#bayar")[0]);

        $.ajax({
            url: '<?=base_url()?>perhak/simpan_bayar',
            type: 'POST',
            data: postData,
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function(data){
                $('#modal-pembayaran').modal('hide');
                alert('Pembayaran berhasil di upload.');
                reload_datatable();
            }
        })
        
    }
		
</script>


<div class="modal" id="modal">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Pengajuan yang anda kirim</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form id="submit" action="javascript:update()">
					<input type="hidden" name="id_pemohon">

                        <div class="form-group">
                            <label for="pengajuan">Pengajuan</label>
                            <textarea class="form-control" id="pengajuan" rows="3" name="pengajuan" required></textarea>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">Nama Pemohon</label> <small class="text-danger">otomatis</small>
                                    <input type="text" name="nama_pemohon_display" class="form-control" disabled>
                                    <input type="hidden" name="nama_pemohon">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="luas_tanah">Luas Tanah (㎡)</label>
                                    <input type="number" name="luas_tanah" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="no_berkas">No Berkas</label> <small class="text-danger">otomatis</small>
                                    <input type="text" name="no_berkas_display" class="form-control" disabled>
                                    <input type="hidden" name="no_berkas">
                                </div>
                            </div>
                        </div>

                        <!-- NIK -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">NIK</label>
                                    <input type="number" name="nik" class="form-control" min="16" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">Dok KTP</label>
                                    <input type="text" name="ktp_hide" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ktp">Upload KTP</label> <small class="text-danger">kosongkan jika tidak upload file baru</small>
                                <input class="form-control" type="file" name="ktp">
								<input type="hidden" name="ktp_lama">
                            </div>
                        </div>
                        <!-- /.NIK -->
                        

                        <!-- IMB -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">No IMB</label>
                                    <input type="number" name="no_imb" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Dok IMB</label>
                                <input type="text" class="form-control" name="imb_hide" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="ktp">Upload IMB</label> <small class="text-danger">kosongkan jika tidak upload file baru</small>
                                <input class="form-control" type="file" name="dok_imb">
								<input type="hidden" name="imb_lama">
                            </div>
                        </div>
                        <!-- /.IMB -->


                        <!-- SPPT -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">No SPPT</label>
                                    <input type="number" name="no_sppt" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Dok SPPT</label>
                                <input type="text" class="form-control" name="sppt_hide" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="ktp">Upload SPPT</label> <small class="text-danger">kosongkan jika tidak upload file baru</small>
                                <input class="form-control" type="file" name="dok_sppt">
								<input type="hidden" name="sppt_lama">
                            </div>
                        </div>
                        <!-- /.SPPT -->
                      

                        <!-- SPPT -->
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">No Sertifikat</label>
                                    <input type="number" name="no_sertifikat" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Dok Sertifikat</label>
                                <input type="text" class="form-control" name="sertifikat_hide" disabled>
                            </div>
                            <div class="col-md-4">
                                <label for="ktp">Upload Sertifikat</label> <small class="text-danger">kosongkan jika tidak upload file baru</small>
                                <input class="form-control" type="file" name="dok_sertifikat">
								<input type="hidden" name="sertifikat_lama">
                            </div>
                        </div>
                        <!-- /.SPPT -->
                        

                        <div class="form-group mt-3">
                            <label for="alamat">Alamat Tanah</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>

					<div class="text-right">
						<button class="btn ripple btn-main-primary pd-x-30 mg-r-5 mg-t-5" type="submit" id="update">Update</button>
					</div>
				</form>
			</div>
			<!-- <div class="modal-footer">
				<button class="btn ripple btn-danger" onclick="hapus_pengajuan()">Hapus Pengajuan</button>
			</div> -->
		</div>
	</div>
</div>

<div class="modal" id="modal-keteranganpending">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Keterangan</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<p id="ketpending">Pembayaran di pending karena kurang biaya atau salah upload bukti pembayaran. Silahkan Upload pembayaran kembali.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-keterangan">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Keterangan</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<p id="ket"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-pembayaran">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Pembayaran</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
                    <div class="col-6">
                        <table class="table table-bordered">
                            <tr>
                                <td class="bg-secondary text-white text-center">
                                    <h5>Nominal yg harus dibayar</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h3 class="text-center">Rp. 1.000.000</h3>
                                </td>
                            </tr>
                        </table>
                        <br>
                        <table class="table table-bordered">
                            <tr>
                                <td class="bg-secondary text-white text-center">
                                    <h5>No Rek Kantor Pertanahan</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>BCA - 1273191281321</h5>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h5>Mandiri - 941248151913212301</h5>
                                </td>
                            </tr>
                        </table>
                    </div>
					<div class="col-6">
                        <form id="bayar" enctype="multipart/form-data" type="POST" action="javascript:bayar()">
                            <input type="hidden" name="id_pemohon">
                            <div class="form-group">
                                <label for="">No Berkas</label>
                                <input type="text" name="no_berkas_display" class="form-control" disabled>
                                <input type="hidden" name="no_berkas">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Bank</label>
                                <input type="text" name="nama_bank" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Nama Pemilik Tabungan</label>
                                <input type="text" name="nama_pemilik_tabungan" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Nominal</label>
                                <input type="number" name="nominal" class="form-control" min="0">
                            </div>
                            <div class="form-group">
                                <label for="">Upload Bukti Pembayaran</label>
                                <input type="file" name="bukti_pembayaran" class="form-control">
                            </div>
                            <div class="form-group text-right">
                                <button class="btn btn-primary" type="submit" id="upload">Kirim</button>
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modalpembayaran">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Edit Pembayaran</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form id="submit" action="javascript:updatepembayaran()">
				    <div class="row">
					    <div class="col-12">
                               
                                <input type="hidden" name="id_pemohon">
                                <input type="hidden" name="id_bayar">
                                <div class="form-group">
                                    <label for="no_berkas">No berkas</label>
                                    <input class="form-control" id="no_berkas" rows="3" name="no_berkas" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="nama_bank">Nama Bank</label>
                                    <input class="form-control" id="nama_bank" rows="3" name="nama_bank" value="nama_bank">
                                </div>
                                <div class="form-group">
                                    <label for="nama_pemilik_tabungan">Nama Pemilik Tabungan</label>
                                    <input class="form-control" id="nama_pemilik_tabungan" rows="3" name="nama_pemilik_tabungan" value="nama_pemilik_tabungan">
                                </div>
                                <div class="form-group">
                                    <label for="nominal">Nama Pemilik Tabungan</label>
                                    <input class="form-control" id="nominal" rows="3" name="nominal" value="nominal">
                                </div>
                                <div class="form-group">
                                    <label for="buktibayar_baru">Nama Pemilik Tabungan</label>
                                    <input type="file" class="form-control" id="buktibayar_baru" rows="3" name="buktibayar_baru" >
                                    <input type="hidden" name="bukti_bayar">
                                </div>
                            <div class="text-right mt-3">
                                <button class="btn ripple btn-main-primary pd-x-30 mg-r-5 mg-t-5" type="submit" id="update">Update</button>
                                <!-- <button class="btn btn-danger" onclick="tolak_bayar()">Tolak</button> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
		</div>
	</div>
</div>





