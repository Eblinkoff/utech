<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .window {
                width: 50%;
            }
			.graph{
				width: 100%;
			}
			.my-table tbody tr {
				cursor: pointer;
			}
			.my-show-table{
				text-align: left;
			}
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
			<div class="list window">
				@include('list')
			</div>
			<div class="modal window">
			</div>
        </div>
		<div class="graph">
			График
		</div>
		<script>
			function addProduct()
			/** Показываем форму создания нового продукта
			*/
			{
				$('.add-product-form').show();
			}
			function deleteAddProduct()
			/** Скрываем форму создания нового продукта
			*/
			{
				$('.add-product-form').hide();
			}
			function deleteattribute(th)
			/** Удаляем формочку создания нового атрибута
			* @param  obj th - this - элемент с крестом
			*/
			{
				$(th.parentElement).remove();
			}
			function addAtributForm(th)
			/** Добавляем форму создания нового атрибута
			*/
			{
				// var form = '<div class="one-atrtr form-group">\
						// <input type="text" placeholder="Ключ" name="attr[key][]">\
						// <input type="text" placeholder="Значение" name="attr[value][]">\
						// <span class="delete-attr" onclick="deleteattribute(this)">X</span>\
					// </div>';
				var root = document.createElement('DIV');
				root.className = 'one-atrtr form-group';
				
				var key = document.createElement('INPUT');
				key.type = 'text';
				key.placeholder = 'Ключ';
				key.name = 'data[key][]';
				root.appendChild(key);
				
				var value = document.createElement('INPUT');
				value.type = 'text';
				value.placeholder = 'Значение';
				value.name = 'data[value][]';
				root.appendChild(value);
				
				var del = document.createElement('SPAN');
				del.className = 'delete-attr';
				del.setAttribute('onclick', 'deleteattribute(this)');
				del.innerHTML = 'X';
				root.appendChild(del);
				th.parentElement.querySelector('.atributes-list').appendChild(root);
			}
			
			
			
			
			
			
			
			
			function showProductCart(id)
			/** Показываем карточку поля
			* @param int id - id поля в бд
			*/
			{
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "/public/fields/"+id);
				xhr.send();
				xhr.onload = function() {
					if (xhr.status != 200)
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
					}
					else
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.modal').innerHTML = json.cart;
					}
				}
				return false;
			}
			function deleteCartUniversal(th)
			/** Удаляем любое "модальное окно"
			* @param  obj th - this - элемент с крестом
			*/
			{
				document.querySelector('.modal').innerHTML = '';
			}
			
			
			function showEditfieldForm(id)
			/** Показываем карточку редактирования поля
			* @param int id - id поля в бд
			*/
			{
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "/public/fields/"+id+"/edit");
				xhr.send();
				xhr.onload = function() {
					if (xhr.status != 200)
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
					}
					else
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.modal').innerHTML = json.cart;
					}
				}
				return false;
			}
			function createNewEditField(id)
			/** Редактируем поле
			* @param int id - id поля в бд
			*/
			{
				var formSerialized = new FormData(document.querySelector('.new-field-form'));
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/public/fields/"+id+"/update");
				// xhr.setRequestHeader('Content-Type', 'application/json');
				xhr.send(formSerialized);
				xhr.onload = function() {
					if (xhr.status != 200)
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
					}
					else
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.list.window').innerHTML = json.table;
						document.querySelector('.modal').innerHTML = '';
					}
				}
				return false;
			}
			function deletefield(id)
			/** Удаляем поле
			* @param int id - id поля в бд
			*/
			{
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "/public/fields/"+id+"/delete");
				xhr.send();
				xhr.onload = function() {
					if (xhr.status != 200)
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
					}
					else
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.modal').innerHTML = '';
						document.querySelector('.list.window').innerHTML = json.table;
					}
				}
				return false;
			}
			
			function showNewFieldForm(id)
			/** Показываем карточку создания нового поля
			* @param int id - id поля в бд
			*/
			{
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "/public/fields/"+id+"/new");
				xhr.send();
				xhr.onload = function() {
					if (xhr.status != 200)
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
					}
					else
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.modal').innerHTML = json.cart;
					}
				}
				return false;
			}
			function createNewField()
			/** Создаём новое поле
			*/
			{
				var formSerialized = new FormData(document.querySelector('.new-field-form'));
				var xhr = new XMLHttpRequest();
				xhr.open("POST", "/public/fields");
				xhr.send(formSerialized);
				xhr.onload = function() {
					if (xhr.status != 200)
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
					}
					else
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.modal').innerHTML = '';
						document.querySelector('.list.window').innerHTML = json.table;
					}
				}
				return false;
			}
		</script>
    </body>
</html>
