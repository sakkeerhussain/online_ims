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
                            ITEM
                        </td>
                        <td>
                            STOCK COUNT
                        </td>
                        <td style="">
                            SELLING PRIZE
                        </td>
                        <td style="">
                            TAX
                        </td>
                    </tr>
                </thead>
                <tbody style="padding-left: 3px; text-align: center; ">
                    <?php
                    $inventry = new inventry();
                    $user = new user();
                    $user->id = $_SESSION['user_id'];
                    $user->getUser();
                    $inventries = $inventry->getInventryForSpecificCompany($user->company_id);
                    $i = 0;
                    if($inventries==NULL || sizeof($inventries)==0){
                        echo '<tr><td colspan="8"> No Purchace Found </td></tr>';
                    } else{
                    foreach ($inventries as $inventry) {
                        ?>
                        <tr id="<?php echo $inventry->id; ?>" >
                            <td style="text-align: center;">
                                <?php echo ++$i; ?>
                            </td>
                            <td>
                                <?php
                                $item = new item();
                                $item->id = $inventry->id;
                                $item->getItem();
                                echo $item->item_name;
                                ?>
                            </td>
                            <td>
                                <?php echo $inventry->in_stock_count; ?>
                            </td>
                            <td>
                                <?php echo $inventry->selling_prize; ?>
                            </td>
                            <td>
                                <?php
                                $tax = new tax_category();
                                $tax->id = $inventry->tax_category_id;
                                $tax->getTaxCategory();
                                echo $tax->tax_category_name;
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