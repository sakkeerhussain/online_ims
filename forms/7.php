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
    .field select{
        width: 98%;
    }
</style>
<div style="height: 150px; 
     width: 320px; background-color: #ECECEC; 
     border-radius: 5px;margin-left: auto;display: none; ">



</div>
<div style="margin-top: 30px; background-color:transparent;padding-bottom: 100px;">
    <form action="#" method="post" id="11" class="action_form" operation="add" style="width:100%;">
        <table style="width:100%;">
            <tr>
                <td class="field_name">                    
                    <font>WENDOR</font>
                </td>
                <td class="field"> 
                    <select>
                      <?php                         
                            $wendors =  new Wendors();
                            $wendors->getWendors;
                            foreach ($wendors as $wendor) {
                                echo '<option id="'.$wendor->id.'">'.$wendor->wendor_name.' ('.$wendor->id.')</option>';
                            } 
                        ?>                  
                    </select>
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
                <td colspan="2">
                    <style>
                        div#purchace_items td{
                            border: 1px solid #21ACD7;
                        }
                    </style>
                    <div id="purchace_items" style="width: 100%; padding: 10px 0; color: #21ACD7;">
                        <table style="border-collapse: collapse; width: 98%; background-color: #fff; border-radius: 10px;">
                            <thead style="text-align: center;">
                                <tr>
                                    <td>
                                        #
                                    </td>
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
                                        TOTAL
                                    </td>
                                </tr>
                            </thead>
                            <tbody style="padding-left: 3px;">
                                <tr>
                                    <td>
                                        #
                                    </td>
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
                                        TOTAL
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        #
                                    </td>
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
                                        TOTAL
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        #
                                    </td>
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
                                        TOTAL
                                    </td>
                                </tr>
                            </tbody>                               
                        </table>
                    </div>
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