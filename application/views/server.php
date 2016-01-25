
    <div class="container">
    <h1><?php echo $server['name']; ?></h1>
    <div class="well">
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
        <div id="graphs" class="row">       
    
        </div>
    </div> <!-- /container --> 
<script src="<?php echo config_item('base_url'); ?>media/js/server-graphs.js"></script>
