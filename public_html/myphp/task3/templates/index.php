<!DOCTYPE html>
<html>
    <head>
        <title>Task 3</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>

    </head>
    <body>
        
        <div class="container">
            <div class="<?=$flashMessage['status']?>" id="mes">
            <?=$flashMessage['message']?>
            </div>
            <h2>Testing first tasks part</h2>
            <?php if(!empty($resL)):?>
                <h4>Functions that read file by line </h4>
                <?php foreach($resL as $ar):?>
                    <div class="components">
                    <h5 class="green underline"><?=$ar['fileName']?></h5>    
                    <?php if(!empty($ar['result'])):?>
                        <ol>
                        <?php foreach($ar['result'] as $line):?>
                            <li><?=$line?></li>
                        <?php endforeach;?>
                        </ol>
                    <?php else: ?> 
                        <h5> - file empty or error reading file</h5>
                    <?php endif;?>
                    </div>   
                <?php endforeach;?>
            <?php endif;?>
                
           <?php if(!empty($resS)):?>
                <h4>Functions that read file by chars </h4>
                <?php foreach($resS as $ar):?>
                    <div class="components">
                    <h5 class="green underline"><?=$ar['fileName']?></h5>    
                    <?php if(!empty($ar['result'])):?>
                        <ol class="chars">
                        <?php foreach($ar['result'] as $line):?>
                            <?php foreach($line as $symb):?>
                                <li><?=$symb?></li>
                            <?php endforeach;?>  
                        <?php endforeach;?>
                        </ol>
                    <?php else: ?> 
                        <h5> - file empty or error reading file</h5>
                    <?php endif;?>
                    </div>   
                <?php endforeach;?>
            <?php endif;?>
                
             <h2>Testing second tasks part</h2> 
              <?php if(!empty($resRepl)):?>
                <h4>Function of replacement</h4>
                <?php foreach($resRepl as $ar):?>
                    <div class="components">
                    <h5 class="green underline"><?=$ar['fileName']?> - <?=$ar['key']?></h5>    
                    <?php if(!empty($ar['result'])):?>
                        <ol>
                        <?php foreach($ar['result'] as $line):?>
                            <li><?=$line?></li>
                        <?php endforeach;?>
                        </ol>
                    <?php else: ?> 
                        <h5> - file empty or error reading file</h5>
                    <?php endif;?>
                    </div>   
                <?php endforeach;?>
            <?php endif;?>
             
        </div>
    </body>
</html>

