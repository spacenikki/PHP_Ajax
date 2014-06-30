<html>
<head>
	<title>Ajax Exercise</title>
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script type="text/javascript">

		$(document).ready(function()
		{
			// alert('note');
			// alert('Hello!');
			// when FORM id='#note' got submitted, then activate below codes
			$('#note').submit(function()
			{
				// alert('again!');
				// alert ($(this).attr('action'));
				$.post(
					// alert('inside the post')
					// alert($(this).attr('action')); -> to test what is wrong
				// data from which form? -> the form which
				 // is going to action='/Posts/ajax'
					$(this).attr('action'),
					// what data to grab? -> return in a list
					$(this).serialize(),
			// whatever got passed to json_encode() -> will be named as data -> means it's $note
				// what u want to do with this data called 'data'?
				// data = $note from controller's function ajax! 
					function(data)
					{
						// console.log(data); 
			// add new notes in front of existing all_notes -> with same class of existing notes on wall
						// $('#existing_notes').prepend("<div class='newnote'>"+data+"</div>");   -> data is the newly added note 
						$('#existing_notes').prepend("<div class='newnote'><h2>"+data+"</h2><br><form class='new_note' action='/Posts/update/$post_id' method='post'><textarea class='awesome' name='message'></textarea><input type='submit' class='update' id='$post_id' value='Edit'><a class='delete' href='/Posts/delete_by_id/$post_id'>X</a></form></div>");		
					},
					// data type
					"json");
				// prevent page from refreshing , without this, console.log will not show grabbed data
				return false;
			});
			
			$(document).on('click','.delete', function() 
			{
				// since already name 'Class delete' above line
				// anything u mention here as $(this) -> auto refer to .delete
				
				// set $(this) to variable note -> COMMON way to do in javascript
				// w/out this -> sometimes pc will get confused and DELETE EVERYTHING!
				// but this case, if just $(this) will be okay
				var note = $(this); 
				// alert ("user wants to delete sth!");
				$.post(
					$(note).attr('href'),
					// $(this).serialize(), --> no need for this, as don't have to grab the data, data already sent!
					function()
					{
						// console.log(delete_data);
						// can add the actual one u need 
						// remove data from screen data.remove();
						$(note).parent().parent().remove();
					})
				return false;
			});
// does not work.... 
// when description area got clicked (inside for loop)-> .replacewith "<h3>+new_note+</h3>"
			$(document).on('submit','.new_note', function() 
			{   
// need to define what target u need to change content ... -> cannot call $post['description'] -> it's PHP!! 
// -> need to access value in HTML way.
// give line 121 -> $post['description'] -> h2 tag -> so u can target the things u need to change content
				var description = $(this).siblings('h2');
				console.log(description);
				// alert('user wants to edit sth');
				$.post(
					// alert('hello');
					$(this).attr('action'),
					$(this).serialize(),
					// data here is the user's input which got submitted from the form "new_note"
					function(new_note){
						// console.log(new_note);
						//  change description's text to new_note user update
						$(description).text(new_note);
						// alert('successfully updated a note');
					},
					"json");
				return false;
			});
// jquery can also apply to textarea -> does not have to be a form! -> 
// but when this textarea is focusout -> form "new_note" got submitted -> I NEED TO WRITE JQUERY ON WHEN THAT FORM 
//  GOT SUBMITTED -> WHEN I WANT THE PC TO DO!

// class awesome -> got focus out -> will trigger submission of textarea's parent 
// -> which is <form class='new_note'>
// this is just a normal jquery
			// $('.awesome').focusout(function() 
			// {
			// 	// alert('update?');
			// 	$(this).parent().submit();
			// // will trigger the parent of .awesome -> form '.new_note' -> to be submitted
			// });

// to make all but not ONLY the new ones updated. use dynamic
			$(document).on('focusout', '.awesome', function(){
				$(this).parent().submit();
				// make the input box input disappear after hitting eidt or focus out
				$(this).val('');
			})
	// need to work without the index button
		});
</script>
</head>

<body>
	<h2>This is your post-it ! Feel free to add a note! </h3>

	<div id= 'add_note'>
		<h3>Add a note:</h3>

		<form id='note' action='/Posts/ajax' method='post'>
			<textarea name='note'></textarea>
			<input type='submit' id='post_it' name='post_it' value='Post It!'>
			<!-- when post_it is submit, activate ajx code -->
		</form>
	</div>

	<div id='existing_notes'> <!-- print out all existing notes out along with edit button and delete button for action. going to add newly added note before ALL existing note 
		without having to refresh the page -> magic of Ajax!-->
		<?php  
			foreach ($posts as $post) 
			{
				// echo $post_id;
				$post_id = $post['id'];
				// since everytime post is generated -> new id will be assigned 

				// have div='newnote' -> so when its children got clicked -> 
				// i can trigger what to do  with its.parent -> example: delete. edit
				echo "<div class='newnote' id ='{$post_id}'>";
				
				// show each post content from database -> so after updating message
				// will print it from the database to ajax view screen
				// constraint: it only loads when document is loaded
				echo "<h2>". $post['description']."</h2><br>";

				// form got submited ONLY if submiit button 'edit' got clicked!
				// $post_id is going to replace $id in controller -> update function
				echo "<form class='new_note' action='/Posts/update/$post_id' method='post'>";
				echo "<textarea class='awesome' name='message'></textarea>";
				
				// $new_note = whatever new notes got added to this area
				echo "<input type='submit' class='update' id='$post_id' value='Edit'>";

				// delete button does not have to be a form, can be just a href!
				// delete button can be a 'X' -> when user click it, info got transfered to 
				// delete_by_id function under controller -> after it got deleted from database 
				// since nothing has to be sent from the controller -> i hv to make deleted item disappear
				// w/out refreshing the page -> tht's when jquery code click in
				echo "<a class='delete' href='/Posts/delete_by_id/$post_id'>X</a>";
				echo "</form>";
				
				echo '</div>';	
			}
		?> 
	</div>

	<a href="/Posts/destroy">Delete all</a>

</body>
</html>