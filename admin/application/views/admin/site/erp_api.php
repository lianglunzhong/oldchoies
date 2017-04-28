<link type="text/css" href="/media/js/jquery-ui/jquery-ui-1.8.1.custom.css" rel="stylesheet" id="uistyle" /> 
<script type="text/javascript" src="/media/js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="/media/js/jquery-ui-1.8.1.custom.min.js"></script> 
<style type="text/css">
label, input, textarea {display:block}
label {font-weight:bold}
</style>
<form id="frm-erp-api" action="" method="post">
    <input type="hidden" name="server_url" value="http://jira.cofreeonline.com/OralceInfTest/index.jsp" />
    <input type="hidden" name="domain" value="ezclickoptical.com" />
    <label for="option">Option</label>
    <select name="option" id="option">
        <option value="processB2COrder">processB2COrder</option>
        <option value="orderGL">orderGL</option>
    </select>
    <label for="param">Param</label>
    <textarea id="param" name="param" style="width:520px;height:240px"></textarea>
    <input type="button" id="btn-submit" value="Submit" />
    <label for="result">Result</label>
    <textarea id="result" style="width:520px;height:240px"></textarea>
</form>
<script type="text/javascript">
$('#btn-submit')
    .button()
    .click(function() {
        $.ajax({
            "url": "/admin/site/erp/api", 
            "type": "POST", 
            "data": $('#frm-erp-api').serialize(), 
            "success": function (data) {
                $('#result').val(data);
            }
        });
    });
</script>
