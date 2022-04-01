<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>test</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="/public/js/liteChart.min.js"></script>

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
			.chart {
				min-height:400px;
				width:100%;
			}
			.alert-danger{
				color: red;
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
			<div id="my-chart" width="400" height="400"></div>
		</div>
		<script>
			document.addEventListener("DOMContentLoaded", function(){
				// chart
				showChart();
			});
			
			
			function showChart()
			/** Отрисовываем график заново
			* @param int id - id поля в бд
			*/
			{
				document.getElementById('my-chart').innerHTML = '';
				// Готовим данные
				var dates = document.querySelectorAll('.my-table th[scope="row"]');
				var dat = [];
				for(var i = 0; i < dates.length;i++)
				{
					var arr = dates[i].innerHTML.split('-');
					dat[i] = arr[2];// только числа
				}

				var values = document.querySelectorAll('.my-table td');
				var val = [];
				for(var i = 0; i < values.length;i++)
				{
					val[i] = values[i].innerHTML;
				}
				// Create liteChart.js Object
				var d = new liteChart("chart", {});
				
				// Set labels
				// d.setLabels(["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]);
				d.setLabels(val);

				// Set legends and values
				d.addLegend({"name": "График изменения значений", "stroke": "#CDDC39", "fill": "#fff", "values": dat});
				// d.addLegend({"name": "Night", "stroke": "#3b95f7", "fill": "#fff", "values": [200, 150, 240, 180, 150, 240, 230, 300, 200, 150, 270, 200]});

				d.inject(document.getElementById("my-chart"));

				// Draw
				d.draw();
			}
			
			
			function showProductCart(id)
			/** Показываем карточку поля
			* @param int id - id поля в бд
			*/
			{
				var xhr = new XMLHttpRequest();
				xhr.open("GET", "/public/fields/"+id);
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
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
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
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
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xhr.send(formSerialized);
				xhr.onload = function() {
					if (xhr.status == 422)
					// ошибка валидации
					{
						json = JSON.parse(xhr.response);
						var error = document.querySelector('.alert.alert-danger');
						if(error)
						{
							error.innerHTML = json.message;
							error.style.display = 'block';
						}
					}
					else if (xhr.status == 200)
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.list.window').innerHTML = json.table;
						document.querySelector('.modal').innerHTML = '';
						showChart();
					}
					else
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
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
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
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
						showChart();
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
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
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
				xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
				xhr.send(formSerialized);
				xhr.onload = function() {
					if (xhr.status == 422)
					// ошибка валидации
					{
						json = JSON.parse(xhr.response);
						var error = document.querySelector('.alert.alert-danger');
						if(error)
						{
							error.innerHTML = json.message;
							error.style.display = 'block';
						}
					}
					else if (xhr.status == 200)
					{
						json = JSON.parse(xhr.response);
						document.querySelector('.modal').innerHTML = '';
						document.querySelector('.list.window').innerHTML = json.table;
						showChart();
					}
					else
					{
						console.log("Ошибка "+xhr.status+": "+xhr.statusText);
					}
				}
				return false;
			}
		</script>
    </body>
</html>
