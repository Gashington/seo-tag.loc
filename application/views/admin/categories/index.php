<div class="admin categories index">
    <div class="top">
        <div class="cats">      			
			<table class="table table-bordered table-hover table-striped table-striped">
				<thead>
	                <tr>
					    <th>ID</th>
	                    <th>Название</th>
						<th title="Редактировать"><i class="icon-edit icon-white"></i></th>
                    	<th title="Удалить"><i class="icon-remove icon-white"></i></th>
					</tr> 
				</thead>
				<tbody>
            		<?= $cats ?>
				</tbody>
			</table>
            <div class="add">
                <a href="/admin/<?= $controller ?>/add/" class="btn ">Добавить категорию</a>
            </div>
        </div>
    </div>  
</div>