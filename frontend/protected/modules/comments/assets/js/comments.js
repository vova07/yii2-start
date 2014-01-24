jQuery.noConflict();
jQuery(document).ready(function($) {
	// Копия формы
	var form;

	// Все переменные для работы скрипта
	var config = {
		// ID блока комментариев
		commentsId : '#comments',

		// Определяем ИД формы комментариев
		formId : '#commentForm',

		// ID который добавляется форме комментария созданой в JS
		jsFormIdVal : 'jsCommentForm',

		// ID который добавляется форме комментария созданой в JS и используется в работе скрипта
		jsFormId : '#jsCommentForm',

		// Класс полей которые должны быть удалены при редактировании комментария
		removeClass : '.jshidden',

		// Класс блока ошибок
		formError : '.help-block',

		// Класс контейнера полей и лэйблов
		formGroupClass : '.form-group',

		// Определяем ИД поля который содержит ифнормацию о родителе комментария
		parentId : '#comment-parent_id',

		// Класс контейнера в котором находится непосредственно сам комментарий
		commentContentClass : '.content',

		// Уникальный ID комментария
		commentId : '#c',

		// Основной класс комментария по которому его можно найти
		commentClass : '.item',

		// Класс блока с временем обновления комментария
		updateTimeClass : 'updateTime',

		// Класс блока с ссылками администрирования комментария
		manageClass : '.manage',

		// Класс удаленного комментария
		deletedClass : 'deleted',

		// Класс забаненого комментария
		bannedClass : 'banned',

		// Урл для отправки AJAX запроса
		url : undefined,

		// Тип получаемой информации после запроса
		dataType : 'json',

		// Тип запроса
		type : undefined,

		// Конфигурация AJAX запроса
		sendData : undefined,

		// Дополнительные параметры AJAX запроса
		extSendData : undefined,

		// Функция которая срабатывает до отправки запроса
		beforeSend : function (xhr, settings) {
			$(form).find('.btn').button('loading');
		},

		// Функция которая срабатывает после отправки запроса
		complete : function (xhr, textStatus) {
			$(form).find('.btn').button('reset');
		},

		// Функция которая срабатывает при успешной отправки запроса
		success : undefined,

		// Функция которая срабатывает при неудачной отправки запроса
		error : undefined
	};

	// Добавление нового комментария
	$(document).on('click', config.commentsId + ' .create', function() {
		// Создаем форму
		cloneForm();
		// Выводим форму
		$(this).after(form);

		// Определяем нужные параметры для AJAX запроса
		config['url'] = '/comments/';
		config['type'] = 'POST';
		config['error'] = function (xhr, textStatus, errorThrown) {
			var data = $.parseJSON(xhr.responseText);
			if (data.content) {
				$(form).find(config.formGroupClass).addClass('has-error').find(config.formError).text(data.content[0]);
			}
		};
		config['success'] = function (data, textStatus, xhr) {
			$(config.commentsId).append(data);
			// Удаляем форму
			removeForm();
		};
		// Отменяем дефолтное действие
		return false;
	});

	// Добавление ответа на комментарий
	$(document).on('click', config.commentsId + ' .reply', function() {
		// Создаем форму
		cloneForm();

		// Определяем ID родителя комментария
		var commentParentId = $(this).data('id');
		// Создаем экземпляр блока с комментарием для которого добавляется ответ
		var commentItem = $(this).parents(config.commentClass);

		// Задаем правильное значение родителя, для нового комментария
		form.find(config.parentId).val(commentParentId);
		// Выводим форму
		commentItem.append(form);

		// Определяем уровень вложености комментария
		var commentLvl = $(this).data('lvl');
		if (!commentLvl)
			commentLvl = 0;
		commentLvl++;

		// Определяем нужные параметры для AJAX запроса
		config['url'] = '/comments/';
		config['type'] = 'POST';
		config['extSendData'] = '&level=' + commentLvl;
		config['error'] = function (xhr, textStatus, errorThrown) {
			var data = $.parseJSON(xhr.responseText);
			if (data.content)
				$(form).find(config.formGroupClass).addClass('has-error').find(config.formError).text(data.content[0]);
		};
		config['success'] = function (data, textStatus, xhr) {
			var lastComment = $(config.commentClass + '[data-parent-id="' + commentParentId + '"]:last');

			if (lastComment.length)
				lastComment.after(data);
			else
				commentItem.after(data);
			// Удаляем форму
			removeForm();
		};
		// Отменяем дефолтное действие
		return false;
	});

	// Редактирование комментария
	$(document).on('click', config.commentsId + ' .update', function() {
		// Создаем форму
		cloneForm(true);

		// Создаем экземпляр блока с комментарием для которого добавляется ответ
		var commentItem = $(this).parents('.item');
		// Задаем нужное значение для textarea
		form.find('textarea').html(commentItem.find(config.commentContentClass).html());
		// Выводим форму
		commentItem.append(form);

		// Определяем нужные параметры для AJAX запроса
		config['url'] = '/comments/' + $(this).data('id') + '/';
		config['type'] = 'PUT';
		config['error'] = function (xhr, textStatus, errorThrown) {
			var data = $.parseJSON(xhr.responseText);
			if (data.content)
				$(form).find(config.formGroupClass).addClass('has-error').find(config.formError).text(data.content[0]);
		};
		config['success'] = function (data, textStatus, xhr) {
			if (data.content)
				commentItem.find(config.commentContentClass).html(data.content);
			if (data.update_time)
				commentItem.find(config.updateTimeClass).text(data.update_time);
			// Удаляем форму
			removeForm();
		};
		// Отменяем дефолтное действие
		return false;
	});

	// Удаление комментария
	$(document).on('click', config.commentsId + ' .delete', function() {
		// Выводим подтверждение
		if (confirm(config.deleteConfirmation)) {
			// Создаем экземпляр блока с комментарием для которого добавляется ответ
			var commentItem = $(this).parents('.item');

			// Определяем нужные параметры для AJAX запроса
			config['url'] = '/comments/' + $(this).data('id') + '/';
			config['type'] = 'DELETE';
			config['sendData'] = {};
			config.sendData[jsy.params.csrf.name] = jsy.params.csrf.token;
			config['success'] = function (data, textStatus, xhr) {
				if (data.banned === true)
					var commentClass = config.bannedClass;
				else
					var commentClass = config.deletedClass;

				commentItem.addClass(commentClass).find(config.manageClass).remove();

				if (data.content)
					commentItem.find(config.commentContentClass).html(data.content);
				if (data.update_time)
					commentItem.find(config.updateTimeClass).text(data.update_time);
			}
			config['error'] = function (xhr, textStatus, errorThrown) {
				alert(errorThrown);
			};
			// Отправляем форму
			sendForm();
		}
		// Отменяем дефолтное действие
		return false;
	});

	// Вызов отправки формы при нажатии на кнопку отправки
	$(document).on('click', config.jsFormId + ' .btn2', function() {
		if (form)
			config['sendData'] = form.serialize();
		else
			config['sendData'] = '';

		if (config.extSendData)
			config['sendData'] = config['sendData'] + config.extSendData;
		// Отправляем форму
		sendForm();
		// Отменяем дефолтное действие
		return false;
	});

	// Отмена комментария
	$(document).on('click', config.jsFormId + ' .cancel', function() {
		// Удаляем форму
		removeForm();
		// Отменяем дефолтное действие
		return false;
	});

	// Создаем клон формы комментариев
	function cloneForm(onlyContent) {
		// Проверяем если форма уже создана, и удаляем её
		if (form)
			removeForm();
		// Создаём новую форму
		form = $(config.formId).clone();

		$(config.formId).prop('id', 'cloneCommentForm');

		// Удаляем ненужные классы формы, и задаём правильный ID для работы в JS
		// form.removeClass('hidden').prop('id', config.jsFormIdVal);
		form.removeClass('hidden');
		
		// По необходимости, удаляем ненужные поля в форме
		if (onlyContent === true)
			form.find(config.removeClass).remove();
	}

	// Удаляем фору комментариев
	function removeForm() {
		// Удаляем форму
		form.remove();
		// Сбрасываем настройки
		form = config.sendData = config.extSendData = config.url = config.type = config.success = undefined;
	}

	// Отправка данных
	function sendForm() {
		console.log(config.sendData);
		// Задаем основные параметры AJAX запроса
		var ajaxConfig = {
			url : config.url,
			dataType : config.dataType,
			type : config.type
		};

		if (config.sendData)
			ajaxConfig['data'] = config.sendData;

		if (config.beforeSend) {
			ajaxConfig['beforeSend'] = function (xhr, settings) {
				config.beforeSend(xhr, settings);
			};
		}

		if (config.error) {
			ajaxConfig['error'] = function (xhr, textStatus, errorThrown) {
				config.error(xhr, textStatus, errorThrown);
			};
		}

		if (config.success) {
			ajaxConfig['success'] = function (data, textStatus, xhr) {
				config.success(data, textStatus, xhr);
			};
		}

		if (config.complete) {
			ajaxConfig['complete'] = function (xhr, textStatus) {
            	config.complete(xhr, textStatus);
            };
		}

		// Отправляем AJAX запрос
		$.ajax(ajaxConfig);
	}
});