<?php

function get_form_html($id) {
    ob_start();
    ?>
    <div id="head_div" style="padding: 5px 0; background-color: #ECECEC;  color: #21ACD7;
         border-radius: 5px;margin-left: auto; text-align: center; ">
        SALES REPORT OF <?php echo date('F - Y',time()); ?>
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
                    <tr  status="not_selected" >
                        <td>
                            #
                        </td>
                        <td>
                            ID
                        </td>
                        <td>
                            DATE AND TIME
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
                    $sales = $sale_obj->getThisMonthsSales($user->company_id);
                    $i = 0;
                    if($sales==NULL || sizeof($sales)==0){
                        echo '<tr><td colspan="8"> No Sales Found </td></tr>';
                    } else{
                    foreach ($sales as $sale) {
                        ?>
                        <tr id="<?php echo $sale->id; ?>" onclick="select_row(this)" status="not_selected" >
                            <td style="text-align: center;">
                                <?php echo ++$i; ?>
                            </td>
                            <td>
                                <?php echo $sale->id; ?>
                            </td>
                            <td>
                                <?php echo $sale->sale_at; ?>
                            </td>
                            <?php 
                                $customer = new customer();
                                $customer->id = $sale->customer_id;
                                $customer->getCustomer();
                            ?>
                            <td id="customer" c_name="<?php echo $customer->customer_name?>" c_id="<?php echo $customer->id ?>" >
                                <?php 
                                echo $customer->customer_name. ' ( ID : '.$customer->id.' )';
                                ?>
                            </td>
                            <td id="tax">
                                <?php echo $sale->tax_amount; ?>
                            </td>
                            <td id="net_amount">
                                <?php echo $sale->net_amount; ?>
                            </td>
                            <td id="total">
                                <?php echo $sale->amount; ?>
                            </td>
                            <td id="down_button" style="width: 20px;text-align: center; padding: 10px;">
                                <img id="toggle_button" style="width: 20px; height: 20px; cursor: pointer;"
                                     onclick="toggle_items_visibility(this)" src="../ui/images/down_arrow.png"/>
                                <img id="toggle_button" style="width: 20px; height: 20px; cursor: pointer; display: none;"
                                     onclick="toggle_items_visibility(this)" src="../ui/images/up_arrow.png"/>
                            </td>
                        </tr>
                        <tr style="display: none;">
                            <td colspan="8" style="padding:0 0 20px 0;">
                                <table  id="sale_items" style="border-collapse: collapse; background-color: #c0effd; width: 80%; color: #21ACD7; float: right;">
                                    <thead>
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
                                </thead>
                                    <tbody>
                                    <?php
                                    foreach ($sale->getSalesItems() as $s_item) {
                                        ?>
                                    <tr id="<?php echo $s_item->id; ?>">
                                        <?php
                                        $item = new item();
                                        $item->id = $s_item->item_id;
                                        $item->getItem();
                                        ?>
                                            <td id="item" item_name="<?php echo $item->item_name; ?>"><?php
                                                echo $item->item_name . ' - ' . $item->item_code .' ( ID : '.$item->id.' )';
                                            ?></td>
                                            <td id="quantity" val="<?php echo $s_item->quantity; ?>">
                                                <?php echo $s_item->quantity; ?>
                                            </td>
                                            <td id="rate" val="<?php echo $s_item->rate; ?>">
                                                <?php echo $s_item->rate; ?>
                                            </td>                                            
                                            <td>
                                                <?php echo (($s_item->quantity * $s_item->rate) - $s_item->tax); ?>
                                            </td>    
                                            <?php 
                                                $tax_category = new tax_category();
                                                $tax_category->id = $item->tax_category_id;
                                                $tax_category->getTaxCategory();
                                            ?>
                                            <td id="tax" val="<?php echo $s_item->tax; ?>" tax_rate="<?php echo $tax_category->tax_percentage; ?>">
                                                <?php echo $s_item->tax; ?>
                                            </td>
                                            <td id="total" val="<?php echo ($s_item->quantity * $s_item->rate); ?>">
                                                <?php echo ($s_item->quantity * $s_item->rate); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                        </tbody>
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
    ?>    
    <script>
        
    </script>
    <?php
    $tools = ob_get_clean();
    return $tools;
}
?>