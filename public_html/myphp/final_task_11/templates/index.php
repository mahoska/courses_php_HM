<!DOCTYPE html>
<html>
    <head>
        <title>Task 11</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>

    </head>
    <body>
        <div class="container">
        <div class="<?=$flashMessage['status']?>" id="mes">
            <?=$flashMessage['message']?>
        </div>
           
            <h3>initial data:</h3>
            <div>Record: 
                key = <?=isset($init['key']) ? $init['key'] : 'null'?> ; 
                data = <?=isset($init['data']) ? $init['data'] : 'null'?> 
            </div>
            <div>Selection: 
                <?php if($init['selection']): ?>
                <table class="table">
                    <tr>
                        <th>key</th>
                        <th>data</th>
                    </tr>
                    <?php foreach($init['selection'] as $item):?>
                        <?php foreach($item as $key=>$val):?>
                        <tr>
                            <td><?=$key?></td>
                            <td><?=$val?></td>
                        </tr>
                        <?php endforeach;?>
                    <?php endforeach;?>
                </table>
                <?php else:?> No entries
                <?php endif;?>
            </div>
            
             <?php if(!empty($descr)):?>
             <h3>Testing save:</h3>
                <?php foreach($descr as $item):?>
             
                    <?php if($item['oper'] == 'save'):?>
                        <ul>
                            <li>Record (unique = <?=isset($item['unique']) ? $item['unique'] : 'null'?>):
                                key = <?=isset($item['key']) ? $item['key'] : 'null'?>
                                data = <?=isset($item['data']) ? $item['data'] : 'null'?> 
                                
                            </li>
                        </ul>
                        <?php if(isset($item['selection'])):?>
                            <h4>After saving:</h4>
                            <div><b>Selection:</b> 
                                    <table class="table">
                                        <tr>
                                            <th>key</th>
                                            <th>data</th>
                                        </tr>
                                        <?php foreach($item['selection'] as $el):?>
                                            <tr><td><?=$el['key']?></td><td><?=$el['data'] ?></td></tr>
                                        <?php endforeach;?>
                                    </table> 
                                </div>  
                        <?php endif;?>
                    <?php endif;?>        
        
                <?php endforeach;?>
            <?php endif;?>
                            
                            
             <?php if(!empty($descrF)):?>
             <h3>Testing find:</h3>
                <?php foreach($descrF as $item):?>
                    <ul>
                        <li>
                            <b>operation = <?=$item['oper']?></b>
                            condition = <?=$item['condition']?> 
                            <div><b>Selection:</b> 
                                <ul>
                                    <?php if(!is_null($item['res'])):?>
                                        <?php if($item['oper']=='find'):?>
                                            <table class="table">
                                                <tr><th>key</th><th>data</th></tr>
                                                <tr><td><?=$item['res']['key']?></td><td><?=$item['res']['data'] ?></td></tr>
                                            </table>
                                        <?php else:?>
                                            <table class="table">
                                                <tr><th>key</th><th>data</th></tr>
                                            <?php foreach($item['res'] as $el):?>
                                                <tr><td><?=$el['key']?></td><td><?=$el['data'] ?></td></tr>
                                            <?php endforeach;?>
                                            </table>
                                        <?php endif;?>
                                    <?php else: ?> no record
                                    <?php endif;?>
                                </ul> 
                            </div>  
                        </li>
                    </ul>
                <?php endforeach;?>
            <?php endif;?>          
             
             <?php if(!empty($descrD)):?>
             <h3>Testing  delete and update:</h3>
                <?php foreach($descrD as $item):?>
                    <ul>
                        <li>
                            <b>operation = <?=$item['oper']?></b>
                            <?=isset($item['condition']) ? 'condition = '. $item['condition'] :""?> 
                            <div><b>Selection:</b> 
                                <?php if($item['oper']=='update record'):?>
                                    <table class="table">
                                        <tr><th>key</th><th>data</th></tr>
                                        <tr>
                                            <td><?=$item['selection']['key']?></td>
                                            <td><?=$item['selection']['data'] ?></td>
                                        </tr>
                                    </table>        
                                <?php else:?>
                                    <table class="table">
                                        <tr><th>key</th><th>data</th></tr>
                                        <?php foreach($item['selection'] as $el):?>
                                            <tr>
                                                <td><?=$el['key']?></td>
                                                <td><?=$el['data'] ?></td>
                                            </tr>
                                        <?php endforeach;?>
                                    </table>
                                <?php endif;?>
                            </div>  
                            <br>
                        </li>
                    </ul>
                <?php endforeach;?>
            <?php endif;?>          
             
        </div>
    </body>
</html>
