<div class="col-md-4 col-sm-6">
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="label label-success">
            
                <a class="mlink" href="<?php echo base_url('server/'.$server['server_id']); ?>">
                    <?php echo $server['hostname']; ?>
                </a>
            </span>
        </div>
        <div class="panel-body">
            <?php echo $panelBody; ?>
        </div>
    </div>
</div>