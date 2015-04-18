<?php

function get_form_html($id) {
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
    <div style="height: 150px; 
         width: 320px; background-color: #ECECEC; 
         border-radius: 5px;margin-left: auto;display: none; ">



    </div>
    <div style="margin-top: 30px; background-color:transparent;padding-bottom: 30px;">
        <form action="#" method="post" class="action_form" operation="add" style="width:100%;" >
            <table style="width:100%;">
                <tr>
                    <td class="field_name">                    
                        <font>ITEM NAME</font>
                    </td>
                    <td class="field"> 
                        <div  class="parent">
                            <input type="text" id="item_name" required />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field_name"> 
                        <font>ITEM CODE </font>
                    </td>
                    <td class="field"> 
                        <div class="parent">
                            <input type="text" id="item_code" required />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field_name"> 
                        <font>ITEM MRP </font>
                    </td>
                    <td class="field"> 
                        <div style="padding: 0px 0px;">
                            <input type="number" id="mrp" required />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field_name"> 
                        <font>PURCHACE RATE</font>
                    </td>
                    <td class="field"> 
                        <div class="parent">
                            <input type="number" id="purchace_rate" required />
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
            var id = 11;
            var operation = $(this).attr('operation');
            if (operation == 'add') {
                var data = {
                    form_id: id,
                    item_name: $('form input#item_name').val(),
                    item_code: $('form input#item_code').val(),
                    mrp: $('form input#mrp').val(),
                    purchace_rate: $('form input#purchace_rate').val()
                }
                add_form_data(data, function(message) {
                    $('form input#item_name').val('');
                    $('form input#item_code').val('');
                    $('form input#mrp').val('');
                    $('form input#purchace_rate').val('');
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
?>