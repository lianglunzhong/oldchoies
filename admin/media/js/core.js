jQuery.fn.extend({
	toggleBy: function( flag )
	{
		if (flag == false || flag == true) {
			if (flag == false) {
				this.show();
			} else {
				this.hide();
			}
		} else {
			this.toggle();
		}

		return true;
	},

	moveOptions: function(to, params)
	{
		var params = params || {};
		$('option' + (params.move_all ? '' : ':selected:not(.cm-required)'), this).appendTo(to);

		if (params.check_required) {
			var f = [];
			$('option.cm-required:selected', this).each(function() {
				f.push($(this).text());
			});

			if (f.length) {
				alert(params.message + "\n" + f.join(', '));
			}
		}

		return true;
	},

	swapOptions: function(direction)
	{
		$('option:selected', this).each(function() {
			if (direction == 'up') {
				$(this).prev().insertAfter(this);
			} else {
				$(this).next().insertBefore(this);
			}
		});

		return true;
	},

	selectOptions: function(flag)
	{
		$('option', this).attr('selected', (flag == true) ? 'selected' : '');

		return true;
	},

	alignElement: function()
	{
		var w = jQuery.get_window_sizes();
		var self = $(this);

		self.css({
			display: 'block',
			top: w.offset_y + (w.view_height - self.height()) / 2,
			left: w.offset_x + (w.view_width - self.width()) / 2
		});
	},

	highlightFields: function()
	{
		$(this).each( function() {
			var self = $(this);
			if (self.hasClass('cm-form-highlight') == false) {
				return true;
			}

			var text_elms = $(':password, :text, textarea', self);

			text_elms.each(function() {
				var elm = $(this);
				elm.focus(function () {
					$(this).addClass('input-text-selected');
				});
				elm.blur(function () {
					$(this).removeClass('input-text-selected');
				});
			});
		});
	},

	showRanges: function(selector)
	{
		var self = $(this);
		var offset = self.offset();
		var ranges = $(selector);

		ranges.css({left: offset.left, top: offset.top});
		ranges.toggle();
	},

	// Disables/enables all children inside selected element according to visibility
	toggleElements: function()
	{
		var self = $(this);
		$(':input', this).attr('disabled', (self.css('display') == 'none') ? true : false);
	},

	// Override default jQuery click method with more smart and working :)
	click: function(fn)
	{
		if (fn)	{
			return this.bind('click', fn);
		}

		$(this).each(function() {
			if (jQuery.browser.msie) {
				this.click();
			} else {
				var evt_obj = document.createEvent('MouseEvents');
				evt_obj.initEvent('click', true, true);
				this.dispatchEvent(evt_obj);
			}
		});
	},

	switchAvailability: function(flag)
	{
		if (flag == false || flag == true) {
			if (flag == false) {
				$(':input:not(.cm-skip-avail-switch)', this).attr('disabled', '');
				this.show();
			} else {
				$(':input', this).attr('disabled', 'disabled');
				this.hide();
			}
		} else {
			$(':input', this).each(function(){
				var self = $(this);
				self.attr('disabled', !self.attr('disabled'));
			});
			this.toggle();
		}
		if (typeof(control_buttons_container) != 'undefined' && control_buttons_container.length) {
			jQuery.buttonsPlaceholderToggle();
		}
	}
});