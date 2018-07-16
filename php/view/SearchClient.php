<?php include ROOT . '/view/Header.php'; ?>
   <h1>Поиск</h1>
   <div>
       <div class="form-group" style="width: 300px; padding: 10px;">
          <form method="post">
             <div class="row" >
                 <div class="col">
                     <label for="formGroupExampleInput2">Поиск клиента</label>
                     <input type="text" class="form-control" name="search" placeholder="Фамилия или телефон">
                 </div>
             </div>
            <button type="submit" class="btn btn-dark my-1">Найти</button>
          </form>
       </div>
       <table class="table">
           <thread>
               <tr>
                   <th scope="col">Имя</th>
                   <th scope="col">Отчество</th>
                   <th scope="col">Фамилия</th>
                   <th scope="col">Дата рождения</th>
                   <th scope="col">Пол</th>
                   <th scope="col">Дата создания записи</th>
                   <th scope="col">Дата обновления записи</th>
                   <th scope="col">Телефоны клиента</th>
               </tr>
           </thread>
           <tbody>
               <?php if ($res == true): ?>
               <?php $i = 0; foreach($res as $r):?>
                   <tr>
                       <th scope="row"><a href= <?php echo "/client/card?id={$r['id']}" ?>><?php echo $r["first_name"] ?></a></th>
                       <th scope="row"><?php echo $r["otchestvo"] ?></th>
                       <th scope="row"><?php echo $r["last_name"] ?></th>
                       <th scope="row"><?php echo $r["birthday"] ?></th>
                       <th scope="row"><?php if ($r["sex"] == 't') echo "Муж"; else echo "Жен" ?></th>
                       <th scope="row"><?php echo $r["creation_date"] ?></th>
                       <th scope="row"><?php echo $r["update_date"] ?></th>
                       <th scope="row">
                           <?php if ($r["phone"]): ?>
                               <?php foreach ($r["phone"] as $phone) echo "<pre>".$phone["phone"]."</pre>" ?>
                           <?php endif; ?>  
                       </th>
                   
                   </tr>
               <?php endforeach;?>
               <?php endif ?>
           </tbody>
       </table>
   </div>
<?php include ROOT . '/view/Footer.php'; ?>