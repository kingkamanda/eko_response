<?php
session_start();
require_once("classes/State.php");
$state1 = new State;
$fetch=$state1 -> get_state();
// echo "<pre>";
// var_dump($fetch);
// echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Eko Response - Login and Registration Form</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css'>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="assets/static/fontawesome/css/all.min.css">
<link rel="stylesheet" href="login_signup.css">
</head> 

<body >
<!-- partial:index.partial.php -->



    

<nav class="main-nav d-flex justify-content-center">
	<ul>
		<li><a class="signin" href="#0">Sign in</a></li>
		<li><a class="signup" href="#0">Sign up</a></li>
	</ul>
</nav>

<div class="mt-5 d-flex justify-content-center" style="">
  <a href="index.php" class="btn btn-large btn-dark position-absolute">Back to Home Page</a>
</div>




<div class="user-modal">
		<div class="user-modal-container">
			<ul class="switcher">
				<li><a href="#0">Sign in</a></li>
				<li><a href="#0">New account</a></li>
			</ul>

      <div id="login">
        <form class="form" action="process/process_login.php" method="post">
          <p class="fieldset">
            <label class="image-replace email" for="signin-email">E-mail</label>
					  <input class="full-width has-padding has-border" id="signin-email" name="email" type="email" placeholder="E-mail">
						<span class="error-message">An account with this email address does not exist!</span>
          </p>

          <p class="fieldset">
            <label class="image-replace password" for="signin-password">Password</label>
						<input class="full-width has-padding has-border" id="signin-password" name="pwd" type="password"  placeholder="Password">
						<a href="#0" class="hide-password">Show</a>
						<span class="error-message">Wrong password! Try again.</span>
          </p>
          <p class="fieldset">
						<input type="checkbox" id="remember-me" checked>
						<label for="remember-me">Remember me</label>
					</p>
          <input class="full-width btn btn-dark" type="submit" name="btnlogin" value="Login">
        </form>
        <p class="form-bottom-message"><a href="#0">Forgot your password?</a></p>
				<a href="#0" class="close-form">Close</a>
      </div>
			

			<div id="signup">
				<form class="form" action="process/process_signup.php" method="post">
					<p class="fieldset">
						<label class="image-replace username" for="signup-username">Fullname</label>
						<input class="full-width has-padding has-border" id="signup-username" name="fullname" type="text" placeholder="fullname">
						<span class="error-message">Your username can only contain numeric and alphabetic symbols!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace email" for="signup-email">E-mail</label>
						<input class="full-width has-padding has-border" id="signup-email" name="email" type="email" placeholder="E-mail">
						<span class="error-message">Enter a valid email address!</span>
					</p>

					<p class="fieldset">
						<label class="image-replace password" for="signup-password">Password</label>
						<input class="full-width has-padding has-border" id="signup-password" name="pwd"  type="password"  placeholder="Password">
						<a href="#0" class="hide-password">Show</a>
						<span class="error-message">Your password has to be at least 6 characters long!</span>
					</p>

          <p class="fieldset">
						<label class="image-replace state" for="state">State</label>
            <select name="state" id="state" class="form-select" aria-label="Default select example">
            <option value="select">Select State</option>
            <?php
            // loop through the state list
            foreach ($fetch as $state) {
             #extract state IDnand name from array
             $stateid = $state['state_id'];
             $statename = $state['state_name'];
             
             ?>
             <option value="<?php echo $stateid;?>"> <?php echo $statename?></option>
             <?php
            }
             ?>
            
            </select>
            <select name="lga" id="lga" class="form-select my-5" style="display: none;">
            
            </select>
						</p>

					<p class="fieldset">
						<input type="checkbox" id="accept-terms">
						<label for="accept-terms">I agree to the <a class="accept-terms" href="#0">Terms</a></label>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding btn btn-dark" type="submit" name="btnsignup" value="Create Account" onclick="alert('Please Update your profile here')">
					</p>
				</form>

				<!-- <a href="#0" class="cd-close-form">Close</a> -->
			</div>

			<div id="reset-password">
				<p class="form-message">Lost your password? Please enter your email address.</br> You will receive a link to create a new password.</p>

				<form class="form">
					<p class="fieldset">
						<label class="image-replace email" for="reset-email">E-mail</label>
						<input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
						<span class="error-message">An account with this email does not exist!</span>
					</p>

					<p class="fieldset">
						<input class="full-width has-padding" type="submit" value="Reset password">
					</p>
				</form>

				<p class="form-bottom-message"><a href="#0">Back to log-in</a></p>
			</div>
			<a href="#0" class="close-form">Close</a>
		</div>
	</div>


