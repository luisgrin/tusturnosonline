var errorCallback = function(error){
  console.log(error.statusText)
  if(error.statusText==='Unauthorized'){
    localStorage.removeItem('token')
    app.$router.push('/session-expired')
  }
  app.$root.loading = false
  setTimeout(() => { app.$root.snackbar('error',error.statusText) },200)
}
var filters = {
  token: function(){
    return JSON.parse(localStorage.getItem("token")) || {}
  },
  cache: function(){
    return JSON.parse(localStorage.getItem("cache")) || {}
  },
  download: function(settings){
    var target = settings.target,
    that = target,
    token = settings.token,
    url = settings.url,
    type = settings.type,
    data = settings.data||{},
    dataType = settings.dataType||'binary'
    filename = settings.filename,
    contentType = settings.contentType||'application/json'
    if(!$(target).hasClass('is-loading')){
      $(target).addClass('is-loading')
    }
    $.ajax({
      type:'post',
      url: url,
      dataType: dataType,
      contentType:contentType,
      data:data,
      beforeSend: function (xhr) { 
        xhr.setRequestHeader('Authorization', 'Bearer ' + token.token); 
      },      
      xhrFields: {
        responseType: 'blob'
      },            
      success: function(res) {
        $(that).removeClass('is-loading')
        var blob = new Blob([res], { type: type });
        var link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = filename
        document.body.appendChild(link);
        link.click()
        if(typeof settings.done === 'function') settings.done()
      },
      error: function(xhr) {
        $(that).removeClass('is-loading')
        alert("Error al generar documento. Por favor intente nuevamente en unos instantes.")
      }
    })
  },
  cache : function(){
    return $.parseJSON(localStorage.getItem("cache")) || {}
  },
  toJSON : function(json){
    return JSON.stringify(json)
  },
  formatDate : function(date){
    return moment(date,'X').format('DD MMM hh:mm');
  },
  isHumanTime : function(date){
    return moment(date,'X').fromNow()
  },
  isRecent : function(date){
    var a = moment()
    , b = moment(date,'X')
    , diff = a.diff(b,'seconds')
    return (diff < 3600)
  },
  isVeryRecent : function(date){
    var a = moment()
    , b = moment(date,'X')
    , diff = a.diff(b,'seconds')
    return (diff < 8)
  },
  updateStorage:function(key,pairs){
    var obj = JSON.parse(localStorage.getItem(key))||{}
    for (var k in pairs) {
      if (pairs.hasOwnProperty(k)) {
        obj[k] = pairs[k];
      }
    }
    localStorage.setItem(key,JSON.stringify(obj))
  },
  endSessionWithConfirm:function(redirect){
    if(confirm("Está seguro que desea finalizar su sesión?")){
      if(redirect==undefined) redirect = '/session-ended'
      localStorage.removeItem("token")
      setTimeout(function(){
        if(location.pathname === redirect){
          location.href = redirect,true
        } else {
          app.$router.push(redirect)
        }      
      },200)
    }
  },
  endSession:function(redirect){
    if(redirect==undefined) redirect = '/session-ended'
    localStorage.removeItem("token")
    setTimeout(function(){
      if(location.pathname === redirect){
        location.href = redirect,true
      } else {
        app.$router.push(redirect)
      }      
    },200)
  },
  refreshToken : function() {
    $.server({
      url: '/api/auth/refresh',
      success: function(res) {
        if(res.token) {
          localStorage.setItem("token", JSON.stringify(res))
        }
      },
      error: function(xhr) {
        filters.endSession('/session-expired')
      }
    })
  },
  fixExifOrientation : function(int, element) {
    switch(parseInt(int)) {
      case 2:
        element.parent().addClass('loaded');
        element.addClass('flip');
        break;
      case 3:
        element.parent().addClass('loaded');
        element.addClass('rotate-180');
        break;
      case 4:
        element.addClass('flip-and-rotate-180');
        break;
      case 5:
        element.addClass('flip-and-rotate-270');
        break;
      case 6:
        element.parent().addClass('loaded');
        element.addClass('rotate-90');
        break;
      case 7:
        element.addClass('flip-and-rotate-90');
        break;
      case 8:
        element.addClass('rotate-270');
        break;
    }
  }
}
$(document).on('click','.notification .delete',function(){
  $(this).parents('.notification').fadeOut();
})

$(document).on('click',"a:not([href*=':'])",function(event){

  const target = this
  // handle only links that do not reference external resources
  if (target && target.href && !$(target).attr('bypass')) {
    // some sanity checks taken from vue-router:
    // https://github.com/vuejs/vue-router/blob/dev/src/components/link.js#L106
    const { altKey, ctrlKey, metaKey, shiftKey, button, defaultPrevented } = this
    // don't handle with control keys
    if (metaKey || altKey || ctrlKey || shiftKey) return
    // don't handle when preventDefault called
    if (defaultPrevented) return
    // don't handle right clicks
    if (button !== undefined && button !== 0) return
    // don't handle if `target="_blank"`

    if (target && target.getAttribute) {
      const linkTarget = target.getAttribute('target')
      if (/\b_blank\b/i.test(linkTarget)) return
    }
    // don't handle same page links/anchors
    const url = new URL(target.href)
    const to = url.pathname

    if (window.location.pathname !== to) {
      app.$router.push(to)
    }

    event.preventDefault()
  }  
})

$.extend({
  server: function(options) {
    options.method = "post";
    options.cache = false;
    options.async = true;
    options.then = options.then;
    var token = $.parseJSON(localStorage.getItem("token")) || {}
    if(token.token) {
      options.beforeSend = function(xhr) {
        xhr.setRequestHeader('Authorization', 'Bearer ' + token.token);
      };
    }
    var jqXHR = $.ajax(options).then(options.then);
    jqXHR.done(function() {});
  }
});

$.ajaxSetup({
  dataType : "json",
  contentType: "application/json; charset=utf-8"
})

$.views.settings.delimiters("[[", "]]")
moment.locale('en')

