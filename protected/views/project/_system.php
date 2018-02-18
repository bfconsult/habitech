
<tr class="odd">
    <td>


        <a href="<?php echo UrlHelper::getPrefixLink('/system/view/id/') ?><?php echo  $item['id']; ?>"><?php echo $item['name']; ?></a>
        - <?php echo $item['description']; ?>
    </td>
    <td>
        <?php
        if ($item->type == 1) {
            ?>(shared system) <a href="/project/unlink/id/<?php echo  $item['id']; ?>"><i
                    class="icon-unlink"></i></a>

            <?php
        } else {

            ?><a href="/project/systemdelete/id/<?php echo  $item['id']; ?>"><i
                    class="icon-remove-sign"></i></a>

            <?php
        }
        ?>

    </td>


</tr>
