<style>
    .field_name{
        width: 20%;
    }
    .field{
        width: 50%;
    }
    .field input{
        width: 94%;
    }
</style>
<div style="height: 150px; 
     width: 320px; background-color: #ECECEC; 
     border-radius: 5px;margin-left: auto;display: none; ">



</div>
<div style="margin-top: 30px; background-color:transparent;padding-bottom: 100px;">
    <form action="#" method="post" id="11" class="action_form" operation="add" style="width:100%;" >
        <table style="width:100%;">
            <tr>
                <td class="field_name">                    
                    <font>ITEM NAME</font>
                </td>
                <td class="field"> 
                    <input type="text" id="item_name" required />
                </td>
            </tr>
            <tr>
                <td class="field_name"> 
                    <font>ITEM CODE </font>
                </td>
                <td class="field"> 
                    <input type="text" id="item_code" required />
                </td>
            </tr>
            <tr>
                <td class="field_name"> 
                    <font>ITEM MRP </font>
                </td>
                <td class="field"> 
                    <input type="number" id="mrp" required />
                </td>
            </tr>
            <tr>
                <td class="field_name"> 
                    <font>PURCHACE RATE</font>
                </td>
                <td class="field"> 
                    <input type="number" id="purchace_rate" required />
                </td>
            </tr>
            <tr></tr>
            <tr>
                <td></td>
                <td>
                    <div style="width: 95%; padding: 10px; background-color: #0d92bb; border-radius: 5px;">
                    <input style="margin-right: 0; margin-right: 1%; width: 48%;" type="submit" value="ADD" />
                    <input style="margin-right: 0; margin-left: 1%; width: 48%;" type="reset" value="CANCEL" /> 
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>