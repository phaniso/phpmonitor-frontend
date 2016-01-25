<div class="container">
	<h1>Server List</h1>
	<div class="table">
		<table id="server-list" class="table table-condensed table-hover">
			<thead>
				<tr>
       	 		<th style="text-align: center;"><span class="label label-info">Name</span></th>
          		<?php foreach($services as $label): ?>
				<th><span class="label label-info"><?php echo $label['sub']?></span></th>
				<?php endforeach; ?>
          		</tr>
        	</thead>
        	<tbody>
        	
        <?php
         foreach ($serversData as $server): 
                if ($server['status'] == 'online') {
         ?>
				<tr>
	         		<td>
	         			<span class="label label-primary">
	         			<a class="mlink" href="<?php echo config_item('base_url'); ?>server/<?php echo $server['server_id']; ?>"><?php echo $server['hostname']; ?></a>
	         			</span>
	         		</td>
         <?php
		foreach ($services as $serviceName => $service) {
            list($column1, $column2) = array_pad(explode(":", $service['dbcolumns']), 2, 1);
               if (is_numeric($column2)) {
                    $server[$column2] = $column2;
                }
				$tdContent = $service['show_numbers'] ? ($service['resize'] ? (convertUnit($server[$column1]) . "/" . convertUnit($server[$column2])) : $server[$column1]) 
				: $percents[$server['server_id']][$serviceName] . '%';

			$tdContent .= $service['percentages'] ? '
			<div class="progress">
 				<div class="'.getProgressBar($percents[$server['server_id']][$serviceName]).'" role="progressbar" aria-valuenow="' . $percents[$server['server_id']][$serviceName] . '" aria-valuemin="0" aria-valuemax="100" style="min-width: 20px; width: ' . $percents[$server['server_id']][$serviceName] . '%;">
 				' . $percents[$server['server_id']][$serviceName] . '%
 				</div>
  			</div>' : '';
			echo "
			<td>
				{$tdContent}
			</td>";
		}
         ?>
				</tr>
         <?php } else { ?>
	            <tr class="danger">
		            <td style="text-align: center;">
			            <span class="label label-danger">
				            <span class="glyphicon glyphicon-fire"></span>
				            <a class="mlink" href="<?php echo config_item('base_url'); ?>server/<?php echo $server['server_id']; ?>"><?php echo $server['hostname']; ?></a>
			            </span>
		            </td>
	            	<td colspan="<?php echo count($services)?>"></td>
	            </tr>
		 <?php } endforeach; ?>     
		</tbody>		
		</table>
	</div>
	<p class="text-right">
		<small>Last update was <?php echo $updateTime; ?></small>
	</p>

</div><!-- /.container -->