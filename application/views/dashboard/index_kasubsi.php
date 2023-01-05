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
</script>