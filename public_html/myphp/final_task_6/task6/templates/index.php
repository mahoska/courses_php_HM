<!DOCTYPE html>
<html>
    <head>
        <title>Task 6</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/bootstrap.min.css"/>
        <link rel="stylesheet" href="css/style.css"/>

    </head>
    <body>
        <div class="container">
        <?php if(count($fullInfo)>0):?>  
            <table class="table table-bordered table-hover bandInfo">
                <thead class="head">
                    <tr>
                        <th>Musician name</th>
                        <th>Musician type</th>
                        <th>Instrument(s)</th>
                        <th>Groups in which</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($fullInfo as $band):?>
                    <tr class="band">
                        <td colspan="4">
                            <h3>
                                <?=$band['name']?> 
                                <span>( <?=$band['type']?> )</span>
                            </h3>
                        </td>
                    </tr>
                    <?php if(count($band['musician'])>0):?>
                    <?php foreach($band['musician'] as $musician):?>
                    <tr class="musician">
                        <td><h4><?=$musician['name']?></h4></td>
                        <td>
                            <ul>
                                 <?php foreach($musician['type'] as $type):?>
                                    <li><?=$type?></li>
                                 <?php endforeach; ?>
                            </ul>
                        </td>
                        <td>
                             <ul>
                                 <?php foreach($musician['instruments'] as $instrument):?>
                                    <li>
                                        <?=$instrument['name'].' ( '.$instrument['category'].' )'?>
                                    </li>
                                 <?php endforeach; ?>
                            </ul>
                        </td>
                        <td>
                            <ul>
                                 <?php foreach($musician['assignBands'] as $aband):?>
                                    <li><?=$aband?></li>
                                 <?php endforeach; ?>
                            </ul>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else:?>
                        <tr>The composition of the group is not known</tr>
                    <?php endif;?>

                    <?php endforeach;?>
                </tbody>
            </table>
        <?php endif;?>    
        </div>
    </body>
</html>
