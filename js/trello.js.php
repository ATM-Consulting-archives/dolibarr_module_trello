<?php 

	require '../config.php';
	
	if(!empty($conf->global->TRELLO_API_KEY)) {
		
		?>
		document.write('<scr'+'ipt src="https://api.trello.com/1/client.js?key=<?php echo $conf->global->TRELLO_API_KEY ?>"></scr'+'ipt>');

		var creationSuccess = function(data) {
		  console.log('Card created successfully. Data returned:' + JSON.stringify(data));
		};

		
		$(document).ready(function() {
		
		var newCard={};
		
		<?php 
		
		dol_include_once('/trello/class/trello.class.php');
		if(!empty($_SESSION['TRELLO'])) {
		
			foreach($_SESSION['TRELLO']as &$data) {
				
				$object = &$data['object'];
				$action = &$data['action'];
				
				$trelloid = TTrello::getObjectId($object['table_element'], $object['id']);
				
				if($action === 'put-board') {
					
					if(empty($trelloid)) {
						
						?>
						newCard = {
						  name: '<?php echo addslashes($object['title']); ?>', 
						  desc: '<?php echo addslashes($object['desc']); ?>',
						  id: '<?php echo addslashes($object['ref']); ?>',
						  closed : false,
						  token:localStorage.getItem('trello_token'),
						};
						Trello.get('/boards/<?php echo addslashes($object['ref']); ?>', { token:localStorage.getItem('trello_token') } , function(data) {
							/*
							success read TODO update task
							*/
							console.log('board exist');
							
						}, function(data) {
							console.log('board dont exist');
							Trello.post('/boards/', newCard, function(data) {
							
								console.log('post',data);
							
							});
							
						});
						<?php 
						
					}
					
				}
				else if($action === 'put-list') {
				
					if(empty($trelloid)) {
						
						?>
						newCard = {
						  name: '<?php echo addslashes($object['title']); ?>', 
						  desc: '<?php echo addslashes($object['desc']); ?>',
						  idList: '', /* 555<?php echo addslashes($object['id']); ?>,*/
						  pos: 'top'
						};
						Trello.post('/cards/', newCard, creationSuccess);
						<?php 
						
					}
					
				}
				
			}
			
		}
		
		$_SESSION['TRELLO']=array();
		
		?>
		});
		<?php 
	}
