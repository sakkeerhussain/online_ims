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
                    <tr>
                        <td>
                            #
                        </td>
                        <td>
                            DATE
                        </td>
                        <td>
                            CUSTOMER
                        </td>
                        <td style="">
                            TAX
                        </td>
                        <td style="">
                            NET. AMOUNT
                        </td>
                        <td style="">
                            TOTAL
                        </td>
                        <td style="">

                        </td>
                    </tr>
                </thead>
                <tbody style="padding-left: 3px; text-align: center; ">
                    <?php
                    $sale_obj = new sales();
                    $user = new user();
                    $user->id = $_SESSION['user_id'];
                    $user->getUser();
                    $sales = $sale_obj->getTodaysSales($user->company_id);
                    $i = 0;
                    if($sales==NULL || sizeof($sales)==0){
                        echo '<tr><td colspan="8"> No Sales Found </td></tr>';
                    } else{
                    foreach ($sales as $sale) {
                        ?>
                        <tr id="<?php echo $sale->id; ?>">
                            <td style="text-align: center;">
                                <?php echo ++$i; ?>
                            </td>
                            <td>
                                <?php echo $sale->sale_at; ?>
                            </td>
                            <td>
                                <?php 
                                $customer = new customer();
                                $customer->id = $sale->customer_id;
                                $customer->getCustomer();
                                echo $customer->customer_name. ' ( ID : '.$customer->id.' )';
                                ?>
                            </td>
                            <td>
                                <?php echo $sale->tax_amount; ?>
                            </td>
                            <td>
                                <?php echo $sale->net_amount; ?>
                            </td>
                            <td>
                                <?php echo $sale->amount; ?>
                            </td>
                            <td id="down_button" style="width: 20px;text-align: center; padding: 10px;">
                                <img id="toggle_button" style="width: 20px; height: 20px; cursor: pointer;"
                                     onclick="toggle_items_visibility(this)" src="../ui/images/down_arrow.png"/>
                                <img id="toggle_button" style="width: 20px; height: 20px; cursor: pointer; display: none;"
                                     onclick="toggle_items_visibility(this)" src="../ui/images/up_arrow.png"/>
                            </td>
                        </tr>
                        <tr id="purchace_item" style="display: none;">
                            <td colspan="8" style="padding:0 0 20px 0;">
                                <table style="border-collapse: collapse; background-color: #c0effd; width: 80%; color: #21ACD7; float: right;">
                                    <tr>
                                        <td>
                                            ITEM
                                        </td>
                                        <td>
                                            QUANTITY
                                        </td>
                                        <td>
                                            RATE
                                        </td>
                                        <td>
                                            NET. AMOUNT
                                        </td>
                                        <td>
                                            TAX
                                        </td>
                                        <td>
                                            TOTAL
                                        </td>
                                    </tr>
                                    <?php
                                    foreach ($sale->getSalesItems() as $s_item) {
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                $item = new item();
                                                $item->id = $s_item->item_id;
                                                $item->getItem();
                                                echo $item->item_name . ' - ' . $item->item_code .' (ID : '.$item->id.')';
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $s_item->quantity; ?>
                                            </td>
                                            <td>
                                                <?php echo $s_item->rate; ?>
                                            </td>                                            
                                            <td>
                                                <?php echo (($s_item->quantity * $s_item->rate) - $s_item->tax); ?>
                                            </td>                                            
                                            <td>
                                                <?php echo $s_item->tax; ?>
                                            </td>
                                            <td>
                                                <?php echo ($s_item->quantity * $s_item->rate); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
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
        function add_to_stock(ok_button) {
            var row = $(ok_button).closest('tr');
            var purchace_id = row.attr('id');
            var data = {
                purchace_id: purchace_id
            }
            add_purchace_to_stock(data, function(message) {
                row.hide();
                row.next().hide();
                if(row.parent('tbody').children('tr:visible').length==0){
                    row.parent('tbody').html('<tr><td colspan="8"> No Purchace left more </td></tr>');
                }
                alert(message);
            }, function(message) {
                alert(message);
            });
        }
        function toggle_items_visibility(down_button) {
            var row = $(down_button).closest('tr');
            row.next('tr').fadeToggle();
            row.find('img#toggle_button').toggle();
            
        }
    </script>

    <?php
    $form = ob_get_clean();
    return $form;
}

function get_form_tools_html($id){
    ob_start();
    
    $tools = ob_get_clean();
    return $tools;
}
?>