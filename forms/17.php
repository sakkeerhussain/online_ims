<?php

function get_form_html($id) {
    ob_start();
    ?>
    <div style="height: 150px; 
         width: 320px; background-color: #ECECEC; 
         border-radius: 5px;margin-left: auto;display: none; ">



    </div>
    <div style="margin-top: 30px; background-color:transparent;padding-bottom: 30px;">
        <style>
            div#purchace_items td{
                border: 1px solid #21ACD7;
            }
            div#purchace_items tbody td{
                padding: 5px 0 5px 5px;
            }
            div#purchace_items tbody td input,div#purchace_items tbody td select{
                padding: 0;
                border: 0;
                margin: 0;
                height: 100%;
                width: 100%;
                background-color: transparent;
            }
        </style>
        <div id="purchace_items" style="width: 100%; padding: 10px 0; color: #21ACD7;">           
            <table id="items_table" style="border-collapse: collapse; width: 100%; 
                   background-color: #fff; border-radius: 10px;  color: #21ACD7;">
                <thead style="text-align: center;">
                    <tr status="not_selected">
                        <td>
                            #
                        </td>
                        <td>
                            ITEM NAME
                        </td>
                        <td>
                            ITEM CODE
                        </td>
                        <td style="">
                            MRP
                        </td>
                        <td style="">
                            PURCHACE RATE
                        </td>
                        <td style="">
                            TAX
                        </td>
                    </tr>
                </thead>
                <tbody style="padding-left: 3px; text-align: center; ">
                    <?php
                    $item = new item();
                    $items = $item->getItems();
                    $i = 0;
                    if($items==NULL || sizeof($items)==0){
                        echo '<tr><td colspan="8"> No Item Found </td></tr>';
                    } else{
                    foreach ($items as $item) {
                        ?>
                    <tr id="<?php echo $item->id; ?>" onclick="select_row(this)">
                            <td style="text-align: center;">
                                <?php echo ++$i; ?>
                            </td>
                            <td>
                                <?php echo $item->item_name; ?>
                            </td>
                            <td>
                                <?php echo $item->item_code; ?>
                            </td>
                            <td>
                                <?php echo $item->mrp; ?>
                            </td>
                            <td>
                                <?php echo $item->purchace_rate; ?>
                            </td>
                            <td>
                                <?php 
                                $tax_category = new tax_category();
                                $tax_category->id = $item->tax_category_id;
                                $tax_category->getTaxCategory();
                                echo $tax_category->tax_category_name;
                                ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                    ?>
                </tbody>                               
            </table>
        </div>
    </div>
    <script type="text/javascript">
        function select_row(row) {
            var j_row = $(row);
            if(j_row.attr('status') == 'selected'){
                $('table#items_table tr').attr('status', 'not_selected');
                $('table#items_table tr').css('background-color', '#FFF');
                $('img#edit').css('display', 'none');
                $('img#edit_fade').css('display', 'block');
            }else{            
                $('table#items_table tr').attr('status', 'not_selected');
                $('table#items_table tr').css('background-color', '#FFF');
                j_row.attr('status', 'selected');
                j_row.css('background-color', '#C0EFFD');
                $('img#edit').css('display', 'block');
                $('img#edit_fade').css('display', 'none');
            }          
        }
    </script>

    <?php
    $form = ob_get_clean();
    return $form;
}

function get_form_tools_html($id){
    ob_start();
    ?>    
    <img id="edit_fade" src="../ui/images/edit_fade.png" height="40" width="40" style="margin: 15px auto 0px 12px;">
    <img id="edit" onclick="" src="../ui/images/edit.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer; display: none;">
    <script>
        
    </script>
    <?php
    $tools = ob_get_clean();
    return $tools;
}
?>