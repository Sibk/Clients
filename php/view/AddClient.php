<?php include ROOT . '/view/Header.php'; ?>
    <h1>Add CLIENT</h1>
    <div style="width: 200px; padding: 10px;">
	    <form method="post">
	      <div class="form-group">
	        <p><?php if ($name_error) echo $name_error ?></p>
	        <label for="formGroupExampleInput">Имя</label>
	        <input type="text" class="form-control" name="first_name" placeholder="Имя">
	      </div>
	      <div class="form-group">
	        <label for="formGroupExampleInput2">Отчество</label>
	        <input type="text" class="form-control" name="otchestvo" placeholder="Отчество">
	      </div>
	      <div class="form-group">
	        <label for="formGroupExampleInput2">Фамилия</label>
	        <input type="text" class="form-control" name="last_name" placeholder="Фамилия">
	      </div>
	      <div class="form-group">
	        <label for="formGroupExampleInput2">Дата рождения</label>
	        <input type="date" class="form-control" name="birthday" placeholder="Дата рождения">
	      </div>
	      <div>
		      <label for="formGroupExampleInput2">Пол</label>
		      	<select class="custom-select my-1 mr-sm-2" name="sex" style="width: 80px;">
				    <option value="1">Муж</option>
				    <option value="false">Жен</option>
		  		</select>
	      </div>
	      <div class="form-group ph_group">
	        <label for="formGroupExampleInput2">Номер телефона</label>
	        <input type="text" class="form-control ph" name="phones[]" placeholder="Номер телефона">
	      </div>
	      <button type="submit" class="btn btn-dark my-1">Добавить</button>
    </form>
    	<button class="btn btn-dark my-1 addphone" onclick="addphone()">Добавить номер</button>
    </div>
<?php include ROOT . '/view/Footer.php'; ?>

