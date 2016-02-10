
    <div class="container" style="padding: 10px;">
    <div class="panel panel-default">
    <div class="panel-heading">
        <?php echo $server['name']; ?>
    </div>
    <div class="panel-body">
		<div id="server_id" value="<?php echo $server['id']; ?>"></div>
        <div class="panel panel-default">
            <table class="table">
                <tr>
                    <td>Name</td>
	    			<td><?php echo $server['name']; ?></td>
                </tr>
                <tr>
                    <td>Cpu cores</td>
	    			<td><?php echo $serverHistory['cpu_cores']; ?></td>
                </tr>
                <tr>
                    <td>Memory</td>
	    			<td><?php echo convertUnit($serverHistory['memory_total']); ?></td>
                </tr>
                <tr>
                    <td>Disk space</td>
	    			<td><?php echo convertUnit($serverHistory['disk_total']); ?></td>
                </tr>
                <tr>
                    <td>Last time online</td>
	    			<td><?php echo $lastTimeOnline; ?></td> 
                </tr>
            </table>
        </div>
    </div>
    </div>

        <div class="panel-default">
            <div class="panel-heading">Graphs</div>
            <div class="panel-body">
                <div id="graphs" class="row"></div>

            </div>
        </div>
    </div>

<script src="<?php echo config_item('base_url'); ?>media/js/server-graphs.js"></script>
