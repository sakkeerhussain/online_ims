<?php

function get_form_html($id) {
    ob_start();
    ?>
    <div id="head_div" style="padding: 5px 0; background-color: #ECECEC;  color: #21ACD7;
         border-radius: 5px;margin-left: auto; text-align: center; ">
        LAST 50 PURCHACES
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
                            ID
                        </td>
                        <td>
                            DATE
                        </td>
                        <td style="">
                            PURCHACED FROM
                        </td>
                        <td style="">
                            PURCHACED BY
                        </td>
                        <td>
                            AMOUNT
                        </td>
                        <td style="">
                            STOCKED
                        </td>
                        <td style="">

                        </td>
                    </tr>
                </thead>
                <tbody style="padding-left: 3px; text-align: center; ">
                    <?php
                    $purchace_obj = new purchaces();
                    $user = new user();
                    $user->id = $_SESSION['user_id'];
                    $user->getUser();
                    $purchaces = $purchace_obj->getPurchacesDESC($user->company_id);
                    $i = 0;
                    if($purchaces==NULL || sizeof($purchaces)==0){
                        echo '<tr><td colspan="8"> No Purchace Found </td></tr>';
                    } else{
                    foreach ($purchaces as $purchace) {
                        ?>
                        <tr id="<?php echo $purchace->id; ?>" onclick="select_row(this)" status="not_selected">
                            <td style="text-align: center;">
                                <?php echo ++$i; ?>
                            </td>
                            <td>
                                <?php echo $purchace->id; ?>
                            </td>
                            <td>
                                <?php echo $purchace->created_at; ?>
                            </td>
                            <?php
                                $vendor = new wendors();
                                $vendor->id = $purchace->wendor_id;
                                $vendor->getWendor();
                            ?>
                            <td id="vendor" vendor_address="<?php echo $vendor->contact_address; ?>"
                                 vendor_tin="<?php echo $vendor->wendor_tin_number; ?>"><?php 
                                echo $vendor->wendor_name; ?></td>
                            <td>
                                <?php
                                $p_manager = new user();
                                $p_manager->id = $purchace->purchace_manager_id;
                                $p_manager->getUser();
                                echo $p_manager->name;
                                ?>
                            </td>
                            <td id="amount"><?php echo $purchace->amount; ?></td>
                            <td>
                                <?php
                                if($purchace->stocked){
                                    echo "YES";
                                }else{
                                    echo 'NO';
                                }
                                ?>
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
                                <table id="purchace_items" style="border-collapse: collapse; background-color: #c0effd; width: 80%; color: #21ACD7; float: right;">
                                    <thead>
                                    <tr>
                                        <td>
                                            ITEM
                                        </td>
                                        <td>
                                            QUANTITY
                                        </td>
                                        <td>
                                            PURCHACE RATE
                                        </td>
                                        <td>
                                            MRP
                                        </td>
                                        <td>
                                            TOTAL
                                        </td>
                                    </tr>
                                    </thead> 
                                    <tbody> 
                                    <?php
                                    foreach ($purchace->getPurchaceItems() as $p_item) {
                                        ?>
                                        <tr>
                                            <td id="item_name"><?php
                                                $item = new item();
                                                $item->id = $p_item->item_id;
                                                $item->getItem();
                                                echo $item->item_name . ' ( ' . $item->item_code .' )';
                                                ?></td>
                                            <td id="quantity"><?php echo $p_item->quantity; ?></td>
                                            <?php 
                                                $tax = new tax_category();
                                                $tax->id = $item->tax_category_id;
                                                $tax->getTaxCategory();
                                            ?>
                                            <td id="rate" tax_rate="<?php echo $tax->tax_percentage; ?>"><?php 
                                                echo $p_item->rate; 
                                            ?></td>
                                            <td><?php echo $item->mrp; ?></td>
                                            <td>
                                        <?php echo ($p_item->quantity * $p_item->rate); ?>
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
        function select_row(row) {
            var j_row = $(row);
            if(j_row.attr('status') == 'selected'){
                $('table#items_table tr').attr('status', 'not_selected');
                $('table#items_table tr').css('background-color', '#FFF');
                $('img#print').css('display', 'none');
                $('img#print_fade').css('display', 'block');
            }else{            
                $('table#items_table tr').attr('status', 'not_selected');
                $('table#items_table tr').css('background-color', '#FFF');
                j_row.attr('status', 'selected');
                j_row.css('background-color', '#C0EFFD');
                $('img#print').css('display', 'block');
                $('img#print_fade').css('display', 'none');
            }          
        }
        function on_print_clicked() {
            var selected_row = $('tr[status="selected"]');
            var items_table_rows = selected_row.next('tr#purchace_item').find('table#purchace_items').find('tbody').children();
            var items = new Array();
            var i = 0;
            var tax_amount = 0;
            items_table_rows.each(function(){
                var item_row = $(this);
                var item_name = item_row.find('td#item_name').html();
                var quantity = item_row.find('td#quantity').html();
                var rate = item_row.find('td#rate').html();
                var tax_rate = item_row.find('td#rate').attr('tax_rate');
                var total = parseFloat(rate) * parseFloat(quantity);
                total = total.toFixed(2);
                var tax = (total * tax_rate) / (100 + tax_rate);
                tax_amount = tax_amount + tax;
                var item = {
                    item_name : item_name,
                    quantity : quantity,
                    rate : rate,
                    tax : tax,
                    tax_rate : tax_rate,
                    total : total
                }
                items[i++] = item;
            });
            tax_amount = tax_amount.toFixed(2);
            var vendor_name = selected_row.find('td#vendor').html();
            var vendor_address = selected_row.find('td#vendor').attr('vendor_address');
            var vendor_tin = selected_row.find('td#vendor').attr('vendor_tin');
            var amount = selected_row.find('td#amount').html();
            var id = selected_row.attr('id');
            var data = {
                id : id,
                vendor_name : vendor_name,
                vendor_address : vendor_address,
                vendor_tin : vendor_tin,
                amount : amount,
                less_discount : '0.00',
                tax_amount : tax_amount,
                items : items
            }
            print_purchace_invoice(data);
        }
        function print_purchace_invoice(data) {
                var html = '';
                html ='<font style="font-size:30px;">'+data.vendor_name+'</font><br/>'
                        +'<font>'+data.vendor_address+'</font><br/>'
                        +'<font>Tin No. &nbsp; &nbsp; '+data.vendor_tin+'</font><br/>'
                        +'<font>PURCHACE BILL</font><br/><br/>';
                $('div#print_container_header').html(html);
                html = '';
                var d = new Date();
                var date = d.getDate()+"/"+(parseInt(d.getMonth())+parseInt(1))+"/"+d.getFullYear();
                html = html + "<div<!-- style=\"padding:10px 0;\"><table style=\"float:right;\">"
                        +"<tr><td>Date</td><td>:</td><td>" + date + "</td></tr></table>";
                
                html = html + "<table>"
                        +"<tr><td>Bill No. </td><td>:</td><td>" + data.id + "</td></tr>"
                        +"<tr><td>Name </td><td>:</td><td>" + "" + "</td></tr></table></div>";
                
                html = html + "<div style=\"border-top:1px dashed #000; margin:10px auto 0 auto;padding:0 0 10px 0;\"><table style=\"width:100%;\"><tr style=\"border-bottom: 1px dashed #000; border-top: 1px dashed #000;\">"
                        + "<td style=\"width:5%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px;\">SNo</td>"
                        + "<td style=\"width:30%; border-bottom:1px dashed #000; padding-bottom:5px; margin-bottom:5px;\">COMMODITY</td>"
                        + "<td style=\"width:20%; border-bottom:1px dashed #000; border-left:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:center;\">SCH/HSN NO</td>"
                        + "<td style=\"width:10%; border-bottom:1px dashed #000; border-left:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:center;\">RATE OF TAX</td>"
                        + "<td style=\"width:10%; border-bottom:1px dashed #000; border-left:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:center;\">UNIT PRICE</td>"
                        + "<td style=\"width:10%; border-bottom:1px dashed #000; border-left:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:center;\">QTY</td>"
                        + "<td style=\"width:15%; border-bottom:1px dashed #000; border-left:1px dashed #000; padding-bottom:5px; margin-bottom:5px; text-align:center;\">PURCHACE VALUE</td></tr>";
                var i = 1;
                for (var key in data.items) {
                    var item = data.items[key];
                    html = html + "<tr><td>" + i++ + "</td>"
                            +"<td colspan=\"2\">" + item.item_name + "</td>"
                            +"<td style=\"text-align:center;\">" + item.tax_rate + "</td>"
                            +"<td style=\"text-align:center;\">" + item.rate + "</td>"
                            +"<td style=\"text-align:center;\">" + item.quantity + "</td>"
                            //+"<td style=\"text-align:center;\">" + (parseFloat(item.total) - parseFloat(item.tax)) + "</td>"
                            //+"<td style=\"text-align:center;\">" + item.tax + "</td>"
                            +"<td style=\"text-align:right;\">" + item.total + "</td>"
                            +"</tr>";
                }
                html = html + "</table></div>";
                html = html + "<div style=\"border-top:1px dashed #000; padding:10px 0;\"><table style=\"margin-left: auto;\">";
                html = html + "<tr><td>Amount</td><td style=\"margin:0 30;\"></td><td style=\"text-align:right;\">" + data.amount + "</td></tr>";
                html = html + "<tr><td>Less Discount</td><td style=\"margin:0 30;\"></td><td style=\"text-align:right;\">" + data.less_discount + "</td></tr>";
                html = html + "<tr><td>VAT</td><td style=\"margin:0 30;\"></td><td style=\"text-align:right;\">" + data.tax_amount + "</td></tr>";
                html = html + "<tr><td>Round off</td><td style=\"margin:0 30;\"></td><td style=\"text-align:right;\">" + '0.00' + "</td></tr>";
                var grand_total = (parseFloat(data.amount)+parseFloat(data.tax_amount));
                html = html + "<tr style=\"font-size:18px;\"><td><b>GRAND TOTAL</b></td><td style=\"margin:0 30;\"></td><td style=\"text-align:right;\"><b>" + grand_total + "</b></td></tr>";
                html = html + "</table></div>";
//                console.log("Creating bill : " + html);
                $('div#print_container_body').html(html);
                html = '';
                html = '<div style="width:100%;border-bottom:1px dashed #000;text-align:left;"><font>Rupees: '+toWords(grand_total)+'</font></div>';
                $('div#print_container_footer').html(html);
                print();
                $('div#print_container_header').empty();
                $('div#print_container_body').empty();
                $('div#print_container_footer').empty();
            }
       // American Numbering System
        var th = ['', 'thousand', 'million', 'billion', 'trillion'];

        var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

        var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

        var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

        function toWords(s) {
            s = s.toString();
            s = s.replace(/[\, ]/g, '');
            if (s != parseFloat(s)) return 'not a number';
            var x = s.indexOf('.');
            if (x == -1) x = s.length;
            if (x > 15) return 'too big';
            var n = s.split('');
            var str = '';
            var sk = 0;
            for (var i = 0; i < x; i++) {
                if ((x - i) % 3 == 2) {
                    if (n[i] == '1') {
                        str += tn[Number(n[i + 1])] + ' ';
                        i++;
                        sk = 1;
                    } else if (n[i] != 0) {
                        str += tw[n[i] - 2] + ' ';
                        sk = 1;
                    }
                } else if (n[i] != 0) {
                    str += dg[n[i]] + ' ';
                    if ((x - i) % 3 == 0) str += 'hundred ';
                    sk = 1;
                }
                if ((x - i) % 3 == 1) {
                    if (sk) str += th[(x - i - 1) / 3] + ' ';
                    sk = 0;
                }
            }
            if (x != s.length) {
                var y = s.length;
                str += 'point ';
                for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
            }
            return str.replace(/\s+/g, ' ');

        }
    </script>

    <?php
    $form = ob_get_clean();
    return $form;
}

function get_form_tools_html($id){
    ob_start();
    ?>    
    <img id="print_fade" src="../ui/images/printer_fade.png" height="40" width="40" style="margin: 15px auto 0px 12px;">
    <img onclick="on_print_clicked()" id="print" onclick="" src="../ui/images/printer.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer; display: none;">
    <script>
        
    </script>
    <?php
    
    $tools = ob_get_clean();
    return $tools;
}
?>