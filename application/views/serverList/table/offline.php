<tr class="danger">
    <td>
        <span class="label label-danger">
            <span class="glyphicon glyphicon-fire"></span>
            <a class="mlink" href="<?php echo base_url('server/'.$server['server_id']); ?>">
                <?php echo $server['hostname']; ?>
            </a>
        </span>
    </td>
    <td colspan="<?php echo count($services)?>"></td>
</tr>
