(function ($) {
	
	$.fn.comments = function (method) {
		if (methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' + method + ' does not exist on jQuery.comments');
			return false;
		}
	};

	var methods = {
		init: function () {
			return this.each(function () {
				var $form = $(this);

				if ($form.data('comments')) {
					return;
				}

				var $widget = $('#comments-widget'),
				    settings = {createUrl : $form.prop('action')};

				$form.data('comments', {
					settings: settings,
					widget: $widget
				});

				$widget.on('click.comments', '.create', function() {
					commentCreate($(this), $form);
					return false;
				});
				$widget.on('click.comments', '.reply', function() {
					commentReply($(this), $form);
					return false;
				});
				$widget.on('click.comments', '.update', function() {
					commentUpdate($(this), $form);
					return false;
				});
				$widget.on('click.comments', '.delete', function() {
					commentDelete($(this), $form);
					return false;
				});
				$widget.on('click.comments', '.cancel', function() {
					commentCancel($form);
					return false;
				});
				$widget.on('click.comments', '.parent-link', function() {
					scrollToParent($(this));
					return false;
				});
			});
		},

		destroy: function() {
			return this.each(function () {
				$(window).unbind('.comments');
				$(this).removeData('comments');
			});
		},

		data: function() {
			return this.data('comments');
		}
	};

	// Добавление нового комментария.
	var commentCreate = function ($this, $form) {
		var data = $form.data('comments');

		if (data.created === undefined) {
			var $cloneForm = cloneForm($form);
			data.created = true;
			$this.after($cloneForm);

			$cloneForm.on('submit', function() {
				return submitForm($form, $this, data.settings.createUrl, 'POST', successCreate);
			});
		}
	};

	// Ответ на комментарий.
	var commentReply = function($this, $form) {
		var data = $form.data('comments'),
		    cparent = $this.parents('.comment'),
		    content = cparent.find('.content');

		if (!cparent.find('form[data-class=reply]').length) {
			var $cloneForm = cloneForm($form);
			$cloneForm.attr('data-class', 'reply').find('#comment-parent_id').val($this.data('id'));
			$cloneForm.find('#comment-level').val($this.data('level'));
			content.after($cloneForm);

			$cloneForm.on('submit', function() {
				return submitForm($form, $this, data.settings.createUrl, 'POST', successReply);
			});
		}
	};

	// Обновление комментария.
	var commentUpdate = function($this, $form) {
		var data = $form.data('comments'),
		    cparent = $this.parents('.comment'),
		    content = cparent.find('.content');

		if (!cparent.find('form[data-class=update]').length) {
			var $cloneForm = cloneForm($form);
			$cloneForm.attr('data-class', 'update').find('textarea').text($.trim(content.text()));
			content.after($cloneForm);

			$cloneForm.on('submit', function() {
				return submitForm($form, $this, $this.data('href'), 'POST', successUpdate);
			});
		}
	};

	// Удаление комментария.
	var commentDelete = function($this, $form) {
		var id = $this.data('id'),
		    url = $this.data('href'),
		    msg = $this.data('confirm');

		if (confirm(msg)) {
			$.ajax({
				url: url,
				type: 'DELETE',
				success: function (response) {
					removeForm($form);
					if (response.success) {
						var cParent = $this.parents('.comment');
						cParent.find('.content').text(response.success);
						cParent.find('.manage, .parent-link').remove();
					}
				}
			});
		}
		return false;
	};

	// Обновление комментария.
	var commentCancel = function($form) {
		removeForm($form);
	};

	var scrollToParent = function($this) {
		var el = $this.attr('href');
		$(el).addClass('active');
		scrollTo(el);
	};

	// Отправка формы.
	var submitForm = function($form, $this, url, type, successCallback) {
		var $cloneForm = getForm($form);
		$.ajax({
			url: url,
			type: type,
			data: $cloneForm.serialize(),
			success: function(response, textStatus, jqXHR) {
				if (response.errors) {
					$.each(response.errors, function(key, value) {
						if ($.isArray(value) && value.length) {
							$cloneForm.find('.field-' + key).addClass('has-error').find('.help-block').text(value[0]);
						}
					});
				} else {
					successCallback($form, $this, response);
				}
			}
		});
		return false;
	};

	// Функция вызывается в случае удачного создания нового комментария.
	var successCreate = function($form, $this, response) {
		var data = $form.data('comments'),
		    $widget = data.widget;

		removeForm($form);
		data.created = undefined;

		if (response.success) {
			$widget.find('.comments').append(response.success);
			scrollTo($widget.find('.comment:last'));
		}
		return false;
	};

	// Функция вызывается в случае удачного обновления комментария.
	var successReply = function($form, $this, response) {
		var data = $form.data('comments'),
		    $widget = data.widget,
		    cParent = $this.parents('.comment'),
		    parentId = $this.data('id');
		removeForm($form);
		if (response.success) {
			if ($('.comment[data-parent=' + parentId + ']').length) {
				$('.comment[data-parent=' + parentId + ']:last').after(response.success);
			} else {
				cParent.after(response.success);
			}
			scrollTo($widget.find('.comment[data-parent=' + parentId + ']:last'));
		}
		return false;
	};

	// Функция вызывается в случае удачного обновления комментария.
	var successUpdate = function($form, $this, response) {
		var cParent = $this.parents('.comment');
		removeForm($form);
		if (response.success) {
			cParent.find('.content').text(response.success);
		}
		return false;
	};

	// Клонирование формы комментариев.
	var cloneForm = function($form) {
		removeForm($form);
		var data = $form.data('comments'),
		    $cloneForm = $form.clone().prop('id', 'js-' + $form.prop('id'));
		data.cloneForm = $cloneForm;
		return $cloneForm;
	};

	// Удаление клона формы комментариев.
	var removeForm = function($form) {
		var data = $form.data('comments');
		if (data.cloneForm !== undefined) {
			data.cloneForm.remove();
			data.cloneForm = undefined;
		}
	};

	var getForm = function($form) {
		var data = $form.data('comments');
		return data.cloneForm;
	};

	// Скролинг к указаному комментарию.
	var scrollTo = function(el) {
		var topScroll = $(el).offset().top;
		$('body, html').animate({
			scrollTop: topScroll
		}, 500);
	};
})(window.jQuery);
