var detectIEregexp;
var browserName;

//Check browser is IE
if (navigator.userAgent.indexOf('MSIE') != -1) {

	detectIEregexp = /MSIE (\d+\.\d+);/;
	//test for MSIE x.x

} else {// if no "MSIE" string in userAgent

	detectIEregexp = /Trident.*rv[ :]*(\d+\.\d+)/;
	//test for rv:x.x or rv x.x where Trident string exists

	if (/Edge\/12./i.test(navigator.userAgent)) {

		// this is Microsoft Edge
		browserName = "Microsoft Edge";

	}
}

function showSubCategory(index) {
	if ((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge")) {
		document.getElementById("subCategory" + index).className = "";
		document.getElementById("subCategory" + index).className = "categories-subs";
		document.getElementById("subCategory" + index).style.top = (((39 * (index)) - ((39 * (index)) * 2) ) + 39) + "px";

		document.getElementById("subCategory" + index).querySelector(".whiteBox").style.top = ((39 * index ) - 39) + "px";
	}
}

function hideSubCategory(index) {
	if ((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge")) {
		document.getElementById("subCategory" + index).className = "";
		document.getElementById("subCategory" + index).className = "hide";
	}
}

function slideMobileCategory() {
	if ((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge")) {
		if (window_width < 768) {
			$(".mobile-categories").animate({
				left : '0%'
			}, 500);
		}
	}
}

function closeCategory() {
	if ((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge")) {
		if (window_width < 768) {
			$(".mobile-categories").animate({
				left : '-100%'
			}, 500);
		}
	}
}

function backMainCategory() {
	if ((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge")) {
		if (window_width < 768) {
			$(".mobile-sub-categories").animate({
				left : '-100%'
			}, 500);

			$(".mobile-categories").animate({
				left : '0%'
			}, 600);
		}
	}
}

function closeSubCategory() {
	if ((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge")) {
		if (window_width < 768) {
			$(".mobile-sub-categories").animate({
				left : '-100%'
			}, 500);
		}
	}
}

function slideSubCategory(index) {
	if ((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge")) {
		if (window_width < 768) {
			$(".mobile-categories").animate({
				left : '-100%'
			}, 500);

			$(".mobile-sub-categories").animate({
				left : '0%'
			}, 600);
		}
	}
}


$(document).ready(function() {

	if (window_width > 767) {
		$(".carousel-control").addClass("hide");
	}

	if (!((detectIEregexp.test(navigator.userAgent)) || (browserName == "Microsoft Edge"))) {

		if (window_width < 768) {
			$(this).find(".carousel-control").removeClass("hide");
		}

	}

	$(".categories-subs").css("min-height", (window_height / 2));

	$(".mobile-category-btn").click(function() {
		$(".mobile-categories").animate({
			left : '0%'
		}, 500);
	});

	// current Edge
	$(".categories-list>li").click(function() {
		if (window_width < 768) {
			$(".mobile-categories").animate({
				left : '-100%'
			}, 500);

			$(".mobile-sub-categories").animate({
				left : '0%'
			}, 600);
		}
	});

	$(".close-category").click(function() {
		$(".mobile-categories").animate({
			left : '-100%'
		}, 500);
	});

	$(".close-subcategory").click(function() {

		$(".mobile-sub-categories").animate({
			left : '-100%'
		}, 500);

		$(".mobile-categories").animate({
			left : '0%'
		}, 600);
	});

	$(".close-subcategory1").click(function() {

		$(".mobile-sub-categories").animate({
			left : '-100%'
		}, 500);
	});

	$(".categories-list>li").mouseover(function() {

		var listli = $(this).index();

		if (window_width > 767) {
			$(".categories-list>li").removeClass("category-active");
			$(this).find(".img-li-inactive").addClass("hide");
			$(this).find(".img-li-active").removeClass("hide");
			console.log("listli :=" + (35 * (listli)));
			$(this).find(".categories-subs").css("top", ((39 * (listli)) - ((39 * (listli)) * 2) ));
			$(this).find(".categories-subs .whiteBox").css("top", (39 * (listli)));
			$(this).find(".categories-subs").removeClass("hide");
			$(this).addClass("category-active");
		}
	});

	$(".categories-list>li").mouseout(function() {
		if (window_width > 767) {
			$(this).find(".img-li-active").addClass("hide");
			$(this).find(".img-li-inactive").removeClass("hide");
			$(this).find(".categories-subs").addClass("hide");
			$(this).removeClass("category-active");
		}
	});

	$(".right-menubar li").mouseover(function() {
		$(this).find(".black-icon").addClass("hide");
		$(this).find(".white-icon").removeClass("hide");
	});

	$(".right-menubar li").mouseout(function() {
		$(this).find(".white-icon").addClass("hide");
		$(this).find(".black-icon").removeClass("hide");
	});

	$(".product-carousel").mouseover(function() {
		if (window_width > 767) {
			$(this).find(".carousel-control").removeClass("hide");
		}
	});
	$(".product-carousel").mouseout(function() {
		if (window_width > 767) {
			$(this).find(".carousel-control").addClass("hide");
		}
	});

	$(".main-carousel").mouseover(function() {
		if (window_width > 767) {
			$(this).find(".carousel-control").removeClass("hide");
		}
	});
	$(".main-carousel").mouseout(function() {
		if (window_width > 767) {
			$(this).find(".carousel-control").addClass("hide");
		}
	});


});

/*
function setProductCarouselData() {

	console.log("in set produc");

	var carouselInner1 = "";

	if ($(window).width() > 767) {

		carouselInner1 += "<div class='item active'>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51ZTpg.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51Yiwb3cJ2L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/31v-ZTNPvpL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/fall1_halloween_peripherals_440x200V2._V292539974_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='item'>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/camera1.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/41FdjwzE3-L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/51y3-015AeL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/fall1_halloween_peripherals_440x200V2._V292539974_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		$(".product-CarouselInner").html(carouselInner1);

	} else {

		carouselInner1 += "<div class='item active'>";
		carouselInner1 += "<div class='col-xs-6'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51ZTpg.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51Yiwb3cJ2L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		carouselInner1 += "<div class='item'>";
		carouselInner1 += "<div class='col-xs-6'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/31v-ZTNPvpL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/camera1.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		carouselInner1 += "<div class='item'>";
		carouselInner1 += "<div class='col-xs-6'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/41FdjwzE3-L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/51y3-015AeL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		$(".product-CarouselInner").html(carouselInner1);

	}
}

function setFeatureProductCarouselData() {

	var carouselInner1 = "";

	if ($(window).width() > 767) {

		carouselInner1 += "<div class='item active'>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/camera1.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/41FdjwzE3-L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/51y3-015AeL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/fall1_halloween_peripherals_440x200V2._V292539974_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		carouselInner1 += "<div class='item'>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51ZTpg.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51Yiwb3cJ2L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/31v-ZTNPvpL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-3'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/fall1_halloween_peripherals_440x200V2._V292539974_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		$(".feature-Product-CarouselInner").html(carouselInner1);

	} else {

		carouselInner1 += "<div class='item active'>";
		carouselInner1 += "<div class='col-xs-6 col-sm-4'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/31v-ZTNPvpL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-4'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/camera1.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		carouselInner1 += "<div class='item'>";
		carouselInner1 += "<div class='col-xs-6 col-sm-4'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51ZTpg.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-4'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto dmargin-auto' src='assets/images/51Yiwb3cJ2L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		carouselInner1 += "<div class='item'>";
		carouselInner1 += "<div class='col-xs-6 col-sm-4'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/41FdjwzE3-L._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "<div class='col-xs-6 col-sm-4'>";
		carouselInner1 += "<div class='inner-product'>";
		carouselInner1 += "<img class='img-responsive margin-auto' src='assets/images/51y3-015AeL._AC_SY220_.jpg' alt='...' />";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";
		carouselInner1 += "</div>";

		$(".feature-Product-CarouselInner").html(carouselInner1);

	}
}
*/