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
          console.log(error.statusText)
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
          if(res.data.status === 'success'){
            this.data = res.data
            this.$root.snackbar('success','La sesión fue iniciada correctamente. Redirigiendo...')
            setTimeout(function(){
              localStorage.setItem("token", JSON.stringify(res.data))
              app.$router.push('/account')  
            },2000)
          } else {
            this.$root.snackbar('error',res.data.message)
          }
          this.$root.processing = false
        }, function(error){
          console.log(error.statusText)
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
        var self = this
        var data = {}

        $.map( $(target).serializeArray(), function( i ) {
          data[i.name] = i.value
        })

        this.$http.post('/api/auth/update-password', data, {emulateJSON:true}).then(function(res){
          this.data = res.data
          if(res.data.status === 'success'){
            self.$root.loading = false
            self.$root.snackbar('success','Actualizaste correctamente tu contraseña. Te redirigiremos a la sección de ingreso. Por favor inicia sesión.')
            setTimeout(function(){
              self.$root.loading = false
              app.$router.push('/sign-in')
            },10000)
          } else {
            self.$root.loading = false
            self.$root.snackbar('error',res.data.message)
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

const FormularColor = {
  template: '#formularcolor',
  name:'formularcolor',
  mounted:function(){

    this.$root.loading = true
    localStorage.removeItem("quote")    
    localStorage.removeItem("texture")    

    var texture=JSON.parse(localStorage.getItem("texture"))||{}
    if(texture) {
      this.texture = texture
      this.selected = texture.id
    }

    localStorage.removeItem("quote")    
    localStorage.removeItem("texture")    
    this.$http.post('/api/account/formularcolor', {}, {emulateJSON:true}).then(function(res){
      var ctrl = [], groups = { }
      this.data = res.data
      if(res.data.textures){
        // agrupamos por coincidencia en primera palabra del título (item.title).
        res.data.textures.forEach(function(item){
          var tag = item.title.split(' ')[0].toLowerCase()
          var list = groups[tag];
          if(list){
            list.push(item);
          } else {
            groups[tag] = [item];
          }
        })
        this.data.groups = groups
      }
      this.$root.loading = false
    })
  },
  methods: {
    submit : function({type, target}){
      if(!this.selected){
        return this.$root.snackbar('default','Por favor seleccione un producto y pulse Continuar.',1000)
      }
      if(!this.$root.loading){
        this.$router.push('/formular-color-y-cotizar-datos')
      }
    },
    select : function({type, target}){
      var texture = JSON.parse(target.getAttribute('json'))
      if(texture){
        this.selected = texture.id
        localStorage.setItem("texture",JSON.stringify(texture))
        $('.wp-item').removeClass('selected')
        $(target).parents('.wp-item').addClass('selected')
      }
    }
  },
  data: function() {
    return{
      selected:0,
      texture:JSON.parse(localStorage.getItem("texture"))||{},
      data:{groups:{},message:{},status:''}
    }
  }
}

const FormularColorDatos = {
  template: '#formularcolordatos',
  name:'formularcolordatos',
  mounted:function(){
    
    var token=JSON.parse(localStorage.getItem("token"))||{}
    var texture=JSON.parse(localStorage.getItem("texture"))||{}
    var quote=JSON.parse(localStorage.getItem("quote"))||{}

    if(!texture){
      return this.$root.snackbar('error','Por favor seleccione una textura');
    }

    this.texture = texture
    this.quote = quote
    this.quote.performance = texture.performance
    this.quote.textures = texture.code
    this.quote.texture_id = texture.id
    this.quote.user_id = token.id

    if(typeof(texture.id) === 'undefined'){
      return this.$root.snackbar('error','Por favor seleccione una textura')
    }
    if(this.quote.color_id === undefined){
      this.quote.color_id = ""
    }
    if(this.quote.consumer === undefined){
      this.quote.consumer = ""
    }

    this.$root.loading = true
    this.$http.post('/api/account/formularcolordatos', texture, {emulateJSON:true})
    .then(function(res){
      this.data = res.data
      this.pack_id = res.data.packs[0].id
      this.$root.loading = false
    })
  },
  methods: {
    submit : function({type, target}){
      if(this.qty === 0 || this.qty === undefined) {
        this.$root.snackbar('error','Por favor ingresa Baldes.',2000)
        this.$refs.qty.focus();
        return false
      }

      if(this.quote.color_id === 0 || this.quote.color_id === undefined) {
        this.$root.snackbar('error','Por favor ingresa Color.',2000)
        this.$refs.color_id.focus();
        return false
      }

      if(this.quote.first_name === '' || this.quote.first_name === undefined) {
        this.$root.snackbar('error','Por favor ingresa Nombre.',2000)
        this.$refs.first_name.focus();
        return false
      }

      if(this.quote.last_name === '' || this.quote.last_name === undefined) {
        this.$root.snackbar('error','Por favor ingresa Apellido.',2000)
        this.$refs.last_name.focus();
        return false
      }

      if(this.quote.consumer === '' || this.quote.consumer === undefined) {
        this.$root.snackbar('error','Por favor Tipo de usuario.',2000)
        this.$refs.consumer.focus();
        return false
      }

      this.quote.customer = [this.quote.first_name,this.quote.last_name].join(' ')
      this.quote.colors = $('#color').find(':selected').html()
      localStorage.setItem("quote",JSON.stringify(this.quote))

      this.$root.loading = true
      //this.$root.snackbar('success','Guardando cotización. Por favor espere...',1000)
      this.$http.post('/api/account/quotep', this.quote, {emulateJSON:true}).then(function(res){
        var quote = JSON.stringify(res.data)
        if(quote){
          delete quote.created
          delete quote.texture_hexcode
          if(res.status==='error'){
            self.$root.snackbar('error','Hubo un error al guardar la cotización. Por favor vuelva a intentar en unos instantes.',30000)
          }
          localStorage.setItem("quote",quote)
          this.$router.push('/formular-color-y-cotizar-cotizacion')
        }
      })
    },
    updatePack: function(){
      this.updateQuote()
      this.updateM2()
    },
    updateM2: function () {
      this.updateQuote()
      const qty = (parseFloat(this.texture.performance * parseFloat(this.m2) / parseFloat(this.quote.kg)).toFixed(1))
      this.qty = qty
      this.quote.m2 = this.m2
      this.quote.qty = qty
    },
    updateQty: function () {
      this.updateQuote()
      const m2 = (parseFloat(parseFloat(this.qty)  / this.texture.performance * parseFloat(this.quote.kg)).toFixed(1))
      this.m2 = m2
      this.quote.qty = this.qty
      this.quote.m2 = m2
    },
    updateQuote: function () {
      if(this.pack_id && this.data.packs){
        var kg = 0
        this.data.packs.forEach((pack) => {
          if(pack.id===this.pack_id){
            kg = pack.kg
          }
        })
        this.quote.kg = kg  
        this.quote.pack_id = this.pack_id
        this.quote.packs = $('#pack').find(':selected').html()
      }      
    },
  },
  data: function() {
    return{
      performance:0,
      packs:0,
      pack_id:0,
      kg:0,
      m2:0,
      qty:0,
      selection:{},
      data:{usertypes:{},colors:{},packs:{},performance:''},
      quote:{},
      texture:{}
    }
  }
}

const FormularColorCotizacion = {
  template: '#formularcolorcotizacion',
  name:'formularcolorcotizacion',
  watch: {
    selection: {
      handler: function(data, oldData) {
        if(oldData && Object.keys(oldData).length){
          this.submit(data)
        }
      },
      immediate: true,
      deep: true
    }     
  },
  mounted:function(){
    var quote = JSON.parse(localStorage.getItem("quote"))
    this.quote = JSON.parse(JSON.stringify(quote))
    this.selection = {
      qty: quote.qty,
      discount: quote.discount,
      pack_id:quote.pack_id
    }
    this.$root.loading = true
    this.$http.post('/api/account/packs', {texture_id:quote.texture_id}, {emulateJSON:true}).then(function(res){
      this.packs = res.data
      this.$root.loading = false
    })    
  },
  methods: {
    submit : function(selection){
      this.$root.processing = true

      var data = {
        id:this.quote.id,
        discount:selection.discount||0,
        qty:selection.qty,
        pack_id:selection.pack_id,
        color_id:this.quote.color_id,
        texture_id:this.quote.texture_id
      }

      this.$http.post('/api/account/quotep', data, {emulateJSON:true}).then(function(res){
        var quote = res.data

        if(res.status==='error'){
          this.$root.snackbar('error','Hubo un error al guardar la cotización. Por favor vuelva a intentar en unos instantes.',30000)
        }

        this.$root.processing = false
        localStorage.setItem("quote",JSON.stringify(quote))
        this.quote = quote
      })
    },
    download: function({type,target}){
      var uuid = $(target).attr('uuid')
      var self = this
      this.$root.filters.download({
        url: '/api/account/quote2pdf/' + uuid,
        target: target,
        type: 'application/pdf',
        filename: uuid + '.pdf',
        token: JSON.parse(localStorage.getItem("token")),
        done: () => {
          self.$root.snackbar('success','Se inició la descarga de documento PDF.',3000)
        }
      })
    }
  },
  data: function() {
    return{
      data:{},
      packs:{},
      selection:{},
      quote:{}
    }
  }
}

const BaseDeDatos = {
  template: '#basededatos',
  name:'basededatos',
  mounted:function(){
    this.$root.loading = true
    this.$http.post('/api/account/basededatos', {}, {emulateJSON:true}).then(function(res){
      this.inputs = res.data.inputs 
      this.data = JSON.parse(JSON.stringify(res.data))
      this.selection.pack = parseInt(res.data.packs[0].id)
      this.$root.loading = false
    })
  },
  methods: {
    submit: function(){
      if(!this.$root.processing){
        var message = '';
        for(var i in this.inputs.user_colorants){
          if(this.inputs.user_colorants[i]===0||this.inputs.user_colorants[i].length===0){
            message = "Ingresa un valor para cada campo <b>Colorante</b>"
          }
        }
        if(this.inputs.iva === 0 || this.inputs.iva === ''){
          message = "Ingresa un porcentaje para el campo <b>IVA</b>"
        }
        if(this.inputs.margen === 0 || this.inputs.margen === ''){
          message = "Ingresa un porcentaje para el campo <b>Margen</b>"
        }
        if(message!=''){
          return this.$root.snackbar('error',message)
        }
        this.$root.processing = true
        this.$http.post('/api/account/basededatosp', this.inputs, {emulateJSON:true}).then(function(res){
          if(res.data.status === 'success'){
            this.$root.snackbar('success','Se ha actualizado la base de datos exitosamente')
            this.data.dates = res.data.dates  
          }
          this.$root.processing = false;
        })
      }
    }
  },
  data: function() {
    return{
      data:{colorants:{},textures:{},user_colorants:{},user_textures:{},packs:{},bases:{},dates:{textures:'',colorants:''}},
      selection:{pack:0},
      dates:{},
      inputs:{colorants:{},textures:{},extra:{}}
    }
  }
}

const CotizacionesRealizadas = {
  template: '#cotizacionesrealizadas',
  name:'cotizacionesrealizadas',
  mounted:function(){
    this.$root.loading = true
    this.selection.date_since = moment().subtract(1,'week').format('D-M-YY')
    this.selection.date_until = moment().format('D-M-YY')
    this.$http.post('/api/account/quotes', {}, {emulateJSON:true}).then(function(res){
      this.data = res.data
      this.$root.loading = false
    })    
  },
  methods: {
    excel: function({type,target}){
      var since = this.selection.date_since.split('/').join('-')
      var until = this.selection.date_until.split('/').join('-')
      var self = this
      this.$root.filters.download({
        url: '/api/account/excel',
        data:{since:since,until:until,customer:this.selection.customer},
        target: target,
        type: 'text/csv',
        contentType:'application/x-www-form-urlencoded',
        filename: 'cotizaciones.csv',
        token: JSON.parse(localStorage.getItem("token")),
        done: () => {
          self.$root.snackbar('success','Se inició la descarga de documento Excel.',3000)
        }
      })
    },
    filterCustomer: function({type,target}){
      if(!this.$root.loading){
        this.$root.loading = true
        this.$http.post('/api/account/quotes', {customer: target.value}, {emulateJSON:true}).then(function(res){
          this.data = res.data
          this.$root.loading = false
        })    
      }
    },
    more:function({type,target}){
      if(target.id){
        this.$router.push('/quote/' + target.id)
      }
    }
  },
  data: function() {
    return{
      selection:{date_since:'',date_until:''},
      data:{quotes:{},customers:{}}
    }
  }
}

const Quote = {
  template: '#quote',
  name:'quote',
  mounted:function(){
    this.$root.loading = true
    this.$http.post('/api/account/quote', {uuid: location.pathname.split('/').reverse()[0]}, {emulateJSON:true}).then(function(res){
      this.quote = res.data
      this.$root.loading = false
    })    
  },
  methods: {
    download:function({type,target}){
      var uuid = $(target).attr('uuid')
      var self = this
      this.$root.filters.download({
        url: '/api/account/quote2pdf/' + uuid,
        target: target,
        type: 'application/pdf',
        filename: uuid + '.pdf',
        token: JSON.parse(localStorage.getItem("token")),
        done: () => {
          self.$root.snackbar('success','Se inició la descarga de documento PDF.',3000)
        }
      })
    }
  },
  data: function() {
    return{
      quote:{}
    }
  }
}

const Color = {
  template: '#color',
  name:'color',
  mounted:function(){
    this.$root.loading = true
    this.$http.post('/api/account/color', this.getp(), {emulateJSON:true}).then(function(res){
      if(!res.data.machine.id){
        return this.$root.snackbar('error','No hay ningún equipo asociado a esta cuenta.')
      }

      if(!this.mac_id){
        this.mac_id = res.data.machine.id
      }

      this.data.quote = res.data.quote
      this.data.machines = res.data.machines
      this.data.machine = res.data.machine
      this.data.formulas = res.data.formulas
      this.$root.loading = false
    })    
  },
  methods: {
    getp: function(){
      return {uuid: location.pathname.split('/').reverse()[0],mac_id:this.mac_id}
    },
    updateMac: function(){
      this.$root.loading = true
      this.$http.post('/api/account/color', this.getp(), {emulateJSON:true}).then(function(res){
        this.data.quote = res.data.quote
        this.data.machines = res.data.machines
        this.data.machine = res.data.machine          
        this.data.formulas = res.data.formulas
        this.$root.loading = false
      })
    },
    download:function({type,target}){
      if(!$(target).hasClass('is-loading')){
        $(target).addClass('is-loading')
        var uuid = $(target).attr('uuid')
        var self = this
        this.$http.post('/api/account/comments', {uuid:this.data.quote.uuid,comments:this.data.quote.comments}, {emulateJSON:true}).then(function(res){
          if(!this.mac_id){
            this.$root.snackbar('error','Por favor seleccione un equipo para imprimir.')
            return $(target).removeClass('is-loading')
          }
          this.$root.filters.download({
            url: '/api/account/color2pdf/' + uuid + '/' + this.mac_id,
            target: target,
            type: 'application/pdf',
            filename: uuid + '.pdf',
            token: JSON.parse(localStorage.getItem("token")),
            done: () => {
              self.$root.snackbar('success','Se inició la descarga de documento PDF.',3000)
            }
          })
        })
      }
    }
  },
  data: function() {
    return{
      selection:{},
      mac_id:0,
      data:{quote:{},machine:{},machines:{},formulas:{}}
    }
  }
}

const FormulasPropias = {
  template: '#formulaspropias',
  mounted:function(){
  },
  methods: {
  },
  data: function() {
    return{
    }
  }
}

const Historico = {
  template: '#historico',
  name:'historico',
  mounted:function(){
    this.$root.loading = true
    this.$http.post('/api/account/colors', {}, {emulateJSON:true}).then(function(res){
      this.data = res.data
      this.$root.loading = false
    })    
  },
  methods: {
    remove:function({type,target}){
      var self = this
      if(!this.$root.processing){
        $(target).addClass('is-loading')
        if(confirm("Una vez confirmado los datos no se podrán recuperar. ¿Estás seguro que deseas eliminar esta fórmula?")){
          this.$root.processing = true
          if(target.id){
            self.$http.post('/api/account/colord', {id:target.id}, {emulateJSON:true}).then(function(res){
              if(res.data.status==='success'){
                this.$root.snackbar('success','Se ha eliminado correctamente la fórmula propia.')
                self.$http.post('/api/account/colors', {}, {emulateJSON:true}).then(function(res){
                  self.data = res.data
                })    
              }
              self.$root.processing = false
              $('.input').removeClass('is-loading')
            })
          }
        }
      }
    },
    more:function({type,target}){
      if(target.id){
        this.$router.push('/color/' + target.id)
      }
    }
  },
  data: function() {
    return{
      selection:{},
      data:{colors:{}}
    }
  }
}

const FormulaPropia = {
  template: '#formulapropia',
  name:'formulapropia',
  mounted:function(){
    this.updateMac()
  },
  methods: {
    updateMac: function(){
      this.$root.loading = true
      this.$http.post('/api/account/formula', {id: location.pathname.split('/').reverse()[0],mac_id:this.mac_id}, {emulateJSON:true}).then(function(res){
        this.data = res.data
        if(!this.mac_id){
          this.mac_id = res.data.machine.id
        }           
        this.$root.loading = false
      })    
    },
    download:function({type,target}){
      if(!$(target).hasClass('is-loading')){
        $(target).addClass('is-loading')
        var colid = $(target).attr('colid')
        var colttl = $(target).attr('colttl')
        var self = this
        this.$root.filters.download({
          url: '/api/account/formula3pdf/' + colid + '/' + this.mac_id,
          target: target,
          type: 'application/pdf',
          filename: colttl + '.pdf',
          token: JSON.parse(localStorage.getItem("token")),
          done: () => {
            self.$root.snackbar('success','Se inició la descarga de documento PDF.',3000)
          }
        })
      }
    }    
  },  
  data: function() {
    return{
      mac_id:0,
      data:{color:{},formulas:{},machine:{},machines:{}}
    }
  }
}

const CargarFormulasPropias = {
  template: '#cargarformulaspropias',
  name:'cargarformulaspropias',
  mounted:function(){
    this.updateMac()
  },
  methods: {
    setTexture: function({type,target}){
      if(target){
        this.selection.texture.code = target.options[target.selectedIndex].getAttribute('code')
        this.selection.texture.hexcode = target.options[target.selectedIndex].getAttribute('hexcode')
      }
    },
    setBase: function({type,target}){
      if(target){
        this.selection.base.code = target.options[target.selectedIndex].getAttribute('code')
      }
    },
    updateMac: function(){
      this.$root.loading = true
      this.$http.post('/api/account/cargarformulaspropias', {mac_id:this.mac_id}, {emulateJSON:true}).then(function(res){
        this.data = res.data

        if(!res.data.machine.id){
          return this.$root.snackbar('error','No hay ningún equipo asociado a esta cuenta.')
        }

        if(!this.mac_id){
          this.mac_id = res.data.machine.id
        } 
        
        if(!this.selection.texture.code){
          this.selection.texture = res.data.textures[0]
          this.color.texture_id = res.data.textures[0].id
        }

        if(!this.selection.base.code){
          this.selection.base = res.data.bases[0]
          this.color.base_id = res.data.bases[0].id
        }

        this.data.colorants.forEach((colorant) => {
          this.color.units[colorant.id] = {}
          this.data.units.forEach((unit) => {
            this.color.units[colorant.id][unit] = 0
          })
        })

        this.color.mac_id = this.mac_id
        this.$root.loading = false
      })
    },    
    submit: function(){
      this.$root.loading = true;
      this.$http.post('/api/account/cargarformulaspropiasp', this.color, {emulateJSON:true}).then(function(res){
        if(res.data.status === 'success'){
          this.$root.snackbar('success','Se ha cargado la fórmula exitosamente.')
        }
        this.$root.loading = false
        //this.$router.push('/formular-color-y-cotizar-datos')
      })
      return false;
    }
  },
  data: function() {
    return{
      color:{units:{}},
      mac_id:0,
      data:{colorants:{},textures:{},bases:{},machine:{}},
      selection:{colorant:0,texture:{},base:{}}
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
      data:{message:'',status:''}
    }
  }
}

const EditAccount = {
  template: '#editaccount',
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
      var code = this.code
      reader.onload = (e) => {
        var $id = $('#img'+code);
        $id.css({
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
    clickImage : function(code){
      this.upload = true
      this.code = code
      $("#uploads").click()
      return false
    },
    uploadImage : function(file){
      this.upload = true
      var code = this.code
      var formData = new FormData();
      formData.append('uploads[]', file);
      var token = $.parseJSON(localStorage.getItem("token")) || {}
      var self = this

      this.$root.loading = true
      this.$root.snackbar('success','Cargando imagen...')
      //loading
      //$('.profile'+type+'--link').text("Subiendo...");
      $.ajax({
        type:'post',
        url: '/api/account/profile-picture',
        data:formData,
        beforeSend: function (xhr) { 
          xhr.setRequestHeader('Authorization', 'Bearer ' + token.token); 
        },          
        xhr: function() {
          var myXhr = $.ajaxSettings.xhr();
          if(myXhr.upload){
            myXhr.upload.addEventListener('progress',function(e){
              if(e.lengthComputable){
                var max = e.total;
                var current = e.loaded;
                var percentage = (current * 100)/max;

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
            self.$root.loading = false
            self.$root.snackbar('success','Image has been correctly uploaded.')
          }
        },
        error: function(data){
          self.$root.loading = false
          self.$root.snackbar('error','Image has not been uploaded.')
          console.log("Hubo un error al subir el archivo");
        }
      })
    },    
    submit : function({type, target}){
      if(!this.$root.loading){
        this.$root.loading = true
        var data = {}

        $.map( $(target).serializeArray(), function( i ) {
          data[i.name] = i.value
        })

        this.$http.post('/api/account/update', data, {emulateJSON:true}).then(function(res){
          this.data = res.data
          var token = $.parseJSON(localStorage.getItem("token")) || {}

          token.first_name = this.data.first_name
          token.last_name = this.data.last_name
          token.email = this.data.email
          localStorage.setItem("token", JSON.stringify(token))

          this.$root.loading = false
          this.$root.snackbar('success','Cuenta actualizada.')

          //helper.is_loaded()
        }, function(error){
          this.$root.loading = false
          this.$root.snackbar('error',error.statusText)
          console.log(error.statusText)
        })
      }
    }
  },
  data: function() {
    return{
      acceptTerms:false,      
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
        var data = {}

        $.map( $(target).serializeArray(), function( i ) {
          data[i.name] = i.value
        })

        this.$http.post('/api/account/password', data, {emulateJSON:true}).then(function(res){
          this.$root.loading = false
          this.$root.snackbar(res.data.messageType,res.data.message)
          //helper.is_loaded()
        }, function(error){
          this.$root.loading = false
          this.$root.snackbar('error',error.statusText)
          console.log(error.statusText)
        })
      }
    }
  },
  data: function() {
    return{
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
    this.$http.post('/api/sections'+location.pathname, {}, {emulateJSON:true}).then(function(res){
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
      //helper.is_loaded()
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
    {path: '/recover-password', component: RecoverPassword,  meta : { title: 'Recuperar contraseña'}},
    {path: '/update-password', component: UpdatePassword,  meta : { title: 'Actualizar contraseña'}},
    {path: '/session-ended', component: SessionEnded, meta : { title: 'Sesión finalizada'}},
    {path: '/session-expired', component: SessionExpired, meta : { title: 'Sesión expirada'}},
    {path: '/contact', component: Contact, meta : { title: 'Contacto'}},    
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
    filters.refreshToken()
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
    var ref = to.path.split('/').join('_')
    var token = $.parseJSON(localStorage.getItem("token")) || {}
    var offset = getOffset()
    $('.navbar-brand').removeClass('is-active')
    $('.navbar-end .navbar-tabs li').removeClass('is-active')
    $('.navbar-end .navbar-tabs ul').find('a[href="' + to.path + '"]').parent().addClass('is-active')
    $('.navbar-menu, .navbar-burger').removeClass('is-active')
    $('.ui-snackbar').removeClass('ui-snackbar--is-active').addClass('ui-snackbar--is-inactive')
    $('.wp-action-space, .navbar').css({'left': offset + 'px'})
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
    messageType:'default',
    message:'',
    filters:filters
  },
  watch: {
    '$route' (to, from) {
      this.checkFlags(to)
    }
  },
  mounted: function() {
    adjustPadding()
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
      var body = $("html, body");
      body.stop().animate({scrollTop:$(document).height()}, 500, 'swing', function() { 
      });
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
    },
    unitLabel : function(value){
      var unit = '';
      if(value==='g'){
        unit = 'gramos'
      } else if(value==='ml'){
        unit = 'mililitros'
      } else if(value==='y'){
        unit = 'onzas'
      } else if(value==='p'){
        unit = 'pulsos'
      } else if(value==='f'){
        unit = 'fracción'
      }
      return unit
    },
  }
}).$mount('#app')