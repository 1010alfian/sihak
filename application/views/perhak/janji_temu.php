<div class="card card-dashboard-events">
    <div class="card-header pb-0">
        <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-10">Janji Temu</h4>
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
                        <td>
                            <div class="event-indicator bg-success-gradient"></div>
                            <h6>Anda akan bertemu dengan : '.$dt->nama.'</h6>
                            <p>Tanggal : <strong>'.substr($dt->tgl,0,10).'</strong></p>
                            <p>Jam : <strong>'.substr($dt->tgl,11,5).'</strong></p>
                            <small><span class="tx-danger">Tempat</span> ( kantor )</small>
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
                    <h6 class="text-danger">Tidak ada janji temu.</h6>
                </div>
            </div>
            ';   
        }

    ?>
    </div>
</div>