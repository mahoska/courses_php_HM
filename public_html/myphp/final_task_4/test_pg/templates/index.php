<!DOCTYPE html>
<html>
    <head>
        <title>Task 4</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>

    </head>
    <body>
        <div class="container">
        <div  id="mes">
        <h3>TESTING MYSQL</h3>
         </div>
            <?php if(count($res)):?>
                <?php foreach($res as $item):?>
                    <h3><?=$item['operation']?></h3>
                    <table class='table table-striped resultTabl'>
                        <tr>
                            <th>N</th>
                            <th>Key</th>
                            <th>Data</th>
                        </tr>
                        <?php $i = 1; foreach($item['result'] as $itemRes):?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$itemRes['key'];?></td>
                            <td><?=$itemRes['data'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
            <?php endforeach;?>
            <?php endif;?>
                    
                    
        <br/>            
        <div  id="mes_pg">
        <h3>TESTING PGSQL</h3>
         </div>
            <?php if(count($resPg)):?>
                <?php foreach($resPg as $item):?>
                    <h3><?=$item['operation']?></h3>
                    <table class='table table-striped resultTabl'>
                        <tr>
                            <th>N</th>
                            <th>Key</th>
                            <th>Data</th>
                        </tr>
                        <?php $i = 1; foreach($item['result'] as $itemRes):?>
                        <tr>
                            <td><?=$i++;?></td>
                            <td><?=$itemRes['key'];?></td>
                            <td><?=$itemRes['data'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
            <?php endforeach;?>
            <?php endif;?>        
                    
        
        </div>
        
    </body>
</html>