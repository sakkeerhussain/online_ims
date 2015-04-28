<?php

function get_form_html($id) {
    ob_start();
    ?>
    <div style="height: 150px; 
         width: 320px; background-color: #ECECEC; 
         border-radius: 5px;margin-left: auto;display: none; ">



    </div>
    <div id="sales_items_table" style="margin-top: 30px; background-color:transparent;padding-bottom: 30px;">
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
            <table id="sales_items_table" style="border-collapse: collapse; width: 100%; 
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
                            COUNT
                        </td>
                        <td style="">
                            TOTAL
                        </td>
                    </tr>
                </thead>
                <tbody style="padding-left: 3px; text-align: center; ">
                    <?php
                    $grand_total = 0;
                    $total_count = 0;
                    $sale_item = new sales_items();
                    $user = new user();
                    $user->id = $_SESSION['user_id'];
                    $user->getUser();
                    $sales_items = $sale_item->getTodaysSaleItems($user->company_id);
                    $i = 0;
                    if($sales_items==NULL || sizeof($sales_items)==0){
                        echo '<tr><td colspan="8"> No Sales Items Found </td></tr>';
                    } else{
                    foreach ($sales_items as $sales_item) {
                        $grand_total = $grand_total + $sales_item->total;
                        $total_count = $total_count + $sales_item->quantity;
                        ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo ++$i; ?>
                            </td>
                            <?php 
                                $item = new item();
                                $item->id = $sales_item->item_id;
                                $item->getItem();
                            ?>
                            <td style="text-align: left;">
                                <?php echo $item->item_name.' ( '. $item->item_code .' )'; ?>
                            </td>
                            <td>
                                <?php echo $sales_item->quantity; ?>
                            </td>
                            
                            <td id="tax">
                                <?php echo $sales_item->total; ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                    ?>
                        <tr>
                            <td></td>
                            <td style="text-align: right;"> TOTAL </td>
                            <td><?php echo $total_count; ?></td>
                            <td><?php echo $grand_total; ?></td>
                        </tr>
                </tbody>                               
            </table>
        </div>
    </div>
    <script type="text/javascript">
        function on_print_clicked() {
            $('div#print_container_header').html('<h1 style="color:#21ACD7;">Day-End Report</h1>');
            var html = $('div#sales_items_table').html();
            $('div#print_container_body').html(html);
            print();
            $('div#print_container_header').empty();
            $('div#print_container_body').empty();
            $('div#print_container_footer').empty();
        }
       
    </script>

    <?php
    $form = ob_get_clean();
    return $form;
}

function get_form_tools_html($id){
    ob_start();
    ?>    
    <img id="print_fade" src="../ui/images/printer_fade.png" height="40" width="40" style="margin: 15px auto 0px 12px; display: none;">
    <img id="print" onclick="on_print_clicked()" src="../ui/images/printer.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer;">
    <script>
        
    </script>
    <?php
    $tools = ob_get_clean();
    return $tools;
}
?>