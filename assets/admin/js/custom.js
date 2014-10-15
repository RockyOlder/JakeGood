$(function() {
	
	$("a[target=_ajax]").fancybox({type: 'ajax'});

	$("a[target=_iframe]").fancybox({
					'width'				: '75%',
					'height'			: '75%',
					'autoScale'			: true,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe'
				});

	$("a[target=_script]").fancybox({
					type: 'ajax',
					'opacity'	:true,
					'overlayShow':false,
					'showCloseButton':false,
					'transitionIn':'none',				
					'afterLoad':function(){$.fancybox.close()},					

				});

	//toggle action
	ToggleSetting();
});

var ToggleSetting = function () {

	$('.toggle').each(function (){
		$(this).attr('rel', $(this).attr('href'));
		$(this).attr('href', 'javascript:;');
	});
}
var currentToggle = function(obj){
		
		$.fancybox({
			href: obj.attr('rel'),
			type: 'ajax',
			afterLoad:function(current) {
			
				toggle_on  = "/assets/admin/images/icons/color/tick.png";
				toggle_off = "/assets/admin/images/icons/color/cross.png";
				cur_img = obj.find('img').attr('src');
				
				if(cur_img == toggle_on) {
					obj.find('img').attr('src',toggle_off)
				}
				else if(cur_img == toggle_off) {
					obj.find('img').attr('src',toggle_on)
				}
			}
		});
	}

function AfterLoadGridView()
{
	ToggleSetting();
	jQuery(document).ready(function() {       
         // initiate layout and plugins
         App.init();
         FormComponents.init();
      });
}