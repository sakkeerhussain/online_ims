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
                    $sales = $sale_obj->getLastWeeksSales($user->company_id);
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
                                            <td id="tax" val="<?php echo $s_item->tax; ?>">
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
        function on_edit_clicked(){
            var selected_row = $('tr[status="selected"]');
            var sale_items_table = selected_row.next('tr').find('table#sale_items');
            var sale_items = sale_items_table.find('tbody').children();
            var items = new Array();
            var i = 0;
            sale_items.each(function() {
                var item_name = $(this).find('td#item').html();
                var id = $(this).attr('id');
                var quantity = $(this).find('td#quantity').attr('val');
                var rate = $(this).find('td#rate').attr('val');
                var tax = $(this).find('td#tax').attr('val');
                var total = $(this).find('td#total').attr('val');
                var item = {
                     id: id,
                     quantity: quantity,
                     rate: rate,
                     item_name: item_name,
                     total: total,
                     tax: tax
                }
                items[i++] = item;
             });
             var c_name = selected_row.find('td#customer').attr('c_name');
             var c_id = selected_row.find('td#customer').attr('c_id');
             var sale_id = selected_row.attr('id');
             var total = selected_row.find('td#total').html();
             var total_tax = selected_row.find('td#tax').html();
             var net_total = selected_row.find('td#net_amount').html();
             get_form(2,  ///sales return invoice
                function (html, tools){
                    $('div#form-body').html(html);
                    $('div#content-body-action-tools').html(tools);
                    var form = $('div#form-body').find('form.action_form');
                    form.attr('operation', 'update');
                    form.find('input#customer_id').val(c_name+' ( ID : '+c_id+' )');
                    form.find('input#customer_id').attr('disabled', 'disabled');
                    $('table#items_table tbody').empty();
                    for(var i = 0; i<items.length; i++){
                        add_sale_item();
                        var row = $('table#items_table tbody tr:last-child');
                        var item = items[i];
                        row.find('input#item').attr('disabled', 'disabled');
                        row.find('input#item').val(item.item_name);
                        row.find('input#quantity').val(item.quantity);
                        row.find('input#quantity').attr('max', item.quantity);
                        row.find('input#rate').val(item.rate);
                        row.find('input#rate').attr('tax', (item.tax/item.total)*100);
                        row.find('input#total').val(item.total);
                        row.find('input#total').attr('tax', item.tax);
                    } 
                    form.find('span#total').html(total);
                    form.find('span#total_paid').html(total);
                    form.find('span#balance').html(0.00);
                    form.attr('sale_id', sale_id);
                    form.attr('customer_name', c_name);
                    form.attr('customer_id', c_id);
                },
                function (message){
                    $('font#section_heading').empty();
                    $('div#form-body').empty();
                    alert(message);
                }
             );
        }
        function on_print_clicked() {
            var selected_row = $('tr[status="selected"]');
            var sale_items_table = selected_row.next('tr').find('table#sale_items');
            var sale_items = sale_items_table.find('tbody').children();
            var items = new Array();
            var i = 0;
            sale_items.each(function() {
                var item_name = $(this).find('td#item').attr('item_name');
                var id = $(this).attr('id');
                var quantity = $(this).find('td#quantity').attr('val');
                var rate = $(this).find('td#rate').attr('val');
                var tax = $(this).find('td#tax').attr('val');
                var total = $(this).find('td#total').attr('val');
                total = parseFloat(total);
                total = total.toFixed(2);
                var item = {
                     id: id,
                     quantity: quantity,
                     rate: rate,
                     item_name: item_name,
                     total: total,
                     tax: tax
                }
                items[i++] = item;
             });
             var c_name = selected_row.find('td#customer').attr('c_name');
             var c_id = selected_row.find('td#customer').attr('c_id');
             if(c_id == 0){
                 c_name = 'Not Regd.';
             }
             var sale_id = selected_row.attr('id');
             var total = selected_row.find('td#total').html();
             total = parseFloat(total);
             total = total.toFixed(2);
             var total_tax = selected_row.find('td#tax').html();
             total_tax = parseFloat(total_tax);
             total_tax = total_tax.toFixed(2);
             var net_total = selected_row.find('td#net_amount').html();
             net_total = parseFloat(net_total);
             net_total = net_total.toFixed(2);
             var data = {
                  customer_id: c_id,
                  total: total,
                  net_amount: net_total,
                  tax_amount: total_tax,
                  items: items
             }
             print_bill(data, c_name, sale_id);
        }
        function print_bill(data, customer_name, sale_id) {
                var html = '';
                html ='<img id="logo_bill" src="images/nutiez.png"/><br/><font id="print_container_header_company_adderss">Royal Piknik Traders LLP, 29/861</font>'
                        +'<br/><font id="print_container_header_company_adderss">Parayancheri, Calicut</font><br/><font id="print_container_header_company_adderss">'
                        +'Phone : 0495 2741095,+91 9388627725</font><br/><font id="print_container_header_company_adderss">The kerala value added tax rules 2005/ form no. 8</font>';
                $('div#print_container_header').html(html);
                html = '';
                var d = new Date();
                var date = d.getDate()+"/"+(parseInt(d.getMonth())+parseInt(1))+"/"+d.getFullYear();
                var hour = d.getHours();
                var am_or_pm;
                if(hour<12){
                    am_or_pm = "AM";
                }else{                    
                    am_or_pm = "PM";
                }
                if(hour==0){
                    hour = 12;
                }else if(hour>12){                    
                    hour = parseInt(hour)-parseInt(12);
                }              
                var minut = d.getMinutes();
                if(minut<10){
                    minut = "0"+minut;
                }
                var time = hour+":"+minut+" "+am_or_pm;
                html = html + "<div<!-- style=\"padding:10px 0;\"><table style=\"float:right;\">"
                        +"<tr><td>Date</td><td>:</td><td>" + date + "</td></tr>"
                        +"<tr><td>Time</td><td>:</td><td>" + time + "</td></tr></table>";
                
                html = html + "<table>"
                        +"<tr><td>Bill No.</td><td>:</td><td>" + sale_id + "</td></tr>"
                        +"<tr><td>Cust. ID</td><td>:</td><td>" + data.customer_id + "</td></tr>"
                        +"<tr><td>Cust. Name</td><td>:</td><td>" + customer_name + "</td></tr></table></div>";
                
                html = html + "<div style=\"border-top:1px dashed #000; margin:10px auto 0 auto;padding:0 0 10px 0;\"><table style=\"width:100%;\"><tr style=\"border-bottom: 1px solid #000; border-top: 1px solid #000;\">"
                        + "<td style=\"width:45%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px;\">Description</td>"
                        + "<td style=\"width:17%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:right;\">Qty</td>"
                        + "<td style=\"width:17%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:right;\">Rate</td>"
                        // + "<td style=\"width:15%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:right;\">Amount</td>"
                        // + "<td style=\"width:10%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:right;\">Tax</td>"
                        + "<td style=\"width:21%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:right;\">Total</td></tr>";
                var i = 0;
                for (var key in data.items) {
                    var item = data.items[key];
                    html = html + "<tr><td>" + item.item_name + "</td>"
                            +"<td style=\"text-align:right;\">" + item.quantity + "</td>"
                            +"<td style=\"text-align:right;\">" + item.rate + "</td>"
                            //+"<td style=\"text-align:right;\">" + (parseFloat(item.total) - parseFloat(item.tax)) + "</td>"
//                            +"<td style=\"text-align:right;\">" + item.tax + "</td>"
                            +"<td style=\"text-align:right;\">" + item.total + "</td>"
                            +"</tr>";
                }
                html = html + "</table></div>";
                html = html + "<div style=\"border-top:1px dashed #000; padding:10px 0;\"><table style=\"margin-left: auto;\">";
                html = html + "<tr><td>Net. Amount</td><td style=\"margin:0 15;\">:</td><td style=\"text-align:right;\">" + data.net_amount + "</td></tr>";
                html = html + "<tr><td>Tax</td><td style=\"margin:0 15;\">:</td><td style=\"text-align:right;\">" + data.tax_amount + "</td></tr>";
                html = html + "<tr style=\"font-size:18px;\"><td><b>Total</b></td><td style=\"margin:0 15;\">:</td><td style=\"text-align:right;\"><b>" + data.total + "</b></td></tr>";
                html = html + "</table></div>";
//                console.log("Creating bill : " + html);
                $('div#print_container_body').html(html);
                html = '';
                html = '<font>Thank you for shoping</font><br/><font>Visit again...</font> ';
                $('div#print_container_footer').html(html);
                print();
                $('div#print_container_header').empty();
                $('div#print_container_body').empty();
                $('div#print_container_footer').empty();
            }
        function select_row(row) {
            var j_row = $(row);
            if(j_row.attr('status') == 'selected'){
                $('table#items_table tr').attr('status', 'not_selected');
                $('table#items_table tr').css('background-color', '#FFF');
                $('img#edit').css('display', 'none');
                $('img#edit_fade').css('display', 'block');
                $('img#print').css('display', 'none');
                $('img#print_fade').css('display', 'block');
            }else{            
                $('table#items_table tr').attr('status', 'not_selected');
                $('table#items_table tr').css('background-color', '#FFF');
                j_row.attr('status', 'selected');
                j_row.css('background-color', '#C0EFFD');
                $('img#edit').css('display', 'block');
                $('img#edit_fade').css('display', 'none');
                $('img#print').css('display', 'block');
                $('img#print_fade').css('display', 'none');
            }          
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
    ?>    
    <img id="edit_fade" src="../ui/images/edit_fade.png" height="40" width="40" style="margin: 15px auto 0px 12px;">
    <img id="edit" onclick="on_edit_clicked()" src="../ui/images/edit.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer; display: none;">
    <img id="print_fade" src="../ui/images/printer_fade.png" height="40" width="40" style="margin: 15px auto 0px 12px;">
    <img id="print" onclick="on_print_clicked()" src="../ui/images/printer.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer; display: none;">
    <script>
        
    </script>
    <?php
    $tools = ob_get_clean();
    return $tools;
}
?>