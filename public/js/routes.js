const Contact = {
  template: '#contact',
  name:'contact',
  created: function(){
    this.data.reason = this.hash
  },
  methods : {
    submit : function({type, target}){
      if(!this.acceptTerms){
        this.$root.snackbar('error','Debe aceptar los términos y condiciones')
      } else {
        if(this.$root.filters.token().token){
          this.data.user_id = this.$root.filters.token().id
          this.data.email = this.$root.filters.token().email
          this.data.first_name = this.$root.filters.token().first_name
          this.data.last_name = this.$root.filters.token().last_name
        }
        this.$root.loading = true
        this.$http.post('/api/contact', this.data, {emulateJSON:true}).then(function(res){
          this.$root.loading = false
          if(res.body.status==='success'){
            this.$root.snackbar('success','Su mensaje ha sido enviado. Gracias por tomarse el tiempo de escribirnos. Le responderemos pronto.')
          }
        }, function(error){
          this.$root.loading = false
          this.$root.snackbar('error',error.statusText)
        })
      }
    }
  },
  data: function() {
    return{
      acceptTerms:false,
      data:{},
      hash: location.hash.replace('#','')
    }
  }
}

const SignIn = {
  template: '#login',
  methods: {
    submit : function({type, target}){
      if(!this.$root.processing){
        this.$root.processing = true
        this.$http.post('/api/auth/login', this.data, {emulateJSON:true}).then(function(res){
          if(res.data.status === 'ok'){
            localStorage.setItem("token", JSON.stringify(res.data))
            this.$root.snackbar('success','La sesión fue iniciada correctamente. Redirigiendo...')
            setTimeout(function(){
              app.$router.push('/account')  
            },3000)
          } else {
            this.$root.snackbar('error',res.data.message)
          }
          this.$root.processing = false
        }, function(error){
          this.$root.processing = false
          this.$root.snackbar('error','Datos incorrectos')
        })
      }
    }
  },
  data: function() {
    return{
      data:{}
    }
  }
}

const SignUp = {
  template: '#signup',
  methods: {
    submit : function({type, target}){
      if(!this.acceptTerms){
        this.messageType = 'is-danger'
        this.$root.snackbar('error','Debes aceptar nuestros términos y condiciones')
      } else {
        this.$root.processing = true
        this.$http.post('/api/auth/signup', this.data, {emulateJSON:true}).then(function(res){
          localStorage.setItem("token", JSON.stringify(res.data))
          this.$root.processing = false
          this.$root.snackbar('success','Tu cuenta ha sido creada con éxito. Redirigiendo')
          setTimeout(function(){
            app.$router.push('/account')
          },3000)
        }, function(error){
          this.$root.snackbar('error',error.statusText)
        })
      }
      return false
    }    
  },
  data: function() {
    return{
      acceptTerms:false,
      data:{}
    }
  }
}

const RecoverPassword = {
  template: '#recoverpassword',
  methods: {
    submit : function({type, target}){
      if(!this.$root.processing){
        this.$root.processing = true
        this.$http.post('/api/auth/recover-password', this.data, {emulateJSON:true}).then(function(res){
          if(res.data.status === 'success'){
            this.$root.loading = false
            this.$root.snackbar('success','Revisa tu email y sigue el enlace para recuperar tu contraseña.')
          } else {
            this.$root.loading = false
            this.$root.snackbar('error',res.data.message)
          }
          this.$root.processing = false
        }, function(error){
          console.log(error.statusText)
        })
        return false
      }
    }
  },
  data: function() {
    return{
      data:{}
    }
  }
}

const UpdatePassword = {
  template: '#updatepassword',
  mounted:function(){
    this.token = this.$route.query.token||""
  },
  methods: {
    submit : function({type, target}){
      if(!this.$root.loading){
        this.$root.loading = true
        this.$http.post('/api/auth/update-password', this.data, {emulateJSON:true}).then(function(res){
          this.data = res.data
          if(res.data.status === 'success'){
            this.$root.loading = false
            this.$root.snackbar('success','Actualizaste correctamente tu contraseña. Te redirigiremos a la sección de ingreso. Por favor inicia sesión.')
            setTimeout(function(){
              this.$root.loading = false
              app.$router.push('/sign-in')
            },10000)
          } else {
            this.$root.loading = false
            this.$root.snackbar('error',res.data.message)
          }
        }, function(error){
          console.log(error.statusText)
        })
      }
    }
  },
  data: function() {
    return{
      token:null,
      data:{}
    }
  }
}

