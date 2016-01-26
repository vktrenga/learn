<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
<script src="jquery-ui/jquery-ui.js"></script>
<script src="js/jvalidate/jquery.validate.js"></script>
<script>
$(document).ready(function() {
	$("#msgDivContent").delay(5000).fadeOut();
});
function deleteConfirm(){
	var res=confirm("Do you want Delete ?");
	if(res){
		return true;
	}else{
		return false;
	}	
}
</script>