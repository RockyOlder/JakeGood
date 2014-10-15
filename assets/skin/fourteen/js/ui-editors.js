$(function () {
    //BEGIN BOOTSTRAP WYSIWYG5
    $('.wysihtml5').wysihtml5();
    //END BOOTSTRAP WYSIWYG5

    //BEGIN CKEDITOR
    CKEDITOR.disableAutoInline = true;
    //END CKEDITOR

    //BEGIN SUMMERNOTE EDITOR
    $('#summernote-default').summernote({
		toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link']],
        ['view', ['fullscreen', 'codeview']],
        ['help', ['help']]
      ],
	});
	$('.note-codable').attr('name', 'content');
	
    $('#summernote-edit').click(function() {
        $('.click2edit').summernote({focus: true});
    });
    $('#summernote-save').click(function() {
        var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
        $('.click2edit').destroy();
    });
    //END SUMMERNOTE EDITOR
});
