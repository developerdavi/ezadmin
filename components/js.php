<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/materialize.js" type="text/javascript"></script>
<script type="text/javascript">
	  $(document).ready(function(){
		  $('.sidenav').sidenav();
		  $('.dropdown-trigger').dropdown();
		  $('.collapsible').collapsible();
		  $('.tooltipped').tooltip();
		  $('.modal').modal();
		  $('select').formSelect();
          $('.tabs').tabs();
		});
</script>
<script src="ace-builds-master/src-min-noconflict/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/mysql");

    // pass options to ace.edit
    ace.edit(editor, {
        mode: "ace/mode/javascript",
        selectionStyle: "text"
    })
    // use setOptions method to set several options at once
    editor.setOptions({
        autoScrollEditorIntoView: true,
        copyWithEmptySelection: true,
    });
    // use setOptions method
    editor.setOption("mergeUndoDeltas", "always");
    document.getElementById('editor').style.fontSize='18px';
</script>