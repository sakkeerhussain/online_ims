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
                            <td style="text-align: center;"><?php echo ++$i; ?></td>
                            <td id="item_name"><?php echo $item->item_name; ?></td>
                            <td id="item_code"><?php echo $item->item_code; ?></td>
                            <td id="mrp"><?php echo $item->mrp; ?></td>
                            <td id="purchace_rate"><?php echo $item->purchace_rate; ?></td>
                            <?php 
                            $tax_category = new tax_category();
                            $tax_category->id = $item->tax_category_id;
                            $tax_category->getTaxCategory();
                            ?>
                            <td id="tax_category" tax_category_id="<?php echo $tax_category->id; ?>" ><?php echo $tax_category->tax_category_name; ?></td>
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
        function on_edit_clicked(){
            var selected_row = $('tr[status="selected"]');
            var item_name = selected_row.find('td#item_name').html();
            var id = selected_row.attr('id');
            var item_code = selected_row.find('td#item_code').html();
            var mrp = selected_row.find('td#mrp').html();
            var purchace_rate = selected_row.find('td#purchace_rate').html();
            var tax_category_id = selected_row.find('td#purchace_rate').html();
            get_form(11,  ///item create form
                function (html, tools){
                    $('div#form-body').html(html);
                    $('div#content-body-action-tools').html(tools);
                    var form = $('div#form-body').find('form.action_form');
                    form.attr('operation', 'update');
                    form.attr('item_id', id);
                    form.find('input#item_name').val(item_name);
                    form.find('input#item_code').val(item_code);
                    form.find('input#mrp').val(mrp);
                    form.find('input#purchace_rate').val(purchace_rate);
                    form.find('select#tax_category').val(tax_category_id);
                    form.find('input[type=submit]').val('UPDATE');
                },
                function (message){
                    $('font#section_heading').empty();
                    $('div#form-body').empty();
                    alert(message);
                }
             );
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
    <img onclick="on_edit_clicked()" id="edit" onclick="" src="../ui/images/edit.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer; display: none;">
    <script>
        
    </script>
    <?php
    $tools = ob_get_clean();
    return $tools;
}
?>