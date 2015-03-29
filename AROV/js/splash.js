// JavaScript Document
$(document).ready(function() 
	{
		$('.image').hover(
			function()
			{
				$('.image').removeClass('fadein');
				$('.image').not(this).addClass('fade');
			}, function() 
			{
				$('.image').removeClass('fade');
				$('.image').addClass('fadein');
			}
		);
	});

