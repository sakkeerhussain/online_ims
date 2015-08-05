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
    $user = new user();
    $user->id = $_SESSION['user_id'];
    $user->getUser();
    
    $user_type = new user_type();
    $user_type->id = $user->user_type_id;
    $user_type->getUserType();
    ?>
    <div style="margin-top: 10px; background-color:transparent;padding-bottom: 30px;">
        <form action="#" method="post" class="action_form" operation="update" style="width:100%;" >
            <table style="width:100%;">
                <tr>
                    <td class="field_name">                    
                        <font>USER NAME</font>
                    </td>
                    <td class="field"> 
                        <div  class="parent">
                            <input value="<?php echo $user->user_name; ?>" type="text" id="user_name" disabled="disabled" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field_name">                    
                        <font>USER TYPE</font>
                    </td>
                    <td class="field"> 
                        <div  class="parent">
                            <input value="<?php echo $user_type->user_type_name; ?>" type="text" id="user_type"  disabled="disabled" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field_name"> 
                        <font>PASSWORD </font>
                    </td>
                    <td class="field"> 
                        <div class="parent">
                            <input value="" type="password" id="password" required autocomplete="off" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="field_name"> 
                        <font>RE-ENTER PASSWORD </font>
                    </td>
                    <td class="field"> 
                        <div class="parent">
                            <input value="" type="password" id="password_copy" required autocomplete="off" />
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
            var id = 39;
            var operation = $(this).attr('operation');
            if (operation == 'update') {
                var company_id = $('form.action_form').attr('company_id');
                var data = {
                    form_id: id,
                    password:$('form input#password').val(),
                    password_copy: $('form input#password_copy').val()
                }
                update_form_data(data, function(message) {
                    load_shops_list();
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
    <img onclick="load_shops_list()" src="../ui/images/list_icon.png" height="40" width="40" style="margin: 15px auto 0px 12px; cursor: pointer;">
    <script>
        function load_shops_list(){
            get_form(26,
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