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
			function createNewProduct()
			/** Создаём новый поле
			*/
			{
				$.ajax({
					url: '/public/products',
					// dataType : "json",
					data: $('.new-product-form').serialize(),
					method : "POST",
					success: function (rez, textStatus) {
						document.getElementById('one_half_product').innerHTML = rez.table;
						deleteAddProduct();
					},
					error: function(rezult)
					{
						$('.new-product-form .alert-danger').html(rezult.responseJSON.message);
						$('.new-product-form .alert-danger').show();
					}
				});
				return false;
			}
			function createNewEditProduct(id)
			/** Создаём новый поле
			* @param int id - id поля в бд
			*/
			{
				$.ajax({
					url: '/public/products/'+id+'/update',
					// dataType : "json",
					data: $('.new-product-form').serialize(),
					method : "POST",
					success: function (rez, textStatus) {
						document.getElementById('one_half_product').innerHTML = rez.table;
						document.querySelector('.add-product-form-cart').innerHTML = '';
						$(document.querySelector('.add-product-form-cart')).hide();
					},
					error: function(rezult)
					{
						$('.new-product-form .alert-danger').html(rezult.responseJSON.message);
						$('.new-product-form .alert-danger').show();
					}
				});
				return false;
			}
			function showEditProductForm(id)
			/** Показываем карточку редактирования поля
			* @param int id - id поля в бд
			*/
			{
				$.ajax({
					url: '/public/products/'+id+'/edit',
					// dataType : "json",
					// data: {
						// id: id,
					// },
					method : "GET",
					success: function (rez, textStatus) {
						var previousWindow = document.querySelector('.add-product-form-cart');
						previousWindow.innerHTML = rez.cart;
						$(previousWindow).show()
					},
					error: function(rezult)
					{
						$('.new-product-form .alert-danger').html(rezult.responseJSON.message);
						$('.new-product-form .alert-danger').show();
					}
				});
				return false;
			}
			function deleteProduct(id)
			/** Удаляем поле
			* @param int id - id поля в бд
			*/
			{
				$.ajax({
					url: '/public/products/'+id+'/delete',
					// dataType : "json",
					// data: {
						// id: id,
					// },
					method : "GET",
					success: function (rez, textStatus) {
						var previousWindow = document.querySelector('.add-product-form-cart');
						previousWindow.innerHTML = '';
						$(previousWindow).hide();
						document.getElementById('one_half_product').innerHTML = rez.table;
					},
					error: function(rezult)
					{
						// var rezult = JSON.parse(rez);
						$('.new-product-form .alert-danger').html(rezult.responseJSON.message);
						$('.new-product-form .alert-danger').show();
					}
				});
				return false;
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
						console.log(json)
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
		</script>
    </body>
</html>
