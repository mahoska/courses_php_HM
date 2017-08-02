<!DOCTYPE html>
<html>
    <head>
        <title>Task 5</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>

    </head>
    <body>
        <div class="container">
            <h3>Testing MySql</h3>
            <?php if(!empty($messages)):?>   
                <ul class="listResUpl" >
                    <?php foreach($messages as $item) :?>
                        <li class="<?=$item['status']?>">-> <?=$item['mes']?></li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>
            
            <h3>Testing Session</h3>
             <?php if(!empty($resSes)):?> 
             <?php foreach($resSes as $item) :?>
                <p><?=$item;?></p>
             <?php endforeach;?>
             <?php endif;?>
                
            <h3>Testing Cookie</h3>
             <?php if(!empty($resCook)):?> 
             <?php foreach($resCook as $item) :?>
                <p><?=$item;?></p>
             <?php endforeach;?>
             <?php endif;?>
                
            <h3>Testing PgSql</h3>
            <?php if(!empty($messagesP)):?>   
                <ul class="listResUpl" >
                    <?php foreach($messagesP as $item) :?>
                        <li class="<?=$item['status']?>">
                            <?php foreach($item['mes'] as $key=>$val):?>
                                <?=$val?>
                            <?php endforeach;?>
                        </li>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>    
                
        </div>
    </body>
</html>