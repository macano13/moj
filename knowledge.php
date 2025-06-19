<?php
require_once('config.php');
require_once(ABSPATH . '/code/post/upload-file-post.php');
include_once("code/template/header.php");

if ($user->expire_date == null) {
	echo "<script>window.location.href ='/payment.php';</script>";
} else {
	$extendExpiredDate = date("Y-m-d", strtotime($user->expire_date . " +10 days"));
	$todayDate = Date('Y-m-d');
	if ($todayDate > $extendExpiredDate) {
		echo "<script>window.location.href ='/payment.php';</script>";
	}
}

if ($user->is_active == 2 || $user->is_active == 0) {
	echo "<script>window.location.href ='/payment.php';</script>";
}
?>
<html lang="en">
<style>
.h3, h3 {
    font-size: 24px!important;
    text-shadow: 5px 4px 8px grey;
}

.dugme {
	height: 50%;
}

.crta {
   
    width: 100%;
    
    color: lawngreen;
    background: transparent;
    animation: crtica 3s linear;
    animation-direction:alternate;
  

}

@keyframes crtica {
    0% {

        width: 20%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 2px;
    }
    25% {
        width: 50%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 2px;
    }
    50% {
        width: 70%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 2px;
    }
    75% {
        width: 85%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 2px;
    }
    100% {
        width: 100%;
        color: rgb(18, 236, 127);
        background: rgb(18, 236, 127);
        height: 2px;
    }
}
</style>
<!-- Main content -->
<section class="content">
	<!-- general form elements -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Knowledge base</h3>
		</div>

<div class="cards">
  <div class="card">How to start using VIP area
  <hr/ class="crta">
  <button class="button dugme">Watch Now</button>
  
  </div>
  <div class="card">How to translate subtitle
  <hr/ class="crta">
  <button class="button-0 dugme">Watch Now</button>
  </div>
  <div class="card">Save translated subtitle as a draft
  <hr/ class="crta">
  <button class="button-1 dugme">Watch Now</button>
  </div>
  <div class="card">Save translated subtitle as a New
  <hr/ class="crta">
  <button class="button-2 dugme">Watch Now</button>
  </div>
  <div class="card">How to convert subtitles
  <hr/ class="crta">
  <button class="button-3 dugme">Watch Now</button>
  </div>
  <div class="card">How to change subtitle name  
  <hr/ class="crta">
  <button class="button-4 dugme">Watch Now</button>
  </div>
  <div class="card">How to list subtitles in the table
  <hr/ class="crta">
  <button class="button-5 dugme">Watch Now</button>
  </div>
  <div class="card">How to share subtitles
  <hr/ class="crta">
  <button class="button-6 dugme">Watch Now</button>
  </div>
  <div class="card">How to search movie subtitles
  <hr/ class="crta">
  <button class="button-7 dugme">Watch Now</button>
  </div>
  <div class="card">How to search series subtitle
  <hr/ class="crta">
  <button class="button-8 dugme">Watch Now</button>
  </div>
  <div class="card">How to make the payment
  <hr/ class="crta">
  <button class="button-9 dugme">Watch Now</button>
  </div>
  <div class="card">How to change the password
  <hr/ class="crta">
  <button class="button-10 dugme">Watch Now</button>
  </div>
  
    <div class="card">Delete all subtitle files at once
  <hr/ class="crta">
  <button class="button-12 dugme">Watch Now</button>
  </div>
  <div class="card">Upload 20 subtitle files at once
  <hr/ class="crta">
  <button class="button-13 dugme">Watch Now</button>
  </div>
  <div class="card">Multi subtitle translator usage
  <hr/ class="crta">
  <button class="button-14 dugme">Watch Now</button>
  </div>
</div>




	</div>
	<!-- /.box -->
</section>
<script>

$('.button').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=mAkvnMuGlGk'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-1').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=RdQiNjsYGDw'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-2').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=J8p_w-wSW7I'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-3').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=tFLPzW1Qs9E'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-4').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=W_kUMc5mdDk'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-5').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=nmrE_4GJETQ'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-6').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=XV5qOKUOyzE'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-7').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=MU9RZ-TgmiE'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-8').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=I0u2g61MUgY'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-9').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=SUKluDSfi8A'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-10').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=pgh2hz0s7lc'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-11').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=TrLhod67i1k'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-12').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=34HKzOa_b9I'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-13').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=mq3AYHUFpS4'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-14').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=ajRENGZT5yI'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});

$('.button-0').magnificPopup({
  items: {
	     src: 'https://www.youtube.com/watch?v=rrYFBw7ak9w'
     },
  type: 'iframe',
  iframe: {
	    	markup: '<div class="mfp-iframe-scaler">'+
            		'<div class="mfp-close"></div>'+
            		'<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            		'</div>', 
        patterns: {
            youtube: {
	              index: 'youtube.com/', 
	              id: 'v=', 
	              src: '//www.youtube.com/embed/%id%?autoplay=1' 
		        }
		     },
		     srcAction: 'iframe_src', 
     }
});
</script>
</html>
<!-- /.content -->
<?php
include_once("code/template/footer.php");
?>