const Clientes = {
  template: '#clientes',
  name: 'clientes',
  mounted: function(){
    this.$root.message = ''
    this.$root.loading = true
    this.$http.get('/api/clientes', {}, {emulateJSON:true}).then(function(res){
      this.$root.loading = false
      this.data = res.data
    })
  },
  methods: {
    remove:function({type,target}){
      if(confirm("¡Atención! La eliminación es permanente.\nUna vez confirmado los datos no se podrán recuperar. ¿Estás seguro que deseas eliminar este cliente?")){
        this.$root.processing = true
        if(target.id){
          this.$http.delete('/api/cliente/' + target.id, {}, {emulateJSON:true}).then(function(res){
            if(res.data){
              this.$root.snackbar('success','El cliente ha sido eliminado de forma permanente.')
              var data2 = []
              this.data.forEach((item) => {
                if(item.id != target.id){
                  data2.push(item)
                }
              })       

              this.data = data2         
            }
            this.$root.processing = false
          })
        }
      }
    },
    add:function({type,target}){
      this.$root.processing = true
      this.$http.post('/api/cliente', this.item, {emulateJSON:true}).then(function(res){
        if(res.data.id){
          this.$root.snackbar('success','Se ha agregado correctamente el cliente.')
          this.data.push(res.data)
          this.item = {}
        }
        this.$root.processing = false
      })
    },
    more:function({type,target}){
      if(target.id){
        this.$router.push('/color/' + target.id)
      }
    }
  },
  data: function() {
    return{
      data:[],
      item:{}
    }
  }
}

const Cliente = {
  template: '#cliente',
  name: 'cliente',
  mounted: function(){
    this.$root.message = ''
    this.$root.loading = true
    this.$http.get('/api/clientes/' + location.pathname.split('/').reverse()[0], {}, {emulateJSON:true}).then(function(res){
      this.$root.loading = false
      this.data = res.data
    })
  },
  methods: {
    submit : function({type, target}){
      this.$root.processing = true
      this.$http.post('/api/cliente/' + this.data.id, this.data, {emulateJSON:true}).then(function(res){
        this.$router.push('/clientes')
        setTimeout(() => {
          if(res.data.id){
            this.$root.snackbar('success','Cliente actualizado')
          } else {
            this.$root.snackbar('success','Error al actualizar registro')
          }
        },300)
      })
    }
  },
  data: function() {
    return{
      data:{}
    }
  }
}

const Atributos = {
  template: '#atributos',
  name: 'atributos',
  mounted: function(){
    this.$root.message = ''
    this.$root.loading = true
    this.$http.get('/api/atributos', {}, {emulateJSON:true}).then(function(res){
      this.$root.loading = false
      this.data = res.data
    })
  },
  methods: {
    remove:function({type,target}){
      if(confirm("Una vez confirmado los datos no se podrán recuperar. ¿Estás seguro que deseas eliminar esta fórmula?")){
        this.$root.processing = true
        if(target.id){
          this.$http.delete('/api/atributo/' + target.id, {}, {emulateJSON:true}).then(function(res){
            if(res.data){
              this.$root.snackbar('success','El atributo ha sido eliminado de forma permanente.')
              var data2 = []
              this.data.forEach((item) => {
                if(item.id != target.id){
                  data2.push(item)
                }
              })       

              this.data = data2         
            }
            this.$root.processing = false
          })
        }
      }
    },
    add:function({type,target}){
      if(!this.item.tipo){
        return this.$root.snackbar('error','Ingrese tipo de dato')
      }
      this.$root.processing = true
      this.$http.post('/api/atributo', this.item, {emulateJSON:true}).then(function(res){
        if(res.data.id){
          this.$root.snackbar('success','Se ha agregado correctamente el <b>atributo</b>.')
          this.data.push(res.data)
          this.item = {}
        }
        this.$root.processing = false
      })
    },
    more:function({type,target}){
      if(target.id){
        this.$router.push('/color/' + target.id)
      }
    }
  },
  data: function() {
    return{
      data:[],
      item:{}
    }
  }  
}

