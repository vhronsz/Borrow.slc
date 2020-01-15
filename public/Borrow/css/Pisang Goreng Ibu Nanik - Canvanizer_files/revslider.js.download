var RSlider = {};

RSlider.me = undefined;
RSlider.started = false;
RSlider.settings = {};
RSlider.versionchange = false;
RSlider.slider_handler = null;
// play show canvas slide by slide
RSlider.play = function() {

		if (!$('.btn-play').hasClass('pause'))
			return;
	
		var sliderdata = RSlider.getdata();
	
		if (sliderdata.value < sliderdata.max) {
	
				RSlider.me.slider("value", sliderdata.value + 1);
		
				RSlider.slider_handler = window.setTimeout(function() {
					RSlider.play();
				}, 1600);
	
		} else {
	
				window.clearTimeout(RSlider.slider_handler);
				$('.btn-play').removeClass('pause');
		}
};

RSlider.pause = function() {
	
		if ( RSlider.slider_handler ) {
			
				window.clearTimeout(RSlider.slider_handler);
				
				$('.btn-play').removeClass('pause')
							  .find('i').removeClass('icon-pause');
		}	
};

// ajax call
RSlider.ajax = function(res) {

		// if slide change then call ajax to view change
		$('#status_message').html('Loading...').show();
	
		$.ajax({
				url : RSlider.settings.url + RSlider.me.slider("value"),
				dataType : 'json',
				success : function(res) {
		
					$('#status_message').html('done.').hide();
					RSlider.callback(res);
		
				}
		});

};

// ajax callback
RSlider.callback = function(res) {

		html = res.html;
	
		$('#revslider-time').html(res.time_stamp);
	
		var canvashtml = $('<div>' + html + '</div>').find('.canvas-container')
				.html();
	
		var que_html = [];
	
		$(canvashtml).find('.drop_container').each(function() {
			que_html.push($(this).html());
		});
	
		$('.canvas-container .drop_container').each(function(i, elem) {
	
			$(this).empty();
			$(this).append(que_html[i]);
	
		});

};

RSlider.setmax = function(value) {
	
		RSlider.settings.max_revision = value;
		RSlider.me.slider("option", "max", value);
};

RSlider.getdata = function() {

		var slider_max = RSlider.me.slider("option", "max");
		slider_val = RSlider.me.slider("value");
	
		return {
			value : slider_val,
			max : slider_max
		};

};

// update buttons
RSlider.updateButtons = function() {

		var sliderdata = RSlider.getdata();
	
		if (sliderdata.max != sliderdata.value) {
	
				// change color of reload
				$('.btn-repeat').removeClass('btn-danger');
				$('.btn-repeat i').removeClass('icon-white');
		
				// make editable
				$('.btn-stop').addClass('btn-danger');
				$('.btn-stop i').addClass('icon-white');
	
		} else {
	
				// change color of reload
				$('.btn-repeat').addClass('btn-danger');
				$('.btn-repeat i').addClass('icon-white');
		
				// change play button icon to play
				$('.btn-play').removeClass('pause');
				$('.btn-play').addClass('btn-primary')
				              .find('i').addClass('icon-white');
				
				$('.btn-play').find('i').removeClass('icon-pause');
		
				// make editable to editable
				$('.btn-stop').removeClass('btn-danger');
				$('.btn-stop i').removeClass('icon-white');
		}

};

// slide handling
RSlider.slide = function(action) {

		RSlider.started = true;
	
		var sliderdata = RSlider.getdata();
	
		// stop calling ajax synch during play
		if (sliderdata.max != sliderdata.value) {
				cansynch.pause(true);
		} else {
				cansynch.pause(false);
		}
	
		RSlider.updateButtons();
	
		$("#cur_revision").html(sliderdata.value);
	
		if (action != 'change') {
				return;
		}
	
		if (RSlider.versionchange) {
	
				RSlider.versionchange = false;
				return;
		}
	
		// if slide change then call ajax to view change
		RSlider.ajax();

};

