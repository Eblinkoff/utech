<span class="delete" onclick="deleteCartUniversal(this)">X</span>
<button class="edit-icon-wrapper" onclick="showEditfieldForm({{ $field->id }})">Редактировать поле</button>
<button class="trash-icon-wrapper" onclick="deletefield({{ $field->id }})">Удалить поле</button>
<form class="new-field-form">
	<div class="alert alert-danger" role="alert" style="display:none;"></div>
	<table class="table my-show-table">
	  <tbody>
		<tr>
		  <th scope="row">Дата</th>
		  <td>{{ $field->date }}</td>
		  </td>
		</tr>
		<tr>
		  <th>Значение</th>
		  <td>{{ $field->value }}</td>
		  </td>
		</tr>
	  </tbody>
	</table>
</form>

