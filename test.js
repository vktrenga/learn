$("#rolefrm").submit(function() {
	$("#rolefrm").validate({
		rules : {
			sys_role : {
				required : true,
			}
		}
	});
});