@if($fields != null)
<h2>Click me</h2>
<table class="table my-table">
  <thead>
	<tr>
	  <th>Дата</th>
	  <th>Значение</th>
	</tr>
  </thead>
  <tbody>
	@foreach($fields as $field)
	<tr style="background-color: #fff;" onclick="showProductCart({{ $field->id }})">
	  <th scope="row">{{ $field->date }}</th>
	  <td>{{ $field->value }}</td>
	</tr>
	@endforeach
  </tbody>
</table>
<button type="button" onclick="showNewFieldForm({{ $field->id }})">Создать новое поле</button>
@else
	Ни одного поля нет
@endif
