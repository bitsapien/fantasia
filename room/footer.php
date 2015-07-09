    <div class="container">

        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Fantasia 2014 - Template by <a href="http://maxoffsky.com/">Maks</a>
                    </p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/validator.js"></script>
    <script src="js/countdown.js"></script>

<!-- Chat Script -->
<script language="javascript" src="js/jquery.timers-1.0.0.js"></script>
<script type="text/javascript">

$(document).ready(function(){

	$(document).ready(function()
	{	
	
		$('.panel-body').ready(function(){setTimeout(function(){var n = $(".chat").height();
					$(".panel-body").animate({scrollTop: n}, 50);},1100);});

		$(".refresh").everyTime(1000,function(i){
			$.ajax({
			  url: "chat/refresh.php",
			  cache: false,
			  success: function(html){
				$(".refresh").html(html);
			  }
			})
		})
		
	});

	$(document).ready(function() {
			$('#btn-chat').click(function() {
				var text = $('#btn-input').val();
				$('#btn-input').val('');
				$.ajax({
					type: "POST",
					cache: false,
					url: "chat/save.php",
					data: "text="+text,
					success: function(data) {}
				});
					setTimeout(function(){var n = $(".chat").height();
					$(".panel-body").animate({scrollTop: n}, 50);},500);
					

			});
			$("input").keypress(function(event) {
				if (event.which == 13) {
					event.preventDefault();
					var text = $('#btn-input').val();
					$('#btn-input').val('');
					$.ajax({
						type: "POST",
						cache: false,
						url: "chat/save.php",
						data: "text="+text,
						success: function(data) {}
					});
					setTimeout(function(){var n = $(".chat").height();
					$(".panel-body").animate({scrollTop: n}, 50);},500);
					

				}
			});
		});

	$(document).ready(function() {
			$('#submitPass').click(function() {
				$.ajax({
					type: "POST",
					cache: false,
					url: "set_pass.php",
					data: $("#pass_form").serialize(),
					success: function(data) {alert(data);
						if(data == "1"){

							$('#passModal').modal('hide');
							$('#successModal').modal('show');}
						else{
							
							$('#failModal').modal('show');}

					}
				});
					

			});

		});


});

$(function () {
    $('.poll').on('submit', function (e) {
        $.ajax({
            type: 'post',
	    cache: false,
            url: 'add_predict.php',
            data: $(this).serialize(),
            success: function (data) {
		if(data == "1"){;
		location.reload();
		}
		else
		$('#failModal').modal('show');
            }
        });
        e.preventDefault();
    });
});
$('[data-countdown]').each(function() {
   var $this = $(this), finalDate = $(this).data('countdown');
   $this.countdown(finalDate, function(event) {
     $this.html(event.strftime('%H hrs %M mins and %S secs'));
   });
 });
</script>

</body>

</html>
