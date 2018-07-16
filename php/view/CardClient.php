<?php include ROOT . '/view/Header.php'; ?>
    <h1>CARD CLIENT</h1>
    <div class="row">
	    <?php foreach($res as $client): ?>
	    <div style="width: 200px; padding: 30px; position: absolute;" class="col">
		    <form method="post" id="edit">
		      <div class="form-group">
		        <label for="formGroupExampleInput">Имя</label>
		        <input type="text" class="form-control" name="first_name" placeholder="Имя" value=<?php echo $client["first_name"] ?>>
		      </div>
		      <div class="form-group">
		        <label for="formGroupExampleInput2">Отчество</label>
		        <input type="text" class="form-control" name="otchestvo" placeholder="Отчество" value=<?php echo $client["otchestvo"] ?>>
		      </div>
		      <div class="form-group">
		        <label for="formGroupExampleInput2">Фамилия</label>
		        <input type="text" class="form-control" name="last_name" placeholder="Фамилия" value=<?php echo $client["last_name"] ?>>
		      </div>
		      <div class="form-group">
		        <label for="formGroupExampleInput2">Дата рождения</label>
		        <input type="date" class="form-control" name="birthday" placeholder="Дата рождения" value=<?php echo $client["birthday"] ?>>
		      </div>
	              <div class="form-group" style="display: none;">
	                <input type="text" name="id" value=<?php echo $client["id"] ?>>
	              </div>
		      <div>
			      <label for="formGroupExampleInput2">Пол</label>
			      	<select class="custom-select my-1 mr-sm-2" name="sex" style="width: 80px;">
	                    <?php if ($client["sex"] == t): ?>
					        <option selected value="1">Муж</option>
					        <option value="false">Жен</option>
	                    <?php else: ?>
	                        <option value="1">Муж</option>
	                        <option selected value="false">Жен</option>
	                    <?php endif ?>
			        </select>
		      </div>
		      <input type="text" name="client_id" value= <?php echo $client["id"] ?> style="display: none;" form="del_client">

		      <div class="form-group">
		      <?php if ($phones): ?>
		        <label for="formGroupExampleInput2">Номер телефона</label>
		        <?php $i = 1; foreach ($phones as $phone): ?>
                    <div class = "row">
                        <div>
		                    <input type="text" class="form-control ph" name=<?php echo "phone{$i}/{$phone['id']}" ?> placeholder="Номер телефона" value=<?php echo $phone["phone"] ?>>
		                    <div class="form-check" style="position: absolute; left: 100%; margin-top: -35px">
		                        <input type="checkbox" name="del_phone[]" value=<?php echo "{$phone['id']}" ?> form="del_phone">
		                    </div>
                        </div>
                    </div>
		        <?php $i++; endforeach; ?>
		      <?php endif; ?>
		      </div>
	              <div class="row" style="padding: 5px;">
                          <div>
		                      <button type="submit" class="btn btn-dark my-1" form="edit">Изменить</button>
                          </div>
                          <div style="position: absolute; left: 70%;">
                              <button type="submit" class="btn btn-danger my-1" form="del_client">Удалить клиента</button>
                          </div>
                          <div style="position: relative; left: 180%; margin-top: -46px">
                              <button type="submit" class="btn btn-danger my-1" form="del_phone">Удалить номер</button>
                          </div>
                   </div>
	    </form>
	    </div>
	    <?php endforeach; ?>
	    <div class="col" style="width: 200px; padding: 30px; position: absolute; left: 50%;">
	        <form method="post" action="/phone/add">
		    	<div class="form-group ph_group">
			        <label for="formGroupExampleInput2">Номер телефона</label>
			        <input type="text" class="form-control ph add_ph" name="phones[]" placeholder="Номер телефона">
			        <input type="text" name="client_id" value=<?php echo $res[0]["id"] ?> style="display: none">
			    </div>
			    <button type="submit" class="btn btn-dark my-1">Добавить</button>
			</form>
		    <button class="btn btn-dark my-1 " onclick="addphone()">Добавить номер</button>
	    </div>
           <form method="post" action="/client/remove" id="del_client"></form>
           <form method="post" action="/client/phone/remove" id="del_phone"></form>
    </div>
<?php include ROOT . '/view/Footer.php'; ?>