const Atributo = {
  template: '#atributo',
  name: 'atributo',
  mounted: function(){
    this.$root.message = ''
    this.$root.loading = true
    this.$http.get('/api/atributos/' + location.pathname.split('/').reverse()[0], {}, {emulateJSON:true}).then(function(res){
      this.$root.loading = false
      this.data = res.data
    })
  },
  methods: {
    submit : function({type, target}){
      this.$root.processing = true
      this.$http.post('/api/atributo/' + this.data.id, this.data, {emulateJSON:true}).then(function(res){
        this.$router.push('/atributos')
        setTimeout(() => {
          if(res.data.id){
            this.$root.snackbar('success','Cliente actualizado')
          } else {
            this.$root.snackbar('success','Error al actualizar registro')
          }
        },1000)
      })
    }
  },
  data: function() {
    return{
      data:{}
    }
  }
}

const Carga = {
  template: '#carga',
  name: 'carga',
  mounted: function(){
    var id = location.hash.replace('#','')
    if(!this.$root.atributos.length){
      this.$root.message = ''
      this.$root.loading = true
      this.$http.get('/api/atributos', {}, {emulateJSON:true}).then(function(res){
        this.$root.loading = false
        this.$root.atributos = res.data
      })
    }
    if(!isNaN(id)){
      this.checkItem(id)
    }
  },  
  methods: {
    buscarCliente:function({type,target}){
      clearInterval(this.clock)
      this.clock = setTimeout(() => {
        this.$root.message = ''
        this.$root.processing = true
        this.$http.get('/api/clientes/buscar/' + target.value, {}, {emulateJSON:true}).then(function(res){
          this.$root.processing = false
          this.suggests = res.data
        })
      },500)
    },
    more:function(item){
      location.hash = item.id
      this.item = item
    },
    focusNom:function({type,target}){
      this.nom = target.value
      target.value = ''
    },
    blurNom:function({type,target}){
      target.value = this.nom
    },
    setPH:function({type,target}){
      var nom = $('#atributo').find(':selected').text()
      this.$root.tipodatos.forEach((tipodato) => {
        if(nom===tipodato.val){
          this.placeholder = tipodato.placeholder
        }
      })
    },
    checkItem: function(id){
      this.$root.processing = true
      this.$http.get('/api/clientes/atributos/' + id, {}, {emulateJSON:true}).then(function(res){
        this.$root.processing = false
        this.data = res.data.atributos
        this.item = res.data
        this.selection = res.data
        this.suggests = []
      })
    },
    remove:function({type,target}){
      if(!this.$root.processing){
        if(confirm("Una vez confirmado los datos no se podrán recuperar. ¿Estás seguro que deseas eliminar esta fórmula?")){
          this.$root.processing = true
          if(target.id){
            this.$http.delete('/api/clienteatributo/' + target.id, {}, {emulateJSON:true}).then(function(res){
              if(res.data){
                this.$root.snackbar('success','El atributo ha sido eliminado de forma permanente.')
                var data2 = []
                this.data.forEach((item) => {
                  if(item.id != target.id){
                    data2.push(item)
                  }
                })
                this.data = data2
              } else {
                this.$root.snackbar('error',res.data.error)
              }
              this.$root.processing = false
            })
          }
        }
      }
    },
    add:function({type,target}){
      this.$root.processing = true
      this.$http.post('/api/atributo', this.item, {emulateJSON:true}).then(function(res){
        if(res.data.id){
          this.$root.snackbar('success','Se ha agregado correctamente el <b>atributo</b>.')
          this.data.push(res.data)
          this.item = {}
        }
        this.$root.processing = false
      })
    },
    submit : function({type, target}){
      this.$root.processing = true
      var data = {
        cliente_id:this.item.id,
        crm_atributo_id:this.selection.atributo_id,
        valor:this.selection.valor
      }
      this.$http.post('/api/clienteatributo', data, {emulateJSON:true}).then(function(res){
        if(res.data.id){
          this.data.push({
            atributo:{
              nom:$('#atributo').find(':selected').text()
            },
            valor:res.data.valor,
            id:res.data.id
          })
          this.$root.snackbar('success','Se agregó atributo a cliente')
        } else {
          this.$root.snackbar('error',res.data.error)
        }
        this.$root.processing = false
      }, function(error){
        this.$root.snackbar('error',error.statusText)
      })
      return false
    }    
  },
  data: function() {
    return{
      clock:0,
      nom:'',
      placeholder:'Ingrese un valor',
      attributos:[],
      suggests:[],
      selection:{},
      data:[],
      item:{},
      hash:''
    }
  }
}

