<?php 

	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//data validation
			if(empty($_POST['portfolio']))
			{
				$errors['portfolio'] = "a portfolio is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['portfolio'])){
				$errors['portfolio'] = "a portfolio can only have letters & spaces";
			}
 
			if(empty($errors))
			{

				$values = [];
				$values['portfolio'] = trim($_POST['portfolio']);
				$values['disabled'] 	= trim($_POST['disabled']);

				$query = "insert into portfolios (portfolio,disabled) values (:portfolio,:disabled)";
				db_query($query,$values);

				message("portfolio created successfully");
				redirect('admin/portfolios');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from portfolios where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			//name validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])){
				$errors['name'] = "a name can only have letters with no spaces";
			}
 
			//qty validation
			if(empty($_POST['qty']))
			{
			    $errors['qty'] = "Quantity is required";
			} else if(!ctype_digit($_POST['qty'])) {
			    $errors['qty'] = "Quantity must be an integer";
			} else if($_POST['qty'] <= 0) {
			    $errors['qty'] = "Quantity must be greater than zero";
			}
		
			//Unit cost validation
			if(empty($_POST['u_cost']))
			{
			    $errors['u_cost'] = "Unit cost is required";
			} else if(!is_numeric($_POST['u_cost'])) {
			    $errors['u_cost'] = "Unit cost must be a float";
			} else if($_POST['u_cost'] <= 0) {
			    $errors['u_cost'] = "Unit cost must be greater than zero";
			}
		

			if(empty($errors))
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['date'] = $_POST['date'];
				$values['qty'] = trim($_POST['qty']);
				$values['u_cost'] = trim($_POST['u_cost']);
				$values['active'] 	= $_POST['active'];
				$values['id'] 		= $id;

				$query = "update portfolios set name = :name, date = :date, qty = :qty, u_cost = :u_cost, active = :active where id = :id limit 1";
				db_query($query,$values);

				message("portfolio edited successfully");
				redirect('admin/portfolios');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from portfolios where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];
 
			if(empty($errors))
			{

				$values = [];
				$values['id'] 		= $id;

				$query = "delete from portfolios where id = :id limit 1";
				db_query($query,$values);

				message("portfolio deleted successfully");
				redirect('admin/portfolios');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>
<!-- #start from here -->
	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Add New portfolio</h3>

	  				<input class="form-control my-1" value="<?=set_value('portfolio')?>" type="text" name="portfolio" placeholder="portfolio name">
	  				<?php if(!empty($errors['portfolio'])):?>
	  					<small class="error"><?=$errors['portfolio']?></small>
	  				<?php endif;?>
 
	  				<select name="disabled" class="form-control my-1">
	  					<option value="">--Select Disabled--</option>
	  					<option <?=set_select('disabled','1')?> value="1">Yes</option>
	  					<option <?=set_select('disabled','0')?> value="0">No</option>
	  				</select>
	  				<?php if(!empty($errors['disabled'])):?>
	  					<small class="error"><?=$errors['disabled']?></small>
	  				<?php endif;?>
 
	  				<button class="btn bg-orange">Save</button>
	  				<a href="<?=ROOT?>/admin/portfolios">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Edit portfolio</h3>

	  				<?php if(!empty($row)):?>

	  				<!-- Name column -->
	  				<input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="name">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

					<!-- Date column -->
					<input class="form-control my-1" value="<?=set_value('date', date('Y-m-d', strtotime($row['date'])))?>" type="date" name="date" placeholder="date">
					<?php if(!empty($errors['date'])):?>
					    <small class="error"><?=$errors['date']?></small>
					<?php endif;?>
					<?php 
					    $today = new DateTime();
					    $selected_date = new DateTime();
					    if (!empty($_POST['date'])) {
					        $selected_date = DateTime::createFromFormat('Y-m-d', $_POST['date']);
					    } elseif (!empty($row['date'])) {
					        $selected_date = DateTime::createFromFormat('Y-m-d', $row['date']);
					    }
					    $selected_date->setTime(0, 0, 0); // set time to 00:00:00 to avoid timezone errors
					    if($selected_date > $today):?>
					        <small class="error">Date cannot be greater than today</small>
					<?php endif;?>


	  				<!-- Qty column -->
	  				<input class="form-control my-1" value="<?=set_value('qty',$row['qty'])?>" type="text" name="qty" placeholder="qty">
	  				<?php if(!empty($errors['qty'])):?>
	  					<small class="error"><?=$errors['qty']?></small>
	  				<?php endif;?>	  	

	  				<!-- Unit cost column -->
	  				<input class="form-control my-1" value="<?=set_value('u_cost',$row['u_cost'])?>" type="text" name="u_cost" placeholder="unit cost">
	  				<?php if(!empty($errors['u_cost'])):?>
	  					<small class="error"><?=$errors['u_cost']?></small>
	  				<?php endif;?>	  							

	  				<select name="active" class="form-control my-1">
	  					<option value="">--Select Active --</option>
	  					<option <?=set_select('active','1',$row['active'])?> value="1">Yes</option>
	  					<option <?=set_select('active','0',$row['active'])?> value="0">No</option>
	  				</select>

	  				<button class="btn bg-orange">Save</button>
	  				<a href="<?=ROOT?>/admin/portfolios">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">That record was not found</div>
	  					<a href="<?=ROOT?>/admin/portfolios">
		  					<button type="button" class="float-end btn">Back</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Delete portfolio</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('portfolio',$row['portfolio'])?></div>
	  				<?php if(!empty($errors['portfolio'])):?>
	  					<small class="error"><?=$errors['portfolio']?></small>
	  				<?php endif;?>

	  				<button class="btn bg-red">Delete</button>
	  				<a href="<?=ROOT?>/admin/portfolios">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">That record was not found</div>
	  					<a href="<?=ROOT?>/admin/portfolios">
		  					<button type="button" class="float-end btn">Back</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 

  				$query = "select * from portfolios order by name asc limit 20";
  				$rows = db_query($query);

  			?>
  			<h3>Portfolios 
  				<a href="<?=ROOT?>/admin/portfolios/add">
  					<button class="float-end btn bg-purple">Add New</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Name</th>
  					<th>Date</th>
  					<th>Qty</th>
  					<th>U_Cost</th>
  					<th>Cost Amt</th>
  					<th>Active</th>
  					<th>Period</th>
  					<th>Grade</th>
  					<th>Dividend</th>
  					<th>Action</th>
   				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['name']?></td>
		  					<td><?=$row['date']?></td>

							<?php $formatted_qty = number_format($row['qty'], 0, '.', ','); ?>
							<td><?= $formatted_qty ?></td>

		  					<td><?=$row['u_cost']?></td>
							<?php $cost = $row['qty'] * $row['u_cost']; ?>
							<?php $formatted_cost = number_format($cost, 2, '.', ','); ?>
							<td><?= $formatted_cost ?></td>
		  					<td><?=$row['active'] ? 'Yes':'No'?></td>
		  					<td><?=$row['period']?></td>
		  					<td><?=$row['grade']?></td>
		  					<td><?=$row['dividend']?></td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/portfolios/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/portfolios/delete/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
		  						</a>
		  					</td>
		  				</tr>
	  				<?php endforeach;?>
  				<?php endif;?>

  			</table>
  		<?php endif;?>

	</section>

<?php require page('includes/admin-footer')?>