<!-- partial -->







  <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script>
    $(function(){
      $("#state").change(function(){
      var value = $(this).val();
      $.ajax({
        url:"server.php",
        method:"post",
        data:value,
        dataType:"json",
        success:function(res){
          $("#lga").empty()
          $("#lga").show()
          res.forEach(value => {
            $("#lga").append(`<option value="${value['lga_id']}">${value['lga_name']}</option>`)
          });
        }
      })
      })
    })
  </script>
  <script>
  jQuery(document).ready(function($){
  var $form_modal = $('.user-modal'),
    $form_login = $form_modal.find('#login'),
    $form_signup = $form_modal.find('#signup'),
    $form_forgot_password = $form_modal.find('#reset-password'),
    $form_modal_tab = $('.switcher'),
    $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
    $tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
    $forgot_password_link = $form_login.find('.form-bottom-message a'),
    $back_to_login_link = $form_forgot_password.find('.form-bottom-message a'),
    $main_nav = $('.main-nav');

  //open modal
  $main_nav.on('click', function(event){

    if( $(event.target).is($main_nav) ) {
      // on mobile open the submenu
      $(this).children('ul').toggleClass('is-visible');
    } else {
      // on mobile close submenu
      $main_nav.children('ul').removeClass('is-visible');
      //show modal layer
      $form_modal.addClass('is-visible'); 
      //show the selected form
      ( $(event.target).is('.signup') ) ? signup_selected() : login_selected();
    }

  });

  //close modal
  $('.user-modal').on('click', function(event){
    if( $(event.target).is($form_modal) || $(event.target).is('.close-form') ) {
      $form_modal.removeClass('is-visible');
    } 
  });
  //close modal when clicking the esc keyboard button
  $(document).keyup(function(event){
      if(event.which=='27'){
        $form_modal.removeClass('is-visible');
      }
    });

  //switch from a tab to another
  $form_modal_tab.on('click', function(event) {
    event.preventDefault();
    ($(event.target).is( $tab_login)) ? login_selected() : signup_selected();
  });

  //hide or show password
  $('.hide-password').on('click', function(){
    var $this= $(this),
      $password_field = $this.prev('input');
    
    ( 'password' == $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
    ( 'Show' == $this.text() ) ? $this.text('Hide') : $this.text('Show');
    //focus and move cursor to the end of input field
    $password_field.putCursorAtEnd();
  });

  //show forgot-password form 
  $forgot_password_link.on('click', function(event){
    event.preventDefault();
    forgot_password_selected();
  });

  //back to login from the forgot-password form
  $back_to_login_link.on('click', function(event){
    event.preventDefault();
    login_selected();
  });

  function login_selected(){
    $form_login.addClass('is-selected');
    $form_signup.removeClass('is-selected');
    $form_forgot_password.removeClass('is-selected');
    $tab_login.addClass('selected');
    $tab_signup.removeClass('selected');
  }

  function signup_selected(){
    $form_login.removeClass('is-selected');
    $form_signup.addClass('is-selected');
    $form_forgot_password.removeClass('is-selected');
    $tab_login.removeClass('selected');
    $tab_signup.addClass('selected');
  }

  function forgot_password_selected(){
    $form_login.removeClass('is-selected');
    $form_signup.removeClass('is-selected');
    $form_forgot_password.addClass('is-selected');
  }

  //REMOVE THIS - it's just to show error messages 
  // $form_login.find('input[type="submit"]').on('click', function(event){
  //   event.preventDefault();
    // $form_login.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
  // });
  // $form_signup.find('input[type="submit"]').on('click', function(event){
  //   event.preventDefault();
  //   $form_signup.find('input[type="email"]').toggleClass('has-error').next('span').toggleClass('is-visible');
  // });


  //IE9 placeholder fallback
  //credits http://www.hagenburger.net/BLOG/HTML5-Input-Placeholder-Fix-With-jQuery.html
  if(!Modernizr.input.placeholder){
    $('[placeholder]').focus(function() {
      var input = $(this);
      if (input.val() == input.attr('placeholder')) {
        input.val('');
        }
    }).blur(function() {
      var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
        input.val(input.attr('placeholder'));
        }
    }).blur();
    $('[placeholder]').parents('form').submit(function() {
        $(this).find('[placeholder]').each(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
          input.val('');
        }
        })
    });
  }

});
jQuery.fn.putCursorAtEnd = function() {
  return this.each(function() {
      // If this function exists...
      if (this.setSelectionRange) {
          // ... then use it (Doesn't work in IE)
          // Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
          var len = $(this).val().length * 2;
          this.setSelectionRange(len, len);
      } else {
        // ... otherwise replace the contents with itself
        // (Doesn't work in Google Chrome)
          $(this).val($(this).val());
      }
  });
};
  </script>

</body>
</html>
