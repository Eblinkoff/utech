<span class="delete" onclick="deleteCartUniversal(this)">X</span>
<h5>Создание нового поля</h5>
<form class="new-field-form">
	{{ csrf_field() }}
	<div class="alert alert-danger" role="alert" style="display:none;"></div>
	<table class="table my-show-table">
	  <tbody>
		<tr>
		  <th scope="row">Дата</th>
		  <td>
			<div class="form-group">
				<input required class="form-control" id="date" name="date" aria-describedby="dateHelp1" placeholder="ГГГГ-ММ-ДД" type="date" value="">
				<small id="valueHelp1" class="form-text text-muted">* Обязательное поле</small>
			</div>
		  </td>
		  </td>
		</tr>
		<tr>
		  <th>Значение</th>
		  <td>
			<div class="form-group">
				<input required class="form-control" name="value" id="value" aria-describedby="valueHelp1" placeholder="Значение" type="text" value="">
				<small id="valueHelp1" class="form-text text-muted">* Обязательное поле</small>
			</div>
		  </td>
		  </td>
		</tr>
	  </tbody>
	</table>
	<button class="btn btn-info add-my-button" type="button" onclick="return createNewField({{ $field->id }})">Создать запись</button>
</form>

