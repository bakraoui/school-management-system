
// ---------  Popup Modal ----------
var popupModal =document.getElementsByClassName('popup-modal');
var closeModal =document.getElementsByClassName('close-btn');
for(var i=0 ; i < popupModal.length ; i++){
    popupModal[i].onclick = function(){
        const modal = this.nextElementSibling ;
        for(var j = 0 ; j< popupModal.length ; j++){
            popupModal[j].nextElementSibling.style.transform = 'scale(0)';
        }
         modal.style.transform = "scale(1)";
    }
    
}
for(var i=0 ; i < closeModal.length ; i++){
    closeModal[i].onclick = function(){
        for(var j = 0 ; j< popupModal.length ; j++){
            popupModal[j].nextElementSibling.style.transform = 'scale(0)';
        }
    }
    
}


var sidebar = document.querySelector('.sidebar') ;
var sidebarToggle =document.querySelector('.sidebar-toggle') ;
var mainContent = document.querySelector('.main-content');
var win = window.innerWidth ;
sidebarToggle.addEventListener('click',() => {
    if(win < 360){
        if(sidebar.style.width == 0+ '%'){
            sidebar.style.width = 100 + '%';
        }else{
            sidebar.style.width = 0 + '%';
           
        }
    }
    if(win >= 360){
        if(sidebar.style.width == 0+ '%'){
            sidebar.style.width = 50 + '%';
        }else{
            sidebar.style.width = 0 + '%';
        }
    }
    
    if(win > 576){
        if(sidebar.style.width == 0 + '%'){
            sidebar.style.width = 30 + '%';
        }else{
            sidebar.style.width = 0 + '%';
        }
    }

})
   




var dropdownBtn = document.querySelector('.dropdown-btn') ;
var dropdownContent = document.querySelector('.dropdown-content') ;
if(dropdownBtn){
    dropdownBtn.onclick = function(){
        if(dropdownContent.style.maxHeight == 0 +'px' ){
            dropdownContent.style.maxHeight = dropdownContent.scrollHeight + 'px' ;
        }else{
            dropdownContent.style.maxHeight = 0 +'px'
        }
    } 
}


var notificationToggle = document.querySelector('.notification-toggle');
if(notificationToggle){
    notificationToggle.onclick = function () {
        var notifications = document.querySelector('.notifications');
        
        if (notifications.style.display == 'none') {
            notifications.style.display = 'block';
        } else {
            notifications.style.display = 'none';
        }
    }
}


const accord = document.getElementsByClassName('accord') ;
if(accord){
    for(var i = 0;i<accord.length ; i++){
        accord[i].onclick = function(){
            const collapse = this.nextElementSibling ;
            if(collapse.style.maxHeight == 0+"px"){
                collapse.style.maxHeight = collapse.scrollHeight+"px";
            }else{
                collapse.style.maxHeight = 0+"px"
            }
        }
    }
}