RSlider.init = function(options) {

		RSlider.settings = $.extend(RSlider.settings, options);
	
		RSlider.me = $("#revslider").slider({
				min : 1,
				value : RSlider.settings.max_revision,
				max : RSlider.settings.max_revision,
				slide : function(event, ui) {
		
					RSlider.slide();
		
				},
				change : function(event, ui) {
		
					RSlider.slide('change');
		
				}
		});
	
		// toggle play button
		$('.btn-play').click(function() {
	
				var sliderdata = RSlider.getdata();
		
				// latest revision then reload to first
				if (sliderdata.max == sliderdata.value) {
		
						RSlider.me.slider("value", 1);
			
						// change play button icon to play
						$('.btn-play').removeClass('pause');
						$('.btn-play').find('i').removeClass('icon-pause');
			
						window.setTimeout(function() {
							$('.btn-play').trigger('click');
						}, 1600);
			
						return false;
				}
		
				if ($(this).hasClass('pause')) {
					
						$(this).removeClass('pause');
						$(this).find('i').removeClass('icon-pause');
						
				} else {
					
						$(this).addClass('pause');
						$(this).find('i').addClass('icon-pause');
				}
		
				RSlider.play();
		
				return false;
		});
	
		$('.btn-backward').click(function() {
										  
				RSlider.pause();
				var val = RSlider.me.slider("value");
				RSlider.me.slider("value", val - 1);
		
				return false;
		});
	
		$('.btn-forward').click(function() {
										 
				RSlider.pause();	
				var val = RSlider.me.slider("value");
				RSlider.me.slider("value", val + 1);
		
				return false;
		});
	
		$('.btn-stop').click(function() {
	
				var val = RSlider.me.slider("option", "max");
				RSlider.me.slider("value", val + 1);
		
				return false;
		});
		
		$('.toggle-slider').click(function() {
										   
				if($(this).hasClass('hidding')) {
						
						$(this).removeClass('hidding')
							   .addClass('showing')
							   .text('Hide History');
							   
						$('.revslider-box').show();

				} else {
						$(this).removeClass('showing')
						       .addClass('hidding')
							   .text('Canvas History');	
							   
						$('.revslider-box').hide();
						
						// revert into latest version
						$('.btn-stop').trigger('click');
						
				}
		});
		
		$('.show_canvas_history').click(function() {
			$('.revslider-box').show();  
			
			$('.toggle-slider').removeClass('hidding')
			   .addClass('showing')
			   .text('Hide History');
		});
				
		RSlider.showSlider();
	
		// making lock on canvas
		$('.canvas-container-overlay').click(function() {
				alert('History can be reviewed only.');
		});

};

// if version less than 2 , then there no history
RSlider.showSlider = function() {

		var maxval = RSlider.me.slider("option", "max");
	
		if (maxval < 1) {
				$('.revslider-box').addClass('diplay-none');
		} else {
				$('.revslider-box').removeClass('diplay-none');
		}
	
		return (maxval < 1);
};

window.setInterval(function() {

		if ( RSlider.me == undefined )
			return;
	
		var sliderdata = RSlider.getdata();
	
		RSlider.setmax( cansynch.version );
	
		$("#max_revision").html( cansynch.version );
	
		// check version less than 2
		if ( RSlider.showSlider() ) {
				return;
		}
		
		if (sliderdata.max == sliderdata.value) {
		
				RSlider.versionchange = true;
		
				RSlider.me.slider("value", RSlider.me.slider("option", "max"));
		
				$('.canvas-container-overlay').hide();
		
				return;
		}
	
		if ( ( sliderdata.max != sliderdata.value) && 
			 ( sliderdata.max  > sliderdata.value) ) {
	
			$('.canvas-container-overlay')
					.height($('.canvas-container').height())
					.width($('.canvas-container').width())
					.fadeTo( 0 , 0.3).show();
		}

}, 800);