<div class="card card-dashboard-events">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-10">Permintaan Temu</h4>
            <i class="mdi mdi-dots-horizontal text-gray"></i>
        </div>
    </div>
    <div class="card-body">
    <?php
        if($data != null){
            foreach($data as $dt){
        
                echo '
                <div class="list-group">
                    <table>
                    <tr class="list-group-item border-top-0">
                        <td style="width:75%">
                            <div class="event-indicator bg-primary-gradient"></div>
                            <h6>Permintaan Temu</h6>
                            <p>Tanggal : <strong>'.substr($dt->tgl,0,10).'</strong></p>
                            <p>Jam : <strong>'.substr($dt->tgl,11,5).'</strong></p>
                            <small><span class="tx-danger">From</span> ( '.$dt->nama.' )</small>
                        </td>
                    
                        <td>
                            <input type="hidden" name="nama" value="'.$dt->nama.'">
                            <input type="hidden" name="id" value="'.$dt->id_janji.'">
                            <a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="setuju()"><i class="fas fa-check"></i></a>
                            <a class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="modal_tolak()"><i class="fas fa-ban"></i></a>
                        </td>
                    </tr>
                    </table>
                </div>
                ';
        
            }
        }else{
            echo '
            <div class="list-group">
                <div class="list-group-item border-top-0">
                    <h6 class="text-danger">Tidak ada permintaan temu.</h6>
                </div>
            </div>
            ';   
        }

    ?>
    </div>
</div>
