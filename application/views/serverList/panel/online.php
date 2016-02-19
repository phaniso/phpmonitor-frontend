<div class="col-md-4 col-sm-6">
    <div class="panel panel-default text-center">
        <div class="panel-heading">
            <span class="label label-success">
                <a class="mlink" href="<?php echo base_url('server/'.$server['server_id']); ?>">
                    <?php echo $server['hostname']; ?>
                </a>
            </span>
        </div>
        <ul class="list-group">
        <?php echo $body; ?>
        </ul>
    </div>
</div>