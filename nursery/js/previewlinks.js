$(function() {
	$.fn.setPreviewLinksHandler = function(id, data) {
		$("a[name=previewLink]").click(function() {
			var link = $(this);
			$.get(link.attr('href'), function(data) {
				$('#preview').html(data);
			});
			$("#viewdialog").dialog("open");
			return false;
		});
	};
	$.fn.setPreviewLinksHandler();
});