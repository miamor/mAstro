$(function () {
	$('#ot').change(function () {
		val = $(this).val();
		$('.data-list').load(MAIN_URL+'/report/'+old_rid+'?v=window&type=related&ot='+val+'&iid='+old_rid+' .data-list > div', function (data) {
			selectReport(old_rid, code);
		})
	})
})
