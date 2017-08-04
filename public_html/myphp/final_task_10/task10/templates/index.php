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
        <div class="<?=$flashMessage['status']?>" id="mes">
            <?=$flashMessage['message']?>
        </div>
        <?php if(count($queries)>0):?>  
            <?php foreach($queries as $type=>$query):?>
            <h3 class="underline"><?=$type?>:</h3>
             <ul>
                 <?php foreach($query as $key=>$str):?>
                <li>
                    <div>
                        <h4><?=$key?>:</h4>
                        <p><?=!is_null($str)?$str:"Syntax error in query building"?></p>
                    </div>
                </li>
                <?php endforeach;?>
            </ul>
            <?php endforeach;?>
        <?php endif;?>    
        </div>
    </body>
</html>
