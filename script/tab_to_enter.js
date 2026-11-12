$(document).ready(function(){
					$("input").not( $(":submit") ).keypress(function (evt) {
					if (evt.keyCode == 13) {
						iname = $(this).val();
						if (iname !== 'Submit'){
							var fields = $(this).parents('form:eq(0),body').find('input, textarea, select, radio, checkbox');
							var index = fields.index( this );
							if ( index > -1 && ( index + 1 ) < fields.length ) {
								fields.eq( index + 1 ).focus();
							}
							return false;
						}
					}
					});
					
					$("textarea").not( $(":submit") ).keypress(function (evt) {
					if (evt.keyCode == 13) {
						iname = $(this).val();
						if (iname !== 'Submit'){
							var fields = $(this).parents('form:eq(0),body').find('input, textarea, select, radio, checkbox');
							var index = fields.index( this );
							if ( index > -1 && ( index + 1 ) < fields.length ) {
								fields.eq( index + 1 ).focus();
							}
							return false;
						}
					}
					});
					
					$("select").not( $(":submit") ).keypress(function (evt) {
					if (evt.keyCode == 13) {
						iname = $(this).val();
						if (iname !== 'Submit'){
							var fields = $(this).parents('form:eq(0),body').find('input, textarea, select, radio, checkbox');
							var index = fields.index( this );
							if ( index > -1 && ( index + 1 ) < fields.length ) {
								fields.eq( index + 1 ).focus();
							}
							return false;
						}
					}
					});
					
					$("radio").not( $(":submit") ).keypress(function (evt) {
					if (evt.keyCode == 13) {
						iname = $(this).val();
						if (iname !== 'Submit'){
							var fields = $(this).parents('form:eq(0),body').find('input, textarea, select, radio, checkbox');
							var index = fields.index( this );
							if ( index > -1 && ( index + 1 ) < fields.length ) {
								fields.eq( index + 1 ).focus();
							}
							return false;
						}
					}
					});
					
					$("checkbox").not( $(":submit") ).keypress(function (evt) {
					if (evt.keyCode == 13) {
						iname = $(this).val();
						if (iname !== 'Submit'){
							var fields = $(this).parents('form:eq(0),body').find('input, textarea, select, radio, checkbox');
							var index = fields.index( this );
							if ( index > -1 && ( index + 1 ) < fields.length ) {
								fields.eq( index + 1 ).focus();
							}
							return false;
						}
					}
					});
					});