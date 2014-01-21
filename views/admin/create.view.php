
<script src="<?php echo URL;?>/static/markdown/js/jquery.pagedown-bootstrap.combined.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL;?>/static/markdown/css/jquery.pagedown-bootstrap.css">
<div class="span1"></div>
<div class="span10" id="post-admin">
	<?php
		if (isset($data['status'])) {
			echo '	<div class="alert alert-success">';
			echo '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
			echo($data['status']);
			echo '<a href="../admin" class="alert-link pull-right"> &larr; Go back</a>';
			echo '	</div>';
		}
	?>
	<h1>Create A New Post</h1>
	
	<form action="" method="post">
		
			 <div><label for="Title">Title</label>
	      		<input type="text" name="title" id="title" required="required" />
	  		</div>
			<label for="content">Content</label>
				<p><textarea name="content" id="content" cols="40" rows="8" class="span10"></textarea></p>
			
			<div class="submit"><input type="submit" name="btn_submit" value="Save"/></div>	
	</form>
	

</div>

<script type="text/javascript">
$("textarea#content").pagedownBootstrap({
'sanatize': false,
'help': function () { alert("Do you need help?"); },
'hooks': [
{
'event': 'preConversion',
'callback': function (text) {
return text.replace(/\b(a\w*)/gi, "*$1*");
}
},
{
'event': 'plainLinkText',
'callback': function (url) {
return "This is a link to " + url.replace(/^https?:\/\//, "");
}
}
]
});
</script>