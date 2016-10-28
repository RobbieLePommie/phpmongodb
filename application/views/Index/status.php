
<div class="well" id="container-indexes">


    <div id="myTabContent" class="tab-content">
        <div class="tab-pane active in" id="IndexesList">
            <table class="table">

                <tbody>
                    <?php foreach ($this->data['status'] as $k => $v) { ?>
                        <tr>
                            <td><?php echo $k;?></td>
                            <td><?php echo Helper::preBlock($this->data['cryptography']->mixedToJson($v,false)); ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


    </div>
</div>