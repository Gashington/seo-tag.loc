<div id="contacts">
	<h2>Контакты</h2>
    <div class="row">
		<div class="span6">
	        <div class="form-block">
				<p class="text-warning"><span class="label label-warning">Внимание!</span> Поля с * обязательны для заполнения.</p>
	            <form action="<?= url::base() ?>contact" method="post">  
	            	<? if (!empty($mess)): ?>
						<p class="text-success"><?= $mess ?></p>
	        		<? endif; ?>        
	                <div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
	                    <input type="text" required value="<?=$post['name'] ?>" name="name" placeholder="* Имя"/>
	                </div>  
	                <!--<div>
	                    <input type="text" required placeholder="* Телефон"  pattern=".*\d.*" value="<? // $post['tel'] ?>" name="tel"/>
	                </div>-->
	                <div class="input-prepend">
	                    <span class="add-on">@</span>
						<input type="email"  value="<?=$post['email'] ?>" name="email" placeholder="E-mail"/>
	                </div> 	
	                <div class="input-prepend">
						<span class="add-on"><i class="icon-pencil"></i></span>
	                    <textarea name="more" required placeholder="* Сообщение"><?=$post['more'] ?></textarea>
	                </div>	
	                <div  class="input-prepend">
					    <span class="add-on"><i class="icon-picture"></i></span>
	                    <input name="captcha" class="input-small" required class="captcha" placeholder="* Капча" type="text" />
						<?=$captcha ?>
	                </div>
	                <div>
                        </br>
	                    <input type="submit" name="submit" value="Отправить" class="button btn btn-primary"/>
	                </div>
	            </form>
	        </div>
		</div>
		<div class="span6">
			<div class="page-static"><?=$page['content']; ?></div>
		</div>
        <!--<div class="yandexmapping"><? //$map['content'] ?></div> -->
    </div>   
    
</div>