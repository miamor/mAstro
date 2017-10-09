<div class="borderwrap">
	<div class="maintitle floated dropped">
		<h3>Edit </h3>
	</div>
	<form action="?do=edit" id="edit-topic" class="edit-topic bootstrap-validator-form maincontent" style="padding:15px 0" id="new-topic">
		<div class="form-group">
			<div class="col-lg-3 control-label no-padding-right">Title</div>
			<div class="col-lg-9"><input type="text" name="title" class="form-control" value="<? echo $title ?>"/></div>
			<div class="clearfix"></div>
		</div>

		<div class="form-group">
			<div class="col-lg-3 control-label no-padding-right">Content</div>
			<div class="col-lg-9"><textarea name="content"><? echo htmlentities($content) ?></textarea></div>
			<div class="clearfix"></div>
		</div>

		<div class="add-form-submit center">
			<input type="reset" value="Reset" class="btn btn-default">
			<input type="submit" value="Submit" class="btn">
		</div>
	</form>
</div>
