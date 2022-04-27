

var navbarToggler = document.querySelector('.navbar-toggler') ;
navbarToggler.onclick = function(){
    const navbarMenu = document.querySelector('.navbar-menu') ;
    if(navbarMenu.style.maxWidth == '0px'){
        navbarMenu.style.maxWidth = navbarMenu.scrollWidth + 'px'
    }else{
        navbarMenu.style.maxWidth = 0 + 'px'
    }
}

var dropdownToggler = document.getElementsByClassName('dropdown-toggle') ;
var dropdownMenu = document.getElementsByClassName('dropdown-menu') ;
for( var i = 0 ; i < dropdownToggler.length ; i++){
    dropdownToggler[i].onclick = function(){
        var panel = this.nextElementSibling ;
        var j = 0;

        if(panel.style.maxHeight == '0px'){
            for(var j = 0  ; j< dropdownMenu.length ; j++){
                dropdownMenu[j].style.maxHeight = 0 + 'px';
            }
            panel.style.maxHeight = panel.scrollHeight + 'px';
        }else{
            panel.style.maxHeight = 0+  'px' ;
        }
    }
    
}

var services = document.getElementsByClassName('service') ;
 window.onscroll = function(){
    for (let i = 0; i < services.length; i++) {
        var servicePosition = services[i].getBoundingClientRect().bottom ;
        var serviceOffset = services[i].offsetHeight/4 ;
        if(servicePosition <= window.innerHeight - serviceOffset){
            services[i].style.transform = 'translateY(0)';
            services[i].style.opacity = '1 ';
        }  
    }
    
}

const body = document.querySelector('body') ;

body.onload = function () {
    var partenariat = document.querySelector('.partenariat') ;
    if(partenariat){
        var items = document.querySelectorAll('.partenariat .item .img') ;
        partenariat.style.width = 190*items.length + "px" ;
    }
        
}
var translate = 0 ;
var next = document.getElementById('next') ;
if(next){
    next.onclick = function () {
        var partenariat = document.querySelector('.partenariat') ;
        if(partenariat.style.transform != "translate("+ (-12) +"%)"){
            translate-- ;
            partenariat.style.transform = "translate("+12*translate +"%)" ;
        }
    }
}
var prev = document.getElementById('prev') ;
if(prev){
    prev.onclick = function () {
            var partenariat = document.querySelector('.partenariat') ;
        if(partenariat.style.transform != "translate("+ 12 +"%)"){
            translate++;
            partenariat.style.transform = "translate("+ (12*translate) +"%)" ;
        }
    }
}