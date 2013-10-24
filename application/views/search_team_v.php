<div>
    <?php
        // List up all results.
    foreach ($results as $val):?>
    <table
        <tbody>
            <tr class="search_team">
                <td><input type="checkbox" value="" /></td>
                <td class="teamname"><?php echo $val['teamname'];?></td>
                <td class="sport"><?php echo $val['sport'];?></td>
                <td class="join"><button class="btn btn-info"</button>
            </tr>
        </tbody> 
    </table>
        <?php endforeach;?> 
</div>
