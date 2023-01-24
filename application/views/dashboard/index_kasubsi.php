<div class="row row-sm">
    <div class="col-lg-12 col-xl-4 col-md-12 col-sm-12 permintaan_temu"></div>
    <div class="col-lg-12 col-xl-4 col-md-12 col-sm-12 janji_temu"></div>
</div>
  
<script>
    get_permintaan_temu();

    function get_permintaan_temu(){
        $('.permintaan_temu').load('<?=base_url()?>perhak/permintaan_temu');
        $('.janji_temu').load('<?=base_url()?>perhak/janji_temu');
    }

    function setuju(){
        var nama = $('[name="nama"]').val();
        var id = $('[name="id"]').val();
        var konfirmasi = confirm("Anda akan membuat janji temu dengan "+nama+" ?");

        if(konfirmasi){
            $.ajax({
                url: '<?= base_url() ?>perhak/setuju_janji',
                type: 'POST',
                dataType: 'JSON',
                data: {id_janji : id},
                success: function(res){
                    get_permintaan_temu();
                }
            });
        }
    }

    function tolak(){
        var nama = $('[name="nama"]').val();
        var id = $('[name="id"]').val();
        var konfirmasi = confirm("Anda menolak permintaan temu dari "+nama+" ?");

        if(konfirmasi){
            $.ajax({
                url: '<?= base_url() ?>perhak/tolak_janji',
                type: 'POST',
                dataType: 'JSON',
                data: {id_janji : id},
                success: function(res){
                    get_permintaan_temu();
                }
            });
        }
    }

    function modal_tolak(){
        var id = $('[name="id"]').val();
        $.ajax({
            url: '<?= base_url() ?>perhak/modal_tolak_janji',
            type: 'POST',
            dataType: 'JSON',
            data: {id_janji : id},
            success: function(res){
                $('[name="id_tolak_temu"]').val(res.id_janji);
                $('[name="nama_peminta"]').val(res.nama);
                $('[name="id_pemohon"]').val(res.id_user);
                $('#modal').modal('show');
            }
        })
    }

    function tolak_permintaan_temu(){
        var nama = $('[name="nama_peminta"]').val();
        var id = $('[name="id_tolak_temu"]').val();
        var id_user = $('[name="id_pemohon"]').val();
        var ket = $('[name="keterangan_tolak_temu"]').val();
        var konfirmasi = confirm("Anda menolak permintaan temu dari "+nama+" ?");

        if(konfirmasi){
            $.ajax({
                url: '<?= base_url() ?>perhak/tolak_janji',
                type: 'POST',
                dataType: 'JSON',
                data: {id_janji : id, id_user: id_user, keterangan: ket},
                success: function(res){
                    get_permintaan_temu();
                    $('#modal').modal('hide');
                }
            });
        }
    }
</script>

<div class="modal" id="modal">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title pengajuan">Alasan menolak permintaan temu</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
                    <div class="col-12">
						<input type="hidden" name="id_tolak_temu">
						<input type="hidden" name="nama_peminta">
						<input type="hidden" name="id_pemohon">
						<div class="form-group">
							<label for="">Keterangan</label>
							<textarea name="keterangan_tolak_temu" class="form-control" id="" cols="30" rows="10"></textarea>
						</div>
						<div class="text-right">
							<button class="btn btn-danger" onclick="tolak_permintaan_temu()">Tolak</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</script>