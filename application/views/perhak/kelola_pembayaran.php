<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Kelola Pembayaran</h4>
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
					<h4 class="card-title mg-b-2 mt-2">KELOLA PEMBAYARAN</h4>
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
<script>
    var table;
	$(document).ready(function(){
		table = $('#table').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],

			"ajax": {
				"url" : "<?=base_url()?>perhak/get_kelola_pembayaran",
				"type" : "POST"
			},

			"columnDefs": [
				{"targets" : [0], "orderable" : false,},
				{"targets" : [5], "className" : "text-center",},
			],
		});

	});
	
	function reload_datatable(){
		table.ajax.reload();
	}

    function lihat_bayar(id){
        var id = id;

        $.ajax({
            url: '<?=base_url()?>perhak/lihat_bayar',
            type: 'POST',
            data: {id_bayar: id},
            dataType: 'JSON',
            success: function(data){
                $('[name="id_bayar"]').val(data.id_bukti);
                $('[name="bukti_bayar"]').append('<img src="<?=base_url('upload/bukti_bayar/')?>' + data.bukti_bayar + '" />');
                $('[name="nominal"]').text(data.nominal);
                $('[name="pemilik_tabungan"]').text(data.nama_pemilik_tabungan);
                $('[name="nama_bank"]').text(data.nama_bank);
                $('[name="no_berkas"]').text(data.no_berkas);
                $('#modal-lihat-bayar').modal('show');
            }
        })
    }

    function setuju_bayar(){
        var id = $('[name="id_bayar"]').val();
        var konfirmasi = confirm("Anda menyetujui pembayaran ini ?");

        if(konfirmasi){
            $.ajax({
                url: '<?=base_url()?>perhak/setuju_bayar',
                type: 'POST',
                data: {id_bayar: id},
                dataType: 'JSON',
                success: function(res){
                    $('#modal-lihat-bayar').modal('hide');
                    alert('Pembayaran di setujui');
                    reload_datatable();
                }
            })
        }
    }

    function pending_bayar(){
        var id = $('[name="id_bayar"]').val();
        var konfirmasi = confirm("yakin akan di pending ?");

        if(konfirmasi){
            $.ajax({
                url: '<?=base_url()?>perhak/pending_bayar',
                type: 'POST',
                data: {id_bayar: id},
                dataType: 'JSON',
                success: function(res){
                    $('#modal-lihat-bayar').modal('hide');
                    alert('Pembayaran di Pending');
                    reload_datatable();
                }
            })
        }
    }

    function tolak_bayar(){
        alert();
    }
</script>

<div class="modal" id="modal-lihat-bayar">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Detail Pembayaran</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<table class="table table-bordered mg-b-0 text-md-nowrap">
                            <input type="hidden" name="id_bayar">
							<tr>
								<td>No Berkas</td>
								<td> : </td>
								<td><b name="no_berkas"></b></td>
							</tr>
							<tr>
								<td>Nama Bank</td>
								<td> : </td>
								<td><b name="nama_bank"></b></td>
							</tr>
							<tr>
								<td>Nama Pemilik Tabungan</td>
								<td> : </td>
								<td><b name="pemilik_tabungan"></b></td>
							</tr>
							<tr>
								<td>Nominal</td>
								<td> : </td>
								<td><b name="nominal"></b></td>
							</tr>
							<tr>
								<td>Bukti bayar</td>
								<td> : </td>
								<td width="250"><b name="bukti_bayar"></b></td>
							</tr>
						</table>
                        <div class="text-right mt-3">
                            <button class="btn btn-primary" onclick="setuju_bayar()">Approve</button>
                            <button class="ml-3 btn btn-warning" onclick="pending_bayar()">Pending</button>
                            <!-- <button class="btn btn-danger" onclick="tolak_bayar()">Tolak</button> -->
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>