<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8"/>
        <title>Calc</title>
    </head>
    <body> 
        <?php if(isset($res1) && !empty($res1)):  ?>
            <h3>Standart math operations:</h3>
            <ul style="list-style: none;">
            <?php foreach($res1 as $test):?>
                <?php  if($test['operation']=='sqrt'):?>
                    <li>
                    <?=$test['operation']."(".$test['data']['a'].") = ".$test['res'];?>
                    </li> 
                <?php else: ?>
                    <li>
                     <?=$test['data']['a']." ".$test['operation']." ".
                        $test['data']['b']." = ".$test['res'];?>
                    </li> 
                <?php endif;?>
            <?php endforeach;?>
            </ul>
        <?php endif; ?>

        <?php if(isset($operationWithMemory) && !empty($operationWithMemory)):?>
            <h3>Operation with memory:</h3>
            <ul style="list-style: none;">
                <?php foreach($operationWithMemory as $oper):?>
                    <li>
                        <?=$oper['operation']." = ".$oper['res']?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif;?>
    </body>
</html>
