 <tr class="danger">
                    <td>
                        <span class="label label-danger">
                            <span class="glyphicon glyphicon-fire"></span>
                            <a class="mlink" href="<?php echo config_item('base_url'); ?>server/<?php echo $server['server_id']; ?>"><?php echo $server['hostname']; ?></a>
                        </span>
                    </td>
                    <td colspan="<?php echo count($services)?>"></td>
                </tr>
