(function(b,a,c){b.fn.foundationButtons=function(l){var g=b(document),e=b.extend({dropdownAsToggle:false,activeClass:"active"},l),f=function(m){b(".button.dropdown").find("ul").not(m).removeClass("show-dropdown")},i=function(m){var n=b(".button.dropdown").not(m);n.add(b("> span."+e.activeClass,n)).removeClass(e.activeClass)};g.on("click.fndtn",".button.disabled",function(m){m.preventDefault()});b(".button.dropdown > ul",this).addClass("no-hover");g.on("click.fndtn",".button.dropdown:not(.split), .button.dropdown.split span",function(o){var n=b(this),m=n.closest(".button.dropdown"),p=b("> ul",m);if(o.target.nodeName!=="A"){o.preventDefault()}setTimeout(function(){f(e.dropdownAsToggle?p:"");p.toggleClass("show-dropdown");if(e.dropdownAsToggle){i(m);n.toggleClass(e.activeClass)}},0)});g.on("click.fndtn","body, html",function(m){if(c==m.originalEvent){return}if(!b(m.originalEvent.target).is(".button.dropdown:not(.split), .button.dropdown.split span")){f();if(e.dropdownAsToggle){i()}}});var h=b(".button.dropdown:not(.large):not(.small):not(.tiny):visible",this).outerHeight()-1,k=b(".button.large.dropdown:visible",this).outerHeight()-1,d=b(".button.small.dropdown:visible",this).outerHeight()-1,j=b(".button.tiny.dropdown:visible",this).outerHeight()-1;b(".button.dropdown:not(.large):not(.small):not(.tiny) > ul",this).css("top",h);b(".button.dropdown.large > ul",this).css("top",k);b(".button.dropdown.small > ul",this).css("top",d);b(".button.dropdown.tiny > ul",this).css("top",j);b(".button.dropdown.up:not(.large):not(.small):not(.tiny) > ul",this).css("top","auto").css("bottom",h-2);b(".button.dropdown.up.large > ul",this).css("top","auto").css("bottom",k-2);b(".button.dropdown.up.small > ul",this).css("top","auto").css("bottom",d-2);b(".button.dropdown.up.tiny > ul",this).css("top","auto").css("bottom",j-2)}})(jQuery,this);