(function($){$.stripslashes=function(str){if (str == '') { return str; }str=str.replace(/\\'/g,'\'');str=str.replace(/\\"/g,'"');str=str.replace(/\\/g,'');str=str.replace(/\\\\/g,'\\');str=str.replace(/\\0/g,'\0');return str;}; /** Stripslashes jquery function **/
})(jQuery);
jQuery(document).ready(function($){

	var tinyMCE = tinyMCE || window.tinymce;

	var list_admin = $('#simpledoc_list');

	var editor = $('#smpldoc_editor'),
		input = $('#smpldoc_input'),
		file = $('#smpldoc_file');

	var list_sw = $('#sd_list'),
		add_sw = $('#sd_add'),
		swtch_btn = $('#swtch_btn'),
		current = 'list';

	var import_button  = $('#sd_import_button'),
		import_text    = $('#sd_import'),
		export_button  = $('#sd_export_button'),
		export_options = $('#sd_export_options'),
		export_text    = $('#sd_export');

	/** Retrieve icon from item type **/
	function i(type){
		switch(type){
		    case 'video':
		    	return 'youtube-play';
		    case 'link':
		    	return 'link';
		    case 'file':
		    	return 'files-o';
		    default:
		    	return 'comments';
	    }
	}

	/** Reset the main form **/
	function resetFormView(){

		var editor = tinyMCE.get( 'smpldoc_item_content' );

		if (editor) {
			editor.setContent('');
		} else {
			$('#smpldoc_item_content').val('');
		}

		$('#smpldoc_item_title').val('');
		$('#item_type').val('nope');
		$('#smpldoc_item_link').val('');
		$('#smpldoc_item_file').val('');
		$('.smpldoc_item_users').removeAttr('checked');
		$('#sd_add').find('ul.add_list').find('li').removeClass('smpldoc_active').removeClass('smpldoc_disabled');
	}

	/** Shortcut function to get back to the list view **/
	function viewList(){
		add_sw.fadeOut(function(){
			list_sw.fadeIn();
			current = 'list';
			swtch_btn.html( simple_documentation_vars.add_new );
		});

		resetFormView();
	}

	/** Expand items to see the content **/
	list_admin.on( 'click' , 'li', function(e){
		var _this = $(this);
		var delay = 0;

		$('.hover').each(function(){
			var _this2 = $(this);
			if(_this2.attr('id') != _this.attr('id')){
				$('.hover').find('.el_expand').animate({
					height: 'toggle',
					paddingTop: 'toggle',
					paddingBottom: 'toggle'
				}, 300, function(){
					_this2.removeClass('hover');
				});
			}
		});

		_this.find('.el_expand').animate({
			height: 'toggle',
			paddingTop: 'toggle',
			paddingBottom: 'toggle'
		}, 700 );

		setTimeout(function(){
			if( _this.hasClass( 'hover' ) ) _this.removeClass( 'hover' );
			else _this.addClass( 'hover' );
		}, delay);
	});

	/** Switch Between Views ( List | Add ) **/
	swtch_btn.on( 'click', function(e){
		e.preventDefault();

		if( current === 'list' ){

			list_sw.fadeOut(function(){
				add_sw.fadeIn();
				current = 'add';
				swtch_btn.html( simple_documentation_vars.view_list );
			});

		}else{

			viewList();

		}

	});

	function setupFieldsFromType(type, data){

		$('#item_type').val(type);

		var content = '',
			attachment = 0,
			attachment_url = '',
			attachment_filename = '',
			title = '';

		$('#smpldoc_additem').attr('data-action', 'add').text( simple_documentation_vars.add_item );

		if(data !== undefined){

			title = data.title;
			content = data.content;
			attachment = data.attachment_id;
			attachment_url = data.attachment_url;
			attachment_filename = data.attachment_filename;

			$('#item_id').val( data.ID );

			$('.add_list').find('li').addClass('smpldoc_disabled');
			$('#smdoc_'+data.type+'_cat').parent('li').removeClass('smpldoc_disabled').addClass('smpldoc_active');

			$('#smpldoc_additem').attr('data-action', 'edit').text( simple_documentation_vars.save_changes );

			if(data.restricted){
				$('.smpldoc_item_users').each(function(){
					var role = $(this);
					if( data.restricted.indexOf(role.val()) !== -1 ) role.attr('checked', '');
				});
			}
		}

		$('#smpldoc_item_title').val( title );

		if(type=='note'||type=='video'){
			input.fadeOut(200).val( '' );
			file.fadeOut(200).val( '' );

			var editorW = tinyMCE.get( 'smpldoc_item_content' );

			if (editorW) {
				editorW.setContent(content);
			} else {
				$('#smpldoc_item_content').val(content);
			}

			editor.delay(200).fadeIn(100);
		}else if(type=='file'){
			input.fadeOut(200).val('');
			editor.fadeOut(200).val('');
			$('#smpldoc_item_file').val( attachment );
			file.delay(200).fadeIn(100);
			if (attachment_url && attachment_filename) {
				$('#smpldoc_filename').html( '<a href="'+attachment_url+'">'+(attachment_filename || '')+'</a>' );
			} else {
				$('#smpldoc_filename').html('');
			}
		}else if(type=='link'){
			editor.fadeOut(200).val('');
			file.fadeOut(200).val('');
			$('#smpldoc_item_link').val( content );
			input.delay(200).fadeIn(100);
		}

	}

	/** Choose category between in the form view **/
	$('#sd_add').find('ul.add_list').on('click', 'a', function(e){
		e.preventDefault();
		var link = $(this);
		var type = link.attr('data-type');

		$('#sd_add').find('ul.add_list').find('li').removeClass('smpldoc_active').addClass('smpldoc_disabled');
		link.parent('li').addClass('smpldoc_active');

		setupFieldsFromType(type);

		$('#smpldoc_overlay').fadeOut(300);
	});

	/** File popup **/
	var file_frame;

	$('.cd_button_upload').on('click',function(event){
		var file_id = $('#smpldoc_item_file'),
			file_name = $('#smpldoc_filename');

		event.preventDefault();

	    if ( file_frame ) {
	      file_frame.open();
	      return;
	    }

	    file_frame = wp.media.frames.file_frame = wp.media({
	      title: $( this ).data( 'uploader_title' ),
	      button: {
	        text: $( this ).data( 'uploader_button_text' ),
	      },
	      multiple: false
	    });

	    file_frame.on( 'select', function() {

	      var attachment = file_frame.state().get('selection').first().toJSON();
		  file_id.attr('value', attachment.id);
		  file_name.html(attachment.filename);

	    });

	    file_frame.open();

		return false;
	});

	/** Display error alert specifying mising fields **/
	function errorMessage(fields){

		var message = simple_documentation_vars.fields_missing+'\n';
		for(var i=0;i<fields.length;i++){
			if(i>1) message += ', ';
			message += fields[i];
		}
		alert(message);

	}

	function fill_form(data){

		if(current === 'list'){

			//fill information
			setupFieldsFromType(data.type, data);

			list_sw.fadeOut(function(){
				add_sw.fadeIn();
				current = 'add';
				swtch_btn.html( simple_documentation_vars.view_list );
			});

			$('#smpldoc_overlay').fadeOut(300);
		}
	}

	/** Handle ajax response **/
	function settings_response(response){

		//console.log(response);
		var res = $.parseJSON(response);
		//console.log(res);

		if( res.status == 'user-error' ){

			// Display error messages
			if( res.type == 'empty_fields' ) errorMessage( res.data );

		}else if( res.status == 'ok' ){

			// OK
			if( res.type == 'delete' ){
				$('#simpledoc_'+res.id).fadeOut(500);
			}else if(res.type == 'get-data'){

				fill_form(res.data);

			}else if(res.type == 'edit'){

				var item = $('#simpledoc_' + res.data.id ), content;
				item.find('.el_title').html( res.data.title );

				if(res.data.type == 'link') content = '<a href="'+res.data.content+'">'+res.data.content+'</a>';
				else if(res.data.type == 'file') content = '<a href="'+res.data.attachment_url+'">'+res.data.attachment_url+'</a>';
				else content = res.data.content;

				//console.log(res.data);

				item.find('.el_expand').html( content );
				item.find('.smpldoc_usersallowed').attr('title', res.data.users.join(', ') );
				viewList();

			}else if(res.type == 'add'){
				var content;
				var bf = $('<span />').attr('class', 'el_front_bf').html('<a href="#" class="smpldoc_sort"><i class="fa fa-bars"></i></a> <i class="fa fa-'+i(res.data.type)+'"></i>');
				var af = $('<span />').attr('class', 'el_front_af').html('<i class="fa fa-user"></i> <a href="#edit" class="smpldoc_edit_item"><i class="fa fa-pencil"></i></a> <a href="#delete" class="smpldoc_delete_item"><i class="fa fa-times"></i></a></span>');
				var title = $('<span />').attr('class', 'el_title').html( $.stripslashes(res.data.title) );

				if(res.data.type == 'file') content = '<a href="'+res.data.attachment_url+'">'+res.data.attachment_url+'</a>';
				else if(res.data.type == 'link') content = '<a href="'+res.data.content+'">'+res.data.content+'</a>';
				else content = res.data.content;

				var expand = $('<div />').attr('class', 'el_expand').html( $.stripslashes(content) );
				var front = $('<div />').attr('class', 'el_front').attr( 'data-id', res.data.id ).append(bf).append(title).append(af);
				var el = $('<li />').attr( 'id', 'simpledoc_'+res.data.id ).append(front).append(expand);

				$('#simpledoc_list').append(el);

				viewList();
			}else if(res.type == 'reorder'){
				var message = $('<div />').attr('class', 'updated smpldoc_notif').html('<p>' + simple_documentation_vars.order_saved + ' !</p>').delay('1500').fadeOut(700,function(){ $('.smpldoc_notif').remove(); });
				$('.wrap').prepend( message );
			}

		}

	}

	/** Submit form -- AJAX **/
	$('#smpldoc_additem').on('click', function(e){
		e.preventDefault();

		var user_restriction = [], emptyfields = [], actionType = 'add', getcontent = '';

		$('.smpldoc_item_users').each(function(){
			if($(this).is(':checked')) user_restriction.push($(this).val());
		});

		var editor = tinyMCE.get( 'smpldoc_item_content' );

		if (editor) {
			getcontent = editor.getContent();
		} else {
			getcontent = $('#smpldoc_item_content').val();
		}

		var item = {
			title: $('#smpldoc_item_title').val(),
			type: $('#item_type').val(),
			input: $('#smpldoc_item_link').val(),
			file: $('#smpldoc_item_file').val(),
			editor: getcontent,
			user_roles: user_restriction
		};

		if( item.type == 'nope' ) emptyfields.push('type');

		if( item.title.length < 1 ) emptyfields.push('title');

		if( ( item.type == 'note' || item.type == 'video' ) && item.editor ) emptyfields.push('content');
		if( item.type == 'link' && item.input.length < 1 ) emptyfields.push('link');
		if( item.type == 'file' && item.file == 'nope' ) emptyfields.push('file');

		if( emptyfields.length > 1 ){
			errorMessage(emptyfields);
			return false;
		}

		if( $(this).attr('data-action') == 'edit' ){
			actionType = 'edit';
			item.id = $('#item_id').val();
		}

		var data = {
			action: 'simpleDocumentation_ajax',
			a: actionType,
			item: item
		};

		jQuery.post( simple_documentation_vars.ajax_url , data , function(response){ settings_response(response); });

	});

	/** Delete button callback - List view **/
	$('#simpledoc_list').on('click', '.smpldoc_delete_item', function(e){
		e.preventDefault();

		var id = $(this).parent().parent().attr('data-id');

		var data = {
			action: 'simpleDocumentation_ajax',
			a: 'delete',
			id: id
		};

		jQuery.post( simple_documentation_vars.ajax_url , data , function(response){ settings_response(response); });

	});


	/** Drag & Drop - UX + Ajax **/
	$('#simpledoc_list').sortable({
		containment: "parent",
		axis: "y",
		handle: ".smpldoc_sort",
		opacity: 0.6,
		update: function(){
			var ordering = [];
			$('#simpledoc_list').find('li').each(function(){
				ordering.push($(this).find('.el_front').attr('data-id'));
			});
			var data = {
				action: 'simpleDocumentation_ajax',
				a: 'reorder',
				data: ordering
			};
			jQuery.post( simple_documentation_vars.ajax_url , data , function(response){ settings_response(response); });
		}
	});


	$('#simpledoc_list').on('click', '.smpldoc_edit_item', function(e){
		e.preventDefault();

		var id = $(this).parent().parent().attr('data-id');
		var data = {
			action: 'simpleDocumentation_ajax',
			a: 'get-data',
			id: id
		};

		jQuery.post( simple_documentation_vars.ajax_url , data , function(response){ settings_response(response); });

	});

	export_button.on('click', function(e){
		e.preventDefault();

		export_text.val( simple_documentation_vars.loading + '...' );
		var data = {
			action: 'simpleDocumentation_ajax',
			a: 'export',
			options: (export_options.attr('checked'))? 'include': 'exclude'
		};

		jQuery.post( simple_documentation_vars.ajax_url , data , function(response){
			export_text.val( response ).removeAttr('disabled').removeClass('disabled');
		});
	});

	import_button.on('click', function(e){
		e.preventDefault();

		var data = {
			action: 'simpleDocumentation_ajax',
			a: 'import',
			data: $.parseJSON( import_text.val() )
		};

		import_text.val( simple_documentation_vars.processing + '...');

		jQuery.post( simple_documentation_vars.ajax_url , data , function(response){
			var res = $.parseJSON(response);
			if(res.status == 'ok') import_text.val( simple_documentation_vars.label_done );
			else import_text.val( simple_documentation_vars.error );
		});
	});

});
