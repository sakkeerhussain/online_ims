<?php

function get_form_html($form_id, $id) {
    ob_start();
    ?>
    <style>
        .field_name{
            width: 20%;
        }
        .field input{
            width: 100%;
            margin-left: 0px;
        }
        .field .parent{
            padding: 0px 0px;
        }
        .field select{
            width: 100%;
        }
    </style>
    <div id="head_div" style="padding: 5px 0; background-color: #ECECEC;  color: #21ACD7;
         border-radius: 5px;margin-left: auto;display: none; text-align: center; ">
    </div>
    <?php
    $tax_category = new tax_category();
    if($id != 0){
      $tax_category->id = $id;
      $tax_category->getTaxCategory();
    }
    ?>
    <div style="margin-top: 10px; background-color:transparent;padding-bottom: 30px;">
        <form action="#" method="post" class="action_form" operation="add" style="width:100%;" >
            <table style="width:100%;">
                <tr>
                    <td class="field_name">                    
                        <font>TAX CATEGORY NAME</font>
                    </td>
                    <td class="field"> 
                        <div  class="parent">
                            <input value="<?php echo $tax_category->tax_category_name; ?>" type="text" id="tax_category_name" required placeholder="eg:5%"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field_name"> 
                        <font>TAX(%)</font>
                    </td>
                    <td class="field"> 
                        <div class="parent">
                            <input value="<?php echo $tax_category->tax_percentage;?>" type="number" step="any" id="tax_percent" required placeholder="eg:5"/>
                        </div>
                    </td>
                </tr>
                <tr></tr>
                <tr>
                    <td></td>
                    <td>
                        <div style="padding: 0px 12px;">
                            <div style="width: 100%; margin-left: -12px; padding: 12px; 
                                 background-color: #0d92bb; border-radius: 5px; float: left;">
                                <div style="width: 50%; float: right;  ">
                                     <input style="width: 100%;" type="submit" value="ADD" />
                                </div>
                                <div style="width: 50%;">
                                    <input style="width: 100%;" type="reset" value="CANCEL" />
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">
        function setFormActionListener(){ 
        $('form.action_form').on('submit', function(e) {
            e.preventDefault();
            var id = 42;
            var operation = $(this).attr('operation');
            if (operation == 'add') {
                var data = {
                    form_id: id,
                    tax_category_name: $('form input#tax_category_name').val(),
                    tax_percent: $('form input#tax_percent').val()
                }
                add_form_data(data, function(message) {
                    load_tax_category_list();
                    alert(message);
                }, function(message) {
                    alert(message);
                });
            }else if (operation == 'update') {
                var tax_category_id = $(this).attr('tax_category_id');
                var data = {
                    form_id: id,
                    tax_category_id: tax_category_id,
                    tax_category_name: $('form input#tax_category_name').val(),
                    tax_percent: $('form input#tax_percent').val()
                }
                update_form_data(data, function(message) {
                    load_tax_category_list();
                    alert(message);
                }, function(message) {
                    alert(message);
                });
            } else {
                alert("Invalid Operation " + id + ' - ' + operation);
            }
        });
        };
        setFormActionListener();
    </script>
    <?php

    $form = ob_get_clean();
    return $form;
}

function get_form_tools_html($id){
    ob_start();
    ?>    
    <img onclick="load_vendors_list()" src="../ui/images/list_icon.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer;">
    <script>
        function load_tax_category_list(){
            get_form(41,
                function(html, tools) {
                    $('div#form-body').html(html);
                    $('div#content-body-action-tools').html(tools);
                }, function(message) {
                    $('font#section_heading').empty();
                    alert(message);
                });
        }
    </script>
    <?php
    $tools = ob_get_clean();
    return $tools;
}
?>