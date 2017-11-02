<script language="javascript">
    $(document).ready(function(){
        $('#back').click(function(){
            loadPage('index.php?admin/examsresult');
        });
        $('.Update').click(function(){
            id = $(this).attr('id');
            if ( $(this).val() == 'Edit' ){
                $('#'+id+'txt').attr('disabled',false);
                $(this).val('Update');
            }else{
                if ( $('#'+id+'txt').val() != '' ){
                    $.post('index.php?admin/rateupdate',{'score': $('#'+id+'txt').val(),'transaction_dtl_id':$(this).attr('id')},function(){
                        loadPage('index.php?admin/checkresult&exam_id='+$('#exam_id').val()+'&user_id='+$('#user_id').val());
                    });
                }else{
                    alert('Input Score');
                }
			
            }
        });
        $('#check_status').change(function(){
            $.post('index.php?admin/checkstatus',{'status': $(this).val(), 'user_id':$('#user_id').val(), 'exam_id': $('#exam_id').val()});

            //alert($(this).val());
        }); 
    });
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
<style>
    .table-new {border:1px solid #00688B;text-align: center; margin-left:50px;}
    .table-new tbody{border: 1px solid #00688B;}
    .line {text-align: left;border-right: 1px solid #00688B;padding-right: 2px;margin-right: 5px;border-top: 1px solid #00688B;font-family: 'Lucida Grande',Helvetica,Arial,Verdana,sans-serif; font-size: 0.8em; color: #535353!important;}
    .line1{border-top: 1px solid #00688B;font-family: 'Lucida Grande',Helvetica,Arial,Verdana,sans-serif; font-size: 0.8em; color: #535353!important;}
    .line2{border-right: 1px solid #00688B;font-family: 'Lucida Grande',Helvetica,Arial,Verdana,sans-serif; font-size: 0.8em; color: #535353!important; font-weight:bold;}


    .error-msg{
        overflow:hidden;
        width:900px; 
    }
    .error-msg h5{
        overflow:hidden;
        color:#F00;
        text-transform:uppercase;
        background: white;
    }
    .mcstyle{
        font-family: 'Lucida Grande',Helvetica,Arial,Verdana,sans-serif; font-size: 0.8em; color: #535353!important;
    }
</style>
<table width="90%" style="margin-left:50px;font-size: 16px; color: #535353;">

    <tr>
        <td>
            Examinee Name : <?php echo '<b>' . $data['transaction_dtl'][0]['user_lname'] . ', ' . $data['transaction_dtl'][0]['user_fname'] . '</b>'; ?>
        </td>
        <td align="right"> <b> Check Status :</b>
        <select id="check_status">
            <option <?php echo ( $data['transaction_dtl'][0]['check_status'] == 1 ) ? 'selected' :'' ; ?> value="1"> Checked </option> 
            <option <?php echo ( $data['transaction_dtl'][0]['check_status'] == 0 ) ? 'selected' :'' ; ?> value="0"> Not Yet </option> 
        </select>
        </td>
        <td align="right">
            <input type="button" value="Back" id="back">
        </td>
    </tr>
</table>

<table width="90%" class="table-new" border="0" cellspacing="0" cellpadding="5">
    <tr class="tr-head">
        <td width="250" align="center" class="line2"><b> Questions  </b></td>
        <td width="100" align="center" class="line2"><b> Answers </b></td>
        <td width="100" align="center" class=""><b> Scores </b></td>
    </tr>
    <?php
    $cnt = 0;
    $correct = 0;
    if (is_array($data['transaction_dtl'])) {
        foreach ($data['transaction_dtl'] as $row) {
            $cnt++;
            if ($row['israted'] <> 0) {
                $correct += $row['score'];
            }
            ?>
            <tr>
                <td align="" class="line" width="350"> <?php echo $cnt . '. ' . $row['question_name']; ?> <?php //echo ($row['question_type'] == 1 ? "<span style='color:red;'> (essay) </span>" : '');   ?> </td>
                <?php
                if ($row['israted'] == 0) {
                    ?>
                    <td class="line" width="650"> <span style="color: black"><?php echo $row['essay']; ?> </span></td>
                    <?php
                } else {
                    ?>
                    <td class="line" width="650"> <span style="<?php echo ($row['score'] == 0 ? 'color: red' : 'color:green'); ?>"><?php echo ($row['answer_name'] != '' ? $row['answer_name'] : $row['essay']); ?> </span></td>
                    <?php
                }
                ?>
                <?php
                $transaction_dtl_id = $row['transaction_dtl_id'];
                $url = 'index.php?admin/rate&transaction_dtl_id=' . $transaction_dtl_id . '&exam_id=' . $data['exam_id'][0] . '&user_id=' . $data['user_id'][0];
                ?>
                <td align="center" class="line1" width="130">
                    <?php
                    if ($row['israted'] == 0) {
                        //echo $row['essay_points'];
                        if ($row['essay_points'] > 0) {
                            echo "<select disabled  id='" . $row['transaction_dtl_id'] . 'txt' . "'>";
                            for ($i = 0; $i <= $row['essay_points']; $i++) {

                                echo "<option value=$i> $i  </option>";
                            }
                            echo "</select>";
                        }
                        ?>
                        <input type="button" value="Edit" class="Update" id="<?php echo $row['transaction_dtl_id']; ?>" style="width: 54px; height:25px;">
                        <!--
                                <input type="text" disabled id="<?php // echo $row['transaction_dtl_id'] . 'txt';   ?>" style="width:30px;height:25px;" onkeypress="return isNumberKey(event)">
                                <input type="button" class="correct" value="Correct" id="<?php //echo $row['transaction_dtl_id'];    ?>"> 
                                <input type="button" class="wrong" value="Wrong" id="<?php //echo $row['transaction_dtl_id'];    ?>">
                        -->
                        <?php
                    } else {
                        echo '<center>' . $row['score'] . '</center>';
                    }
                    ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>
<div style="float:right; padding-right: 40px; margin-right:10px;" class="mcstyle">
    <table class="mcstyle" style="font-size: 13px;">
        <tr>
            <td align="right"> <b> Score: </b></td>
            <td> <b> <?php echo $correct . ' out of ' . $data['exam_name'][0]['passing_score']; ?></b> </td>
        </tr>
        <tr>
            <td align="right"> <b>Grade: </b> </td>
            <td> 
                <b>
                    <?php
                    $grade = ($correct / $data['exam_name'][0]['passing_score']) * 100;
                    echo $grade . '%';
                    ?>  
                </b> 
            </td>
        </tr>
        <tr>
            <td align="right"> <b> Remark: </b></td>
            <td> 
                <?php
                if ($grade >= $data['exam_name'][0]['passing_grade']) {
                    echo "<span style='color: green;'><b>Passed</b></span>";
                } else {
                    echo "<span style='color: red;'><b>Failed</b></span>";
                }
                ?>
            </td>
        </tr>
    </table>
</div>

<input type="hidden" id="exam_id" value="<?php print_r($data['exam_id']); ?>">
<input type="hidden" id="user_id" value="<?php print_r($data['user_id']); ?>">