const Account = {
  template: '#account',
  name: 'account',
  mounted: function(){
    this.$root.message = ''
    this.$root.loading = false
  },
  methods: {
  },
  data: function() {
    return{
      data:{}
    }
  }
}

const EditAccount = {
  template: '#editaccount',
  mounted: function(){
    this.$root.message = ''
    this.$root.loading = true
    this.$http.get('/api/auth/me', {}, {emulateJSON:true}).then(function(res){
      this.$root.loading = false
      this.data = res.data
    })
  },  
  methods : {
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
        return;
      this.createImage(files[0])
      this.uploadImage(files[0])
    },
    createImage(file,code) {
      var reader = new FileReader();
      reader.onload = (e) => {
        $('.picture').css({
          'background-image': 'url(' + e.target.result + ')',
          'background-size': 'cover'
        });
        var exif = EXIF.readFromBinaryFile(new base64ToArrayBuffer(e.target.result));
        //fixExifOrientation(exif.Orientation, $id);
      };
      reader.readAsDataURL(file);
    },
    removeImage: function (e) {
      this.image = '';
    }, 
    clickImage : function(){
      this.upload = true
      $("#uploads").click()
      return false
    },
    uploadImage : function(file){

      var formData = new FormData();
      formData.append('image', file);
      var token = $.parseJSON(localStorage.getItem("token")) || {}
      var self = this

      this.upload = true
      this.$root.processing = true
      this.$root.snackbar('success','Cargando imagen...')
      //loading
      //$('.profile'+type+'--link').text("Subiendo...");
      $.ajax({
        type:'post',
        url: '/api/fotoperfil',
        data:formData,
        beforeSend: function (xhr) { 
          xhr.setRequestHeader('Authorization', 'Bearer ' + token.token); 
        },          
        xhr: function() {
          var myXhr = $.ajaxSettings.xhr()
          if(myXhr.upload){
            myXhr.upload.addEventListener('progress',function(e){
              if(e.lengthComputable){
                var max = e.total
                var current = e.loaded
                var percentage = (current * 100)/max

                console.log("subiendo : " + parseInt(percentage))

                if(percentage >= 100) {
                  self.uploading = false
                }
              }
            }, false);
          }
          return myXhr;
        },
        cache:false,
        contentType: false,
        processData: false,
        success:function(res){
          if(res.status==='error'){
            self.$root.snackbar('error',res.error.split("\n"))
          } else{
            var token = $.parseJSON(localStorage.getItem("token")) || {}
            token.picture = res.url
            localStorage.setItem("token", JSON.stringify(token))
            self.$root.processing = false
            self.$root.snackbar('success','Image has been correctly uploaded.')
          }
        },
        error: function(data){
          self.$root.processing = false
          self.$root.snackbar('error','Image has not been uploaded.')
          console.log("Hubo un error al subir el archivo");
        }
      })
    },    
    submit : function({type, target}){
      if(!this.$root.processing){
        this.$root.processing = true
        this.$http.post('/api/account/update', this.data, {emulateJSON:true}).then(function(res){
          this.data = res.data
          var token = $.parseJSON(localStorage.getItem("token")) || {}

          token.first_name = this.data.first_name
          token.last_name = this.data.last_name
          token.email = this.data.email
          localStorage.setItem("token", JSON.stringify(token))

          this.$root.processing = false
          this.$root.snackbar('success','Cuenta actualizada.')

          //helper.is_loaded()
        }, function(error){
          this.$root.processing = false
          this.$root.snackbar('error',error.statusText)
        })
      }
    }
  },
  data: function() {
    return{
      acceptTerms:false,      
      data:{},
      hash : location.hash.replace('#','')
    }
  }
}

const ChangePassword = {
  template: '#changepassword',
  methods : {
    submit : function({type, target}){
      if(!this.$root.loading){
        this.$root.loading = true
        this.$http.post('/api/account/password', this.data, {emulateJSON:true}).then(function(res){
          this.$root.loading = false
          this.$root.snackbar(res.data.messageType,res.data.message)
        }, function(error){
          this.$root.loading = false
          this.$root.snackbar('error',error.statusText)
        })
      }
    }
  },
  data: function() {
    return{
      data:{},
      acceptTerms:false,      
      hash : location.hash.replace('#','')
    }
  }
}

