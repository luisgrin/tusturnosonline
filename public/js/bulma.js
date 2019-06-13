// The following code is based off a toggle menu by @Bradcomp
// source: https://gist.github.com/Bradcomp/a9ef2ef322a8e8017443b626208999c1
(function() {
    //var burger = document.querySelector('.burger');
    //var menu = document.querySelector('#'+burger.dataset.target);

    tosAgree = function(target){
      localStorage.setItem("tosagree",true)
      document.querySelector('.tosprompt').classList.remove('slideIn')
      document.querySelector('.tosprompt').classList.add('fadeOut')      
      setTimeout(() => {
        document.querySelector('.tosprompt').style.display = 'none';
      },1000)
    }

    getOffset = function(){
      return parseInt(Math.sqrt(Math.pow($(window).width(),2) + Math.pow($(window).height(),2)) / 40 * 1.25)
    }
    
    adjustPadding = function() {
      var offset = getOffset()
      $('body').css({'padding-left': offset + 'px'})
      $('.wp-action-space, .navbar').css({'left': offset + 'px'})
    }

    $(document).on('click','.menu-burger, .menu-items',function() {
      $('.menu-bg, .menu-items, .menu-burger').toggleClass('fs');
      $('.menu-burger').text() == "☰" ? $('.menu-burger').text('✕') : $('.menu-burger').text('☰');      
    });

    /*burger.addEventListener('click', function() {
      burger.classList.toggle('is-active');
      menu.classList.toggle('is-active');
    });*/

    if(!localStorage.getItem("tosagree")){
      document.querySelector('.tosprompt').classList.add('slideIn')
    } else {
      document.querySelector('.tosprompt').style.display = 'none';
    }

    adjustPadding();
    window.onresize = function(event) {
      adjustPadding();
    };

})();