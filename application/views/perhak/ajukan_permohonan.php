<?php
    $nama_pemohon = isset($this->session->name)?($this->session->name):"";
?>


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
					<h4 class="card-title mg-b-2 mt-2">Ajukan Permohonan</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
			<div class="card-body">
                <div class="pd-30 pd-sm-40 bg-gray-200">
                    <form id="submit">

                        <div class="form-group">
                            <label for="pengajuan">Pengajuan</label>
                            <textarea class="form-control" id="pengajuan" rows="3" name="pengajuan" required></textarea>
                        </div>

                        <!-- NIK -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">Nama Pemohon</label> <small class="text-danger">otomatis</small>
                                    <input type="text" name="nama_display" class="form-control" value="<?=$nama_pemohon?>" disabled>
                                    <input type="hidden" name="nama_pemohon" value="<?=$nama_pemohon?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nama">NIK</label>
                                    <input type="number" name="nik" class="form-control" min="16" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="ktp">Upload KTP</label>
                                <input class="form-control" type="file" name="ktp" required>
                            </div>
                        </div>
                        <!-- /.NIK -->
                        

                        <!-- IMB -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">No IMB</label>
                                    <input type="number" name="no_imb" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="ktp">Upload IMB</label>
                                <input class="form-control" type="file" name="dok_imb" required>
                            </div>
                        </div>
                        <!-- /.IMB -->


                        <!-- SPPT -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">No SPPT</label>
                                    <input type="number" name="no_sppt" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="ktp">Upload SPPT</label>
                                <input class="form-control" type="file" name="dok_sppt" required>
                            </div>
                        </div>
                        <!-- /.SPPT -->
                      

                        <!-- SPPT -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">No Sertifikat</label>
                                    <input type="number" name="no_sertifikat" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="ktp">Upload Sertifikat</label>
                                <input class="form-control" type="file" name="dok_sertifikat" required>
                            </div>
                        </div>
                        <!-- /.SPPT -->
                        

                        <div class="form-group">
                            <label for="alamat">Alamat Tanah</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="luas_tanah">Luas Tanah (㎡)</label>
                                    <input type="number" name="luas_tanah" class="form-control" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="no_berkas">No Berkas</label> <small class="text-danger">otomatis</small>
                                    <input type="text" name="no_berkas_display" class="form-control" disabled>
                                    <input type="hidden" name="no_berkas">
                                </div>
                            </div>
                        </div>
                
                        <div>
                            <button class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5" type="submit" id="upload">Ajukan</button>
                    </form>
                            <button class="btn btn-dark pd-x-30 mg-t-5">Clear</button>
                        </div>
                </div>
			</div>
		</div>
	</div>
	<!--/div-->
</div>
<!-- row opened -->


<script>
    get_no_berkas();

    function get_no_berkas(){
        $.ajax({
            url: '<?= base_url() ?>perhak/get_no_berkas',
            type: 'POST',
            datType: 'JSON',
            success: function(res){
                let no = res;
                let no_berkas_selanjutnya = no.replace(/"/gm,'');
                $('[name="no_berkas_display"]').val(no_berkas_selanjutnya);
                $('[name="no_berkas"]').val(no_berkas_selanjutnya);
            }
        });
    }

$(document).ready(function(){
    $('#submit').submit(function(e){
        e.preventDefault();

        $.ajax({
            url: '<?=base_url()?>perhak/simpan_pengajuan',
            type: 'POST',
            data: new FormData(this),
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function(data){
                alert('Permohonan berhasil di kirim.');
                $('[name="pengajuan"]').val('');
                $('[name="nama_pemohon"]').val('');
                $('[name="nik"]').val('');
                $('[name="ktp"]').val('');
                $('[name="no_imb"]').val('');
                $('[name="dok_imb"]').val('');
                $('[name="no_sppt"]').val('');
                $('[name="dok_sppt"]').val('');
                $('[name="no_sertifikat"]').val('');
                $('[name="dok_sertifikat"]').val('');
                $('[name="alamat"]').val('');
                $('[name="luas_tanah"]').val('');
                $('[name="no_berkas"]').val('');
                get_no_berkas();
            }
        })
    })
    
})


</script>