const Section = {
  template: '#section',
  name:'section',
  mounted: function() {
    this.$root.loading = true 
    var self = this
    this.$http.post('/api/secciones'+location.pathname, {}, {emulateJSON:true}).then(function(res){
      this.data = res.data

      if(this.data.posts){
        this.data.content = this.data.content.replace('{{slider}}',$.templates('#slider').render(this.data))
        setTimeout(function(){
          self.slick()
        },100)
      }

      document.title = this.data.title

      self.$root.loading = false
    }, function(error){
      $('.hero-body').html($.templates('#notfound').render())
      self.$root.loading = false
      console.log(error.statusText)
    })  
  },  
  methods: {
    slick : function(){
      /*$('.slick').slick({
        slidesToShow: 1,
        dots: true
      }).removeClass('loading').addClass('fadeIn')*/
    }
  },
  data: function() {
    return{
      data:{},
      url: this.$route.query.url
    }
  }
}

const Opener = {
  template: '#opener',
  mounted: function() {
    var self = this
    localStorage.setItem("token", this.$route.query.token);
    setTimeout(function(){
      location.href = self.url;
    },1000)
  },  
  data: function() {
    return{
      url: this.$route.query.url
    }
  }
}

const SessionEnded = {
  template: '#sessionended',
  mounted:function(){
    $('section.hero').addClass('is-success')
  },
  data: function() {
    return{
      hash : location.hash.replace('#','')
    }
  }
}

const SessionExpired = {
  template: '#sessionexpired',
  mounted:function(){
    $('section.hero').addClass('is-info')
  },
  data: function() {
    return{
      hash : location.hash.replace('#','')
    }
  }
}

const NotFound = {
  template: '#notfound',
  mounted:function(){
    $('section.hero').addClass('is-danger')
  },
  data: function() {
    return{
    }
  }
}

const router = new VueRouter({
  mode: 'history',
  routes: [
    {path: '/', component: SignIn, meta : { title: 'Tusturnosonline'}},
    {path: '/opener', component: Opener, meta : { title: 'Redirigiendo...'}},
    {path: '/sign-in', component: SignIn,  meta : { title: 'Iniciar sesión'}},
    {path: '/sign-up', component: SignUp,  meta : { title: 'Crear cuenta'}},
    {path: '/recover-password', component: RecoverPassword,  meta : { title: 'Recuperar cuenta'}},
    {path: '/update-password', component: UpdatePassword,  meta : { title: 'Actualizar cuenta'}},
    {path: '/session-ended', component: SessionEnded, meta : { title: 'Sesión finalizada'}},
    {path: '/session-expired', component: SessionExpired, meta : { title: 'Sesión expirada'}},
    {path: '/contact', component: Contact, meta : { title: 'Contacto'}},    
    {path: '/clientes', component: Clientes, meta : { title: 'Clientes', requiresAuth: true}},
    {path: '/clientes/*', component: Cliente, meta : { title: 'Cliente', requiresAuth: true}},
    {path: '/atributos', component: Atributos, meta : { title: 'Atributos', requiresAuth: true}},
    {path: '/atributos/*', component: Atributo, meta : { title: 'Atributos', requiresAuth: true}},
    {path: '/carga', component: Carga, meta : { title: 'Carga', requiresAuth: true}},
    {path: '/account', component: Account, meta : { title: 'Tusturnosonline', requiresAuth: true}},
    {path: '/edit', component: EditAccount,  meta : { title: 'Mi cuenta', requiresAuth: true}},
    {path: '/password', component: ChangePassword,  meta : { title: 'Cambiar contraseña', requiresAuth: true}},
    {path: "*", component: Section, meta : { title: ''}}
  ]
});

router.beforeEach(function (to, from, next) { 
  document.title = to.meta.title;
  var token = $.parseJSON(localStorage.getItem("token")) || {}

  if(token.token){
    setTimeout(() => {
      filters.refreshToken()  
    },3000)
  }

  setTimeout(function() {
    var body = $("html, body");
    body.stop().animate({scrollTop:0}, 250, 'swing', function() { 
    });
  }, 10)

  if(to.meta.requiresAuth) {
    if(token.token) {
      next()
    } else {
      next('/')
    }    
  } else {
    next()
  }
})

