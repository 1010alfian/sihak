<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div>
		<h4 class="content-title mb-2">Janji temu dilakukan jika sudah mendapat booking no hak baru!</h4>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Buat Janji</a></li>
				<!-- <li class="breadcrumb-item active" aria-current="page"> Data Tables</li> -->
			</ol>
		</nav>
			</div>
	<div class="d-flex my-auto">
	</div>
</div>
<!-- /breadcrumb -->

<div class="row row-sm">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-header pb-0">
				<div class="d-flex justify-content-between">
					<h4 class="card-title mg-b-2 mt-2">Buat Janji Kekantor</h4>
					<i class="mdi mdi-dots-horizontal text-gray"></i>
                </div>
            </div>
            <div class="card-body">
                <form action="javascript:buat_janji()" id="submit">
                    <div class="row row-sm mg-b-20">
                        <div class="input-group col-md-4">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                </div>
                            </div>
                            <input class="form-control dates" type="text" name="dates">
                        </div>

                        <div class="input-group col-md-5">
                            <input class="form-control" type="text" value="Buat janji ke kantor" disabled>
                            <input type="hidden" value="Buat janji ke kantor" name="janji">
                        </div>

                        <div class="input-group col-md-3">
                            <button class="btn btn-sm btn-primary w-100" type="submit">Kirim Permintaan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-10">Permintaan temu yang di kirim</h4>
            <i class="mdi mdi-dots-horizontal text-gray"></i>
        </div>
    </div>
    <div class="card-body pd-y-7">
        <div class="table-responsive">
            <table class="table text-md-nowrap" id="table-temu">
                <thead>
                    <tr>
                        <th class="wd-15p border-bottom-0">No</th>
                        <th class="wd-15p border-bottom-0">Permintaan Temu</th>
                        <th class="wd-15p border-bottom-0">Status</th>
                        <th class="wd-15p border-bottom-0">Keterangan</th>
                        <th class="wd-15p border-bottom-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>

$('.dates').daterangepicker({
    timePicker: true,
    singleDatePicker: true,
    autoApply: true,
    timePicker24Hour: true,
    // autoclose: true,
    locale: {
        format: 'YYYY-MM-DD H:mm:ss'
    }
});

var table;
$(document).ready(function(){
    table = $('#table-temu').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url" : "<?=base_url()?>perhak/get_janji_temu",
            "type" : "POST"
        },

        "columnDefs": [
            {"targets" : [0], "orderable" : false, "width": "5%"},
            {"targets" : [3], "width" : "40%",},
            {"targets" : [4], "width" : "10%",},
        ],
    });

});

function reload_datatable(){
    table.ajax.reload();
}

function getDateTime(){
    var date = (new Date()).toISOString().split('T')[0];
}

function buat_janji(){
    var form = $('#submit')[0];
    var dateTime = $('.dates').val();
    var tgl = dateTime.substring(0, 10);
    var jam = dateTime.substring(11, 19);

    var konfirmasi = confirm("Anda akan membuat janji temu tanggal "+ tgl +" jam "+ jam +" ?");
    if(konfirmasi){
            $.ajax({
            url: '<?=base_url()?>perhak/kirim_janji',
            type: 'POST',
            data: new FormData(form),
            cache: false,
            processData: false,
            dataType: 'json',
            contentType: false,
            success: function(data){
                $('#modal').modal('hide');
                alert('Permintaan temu berhasil di kirim.');
                table.ajax.reload();
            }
        })
    }
}

function hapus_janji(id){
    var konfirmasi = confirm("Anda akan membatalkan permintaan temu ?");
    if(konfirmasi){
        $.ajax({
            url: '<?=base_url()?>perhak/batalkan_janji_temu',
            type: 'POST',
            dataType: 'JSON',
            data: {id_janji : id},
            success: function(res){
                alert('Permintaan temu dibatalkan.');
                table.ajax.reload();
            }
        })
    }
}
</script>