<?php


class HtmlHelper
{  
    const LEFT = 'left';
    const RIGHT = 'right';
    const CENTER = 'center';
    
    public static function createTable(
                                        $head, $data, $class = null,
                                        $align = self::LEFT,
                                        $caption= null, $ifHead = true, $ifBody = true, 
                                        $striped = true, $bordered=true, 
                                        $hover=true, $condensed=true
                                        )
    {
        $table = '<table class="table '.
            ($striped ? ' table-striped':'').
            ($bordered ? ' table-bordered':'').
            ($hover ? ' table-hover':'').
            ($condensed ? ' table-condensed':'').
            (!is_null($class) ? " ".$class:'');
        $table .= '" style="text-align:'.$align.';">';
        $table .= !is_null($caption)? '<caption>'.$caption.'</caption>':'';
        if($ifHead)
            $table .= '<thead>';

        $table .= '<tr >';
        foreach($head as $poleName)
        {
            $table .='<th style="text-align:'.$align.';">'.$poleName.'</th>';
        }
        $table .='</tr>';

        if($ifHead)$table .='</thead>';
        if($ifBody)$table .='<tbody>';

        foreach($data  as $row)
        {
             $table .='<tr>';
             foreach($row as $key=>$value)
             {
                $table.='<td>'.$value.'</td>';
             }
            $table .='</tr>';
        }

        if($ifBody)
            $table .='<tbody>';

        $table .= '</table>'; 
    
        return $table; 
    }


    public static function createList(
                                        $data,
                                        $isOrder = true,
                                        $bootstrapStyle = true,
                                        $classList = null)
    {
        $list = $isOrder ? 
                '<ol class=" '.($bootstrapStyle?'list-group ':'').(!is_null($classList) ? $classList:'').'">' : 
                '<ul class=" '.($bootstrapStyle?'list-group ':'').(!is_null($classList) ? $classList:'').'">';
        foreach($data as $item)
        {
            $list .= '<li class=" '.($bootstrapStyle?'list-group-item ':'').'">'.$item.'</li>';
        }
        $list .= $isOrder ? '</ol>' : '</ul>';

        return $list;
    }

    public static function createDList($data, $class=null)
    {
        $list = '<dl '.(!is_null($class) ? 'class="'.$class.'"':'').'>';
        foreach($data as $term => $descr)
        {
            $list .= '<dt>'.$term.'</dt>';
            $list .= '<dd>'.$descr.'</dd>';
        }

        $list .=  '</dl>';

        return $list;

    }

    public static function createSelectMulty(
                                                $data, 
                                                $name, 
                                                $selected = 0,
                                                $disabled = [], 
                                                $id = null, 
                                                $class=null, 
                                                $isMultiple = false, 
                                                $size = 1, 
                                                $isRequired = true)
    {
        $select = '<select name = "'.$name.'" size="'.$size.'" '.
                (!is_null($id) ? 'id="'.$id.'" ':'').
                'class = "form-control '.(!is_null($class) ? $class.'" ':'" ').
                ($isMultiple ? 'multiple ':'').
                ($isRequired ? 'required ':'').'>';

        $i = 0;
        $j = 0;
        foreach($data as $key=>$val)
        {
            $select .= '<option value="'.$key.'" '.
                    (($i == $selected)?'selected ':'').
                    ((self::inArray($disabled, $j))?'disabled':'').
                    '>'.$val.'</option>';
            $j++;$i++;
        }
        
        $select .="</select>";
        return $select;
    }
    
    private static function inArray($ar, $el)
    {
        foreach($ar as $item)
            if($item==$el)
                return true;
            
        return false;
    }
    
    public function createCheckBox($data, $name, $checked = [], $disabled = [])
    {
        $i = 0;
        $j = 0;
        $check = "";
        foreach($data as $key => $val)
        {
            $check .= '<div class="checkbox '.((self::inArray($disabled, $j))?'disabled':'').'">'.
                        '<label>'
                            .'<input type="checkbox" name="'.($name.$i++).
                                    '" value="'.$key.'" '.
                                    ((self::inArray($disabled, $j))?'disabled':'').
                                    ((self::inArray($checked, $j))?'checked':'').'>'.
                                    $val.
                        '</label>'.
                    '</div>' ;
            $j++;
        }
        return $check;
    }
    
     public function createRadioGroup($data, $name, $checked = null, $disabled = [])
    {
        $i = 0;
        $j = 0;
        $radio = "";
        foreach($data as $key => $val)
        {
            $radio .= '<div class="radio '.((self::inArray($disabled, $j))?'disabled':'').'">'.
                        '<label>'
                            .'<input type="radio" name="'.$name.
                                    '" value="'.$key.'" '.
                                    ((self::inArray($disabled, $j))?'disabled':'').
                                    ($i++ == $checked ?'checked':'').'>'.
                                    $val.
                        '</label>'.
                    '</div>' ;
            $j++;
        }
        return $radio;
    }
}