router.afterEach(function (to, from, next) {
  setTimeout(function() {
    $('.ui-snackbar').removeClass('ui-snackbar--is-active').addClass('ui-snackbar--is-inactive')
    if(to.meta.customNavbar){
      $('.custom-navbar .title').html(to.meta.title)
      $('.custom-navbar .icon').attr('src',to.meta.icon)
      $('.custom-navbar').show()
    } else {
      $('.custom-navbar').hide()      
    }
    if(to.meta.requiresAuth){
      $('.footer, .scrollmap').hide()
    } else {
      $('.footer, .scrollmap').show()
    }
  }, 100)
})

Vue.http.interceptors.push(function(request, next) {
  var token = $.parseJSON(localStorage.getItem("token")) || {}
  //request.headers.set('Access-Control-Allow-Credentials', true)
  request.headers.set('Authorization', 'Bearer '+ token.token)
  request.headers.set('Content-Type', 'application/json')
  request.headers.set('Accept', 'application/json')
  next()
})

const app = new Vue({ router: router,
  data : {
    customNavbar: false,
    hideSignIn:false,
    loading: true,
    processing:false,
    navitems:{},
    atributos:[],
    messageType:'default',
    message:'',
    tipodatos:[{
      nom:'entero',
      val:'Entero',
      placeholder:'ej. 1,2,3 ...'
    },{
      nom:'decimal',
      val:'Decimal',
      placeholder:'ej. 1.44, 7.67, 10.00 ...'
    },{
      nom:'fecha',
      val:'Fecha',
      placeholder:'ej. 1984-01-01, 01/01/1984 ... '
    },{
      nom:'direccion_google',
      val:'Dirección',
      placeholder:'ej. Libertad 1225, Av. Fundadores 2440, ...'
    },{
      nom:'caracter',
      val:'Caracter',
      placeholder:'ej. A, B, C ...'
    }],
    filters:filters
  },
  mounted: function() {
    this.loading = false
  },
  created: function () {
    this.$http.post('/api/navitems', {}, {emulateJSON:true}).then(function(res){
      $('.footer').html(res.data.footer);
      $('.hidden-loading').removeClass('hidden-loading')
      this.navitems = res.data.navitems
      //$('.menu-links').html($.templates('#navbaritem').render(res.data.navitems))
      //$('.menu-links').find('a[href="' + location.pathname + '"]').parent().addClass('is-active')
      this.loading = false
    }, function(error){
      if(error) this.snackbar('error','Error al solicitar datos de la aplicación.')
    }) 
    this.checkFlags(this.$route)
  },
  methods : {
    token: function(){
      return JSON.parse(localStorage.getItem("token")) || {}
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
    homeClick:function(){
      var token = $.parseJSON(localStorage.getItem("token")) || {}
      this.$router.push((token.token?'/account':'/'))
    },     
    scrollUp: function(){
      var body = $("html, body");
      body.stop().animate({scrollTop:0}, 500, 'swing', function() { 
      });
    },
    scrollDown: function(){
      var scrollpos = $(window).scrollTop() + 1;
      var body = $("html, body");
      if(scrollpos < $(window).height() * 0.65){
        body.stop().animate({scrollTop:$(window).height() * 0.65}, 500, 'swing', function() {           
        })
      } else {
        body.stop().animate({scrollTop:$(document).height()}, 500, 'swing', function() {   
        })
      }
    },
    checkFlags:function(route){
      this.hideSignIn = false
      if($.inArray(route.path,['/','/sign-in']) > -1){
        this.hideSignIn = true
      }
    },
    snackbar : function(messageType,message,timeout){
      if(timeout===undefined) timeout = 5000
      this.messageType = messageType
      this.message = message
      $('.ui-snackbar').removeClass('ui-snackbar--is-inactive ui-snackbar--success ui-snackbar--error ui-snackbar--default').addClass('ui-snackbar--' + messageType).addClass('ui-snackbar--is-active')
      setTimeout(() => {
        $('.ui-snackbar').removeClass('ui-snackbar--is-active').addClass('ui-snackbar--is-inactive')
      },timeout)
    },
    tosAgree: function(){
      localStorage.setItem("tosagree",true)
      document.querySelector('.tosprompt').classList.remove('slidin')
      document.querySelector('.tosprompt').classList.add('fadeout')      
      setTimeout(() => {
        document.querySelector('.tosprompt').style.display = 'none';
      },1000)
    }
  }
}).$mount('#app')